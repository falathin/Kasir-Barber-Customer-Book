<?php

namespace App\Http\Controllers;

use App\Models\CustomerBook;
use App\Models\Capster;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CustomerBookController extends Controller
{

    public function index(Request $request)
    {
        $showAll = $request->input('show') === 'all'; // tambahkan ini
        $today = Carbon::today();

        $search = $request->input('search');
        $barber = $request->input('barber');
        $status = in_array($request->input('status'), ['antre', 'proses', 'done'])
            ? $request->input('status')
            : null;
        $user = auth()->user();

        $query = CustomerBook::query()
            ->when(!$showAll, fn($q) => $q->whereDate('created_at', $today)) // filter hari ini kalau show != all
            ->when($search, fn($q) => $q->where(function ($q2) use ($search) {
                $q2->where('customer', 'like', "%{$search}%")
                    ->orWhere('haircut_type', 'like', "%{$search}%")
                    ->orWhere('cap', 'like', "%{$search}%");
            }))
            ->when($user->level !== 'admin', fn($q) => $q->where('barber_name', $user->name))
            ->when($user->level === 'admin' && $barber, fn($q) => $q->where('barber_name', $barber))
            ->when($status, function ($q) use ($status) {
                if ($status === 'done') {
                    $q->whereNotNull('price')
                    ->whereNotNull('colouring_other')
                    ->whereNotNull('qr');
                } elseif ($status === 'proses') {
                    $q->whereNotNull('cap')
                    ->whereNotNull('customer')
                    ->whereNotNull('barber_name')   
                    ->whereNull('colouring_other')
                    ->whereNull('qr');
                } elseif ($status === 'antre') {
                    $q->whereNull('cap')
                    ->whereNotNull('customer')
                    ->whereNotNull('barber_name')
                    ->whereNotNull('antrian')
                    ->whereNotNull('haircut_type');
                }
            });

        $totalToday = CustomerBook::whereDate('created_at', $today)->count();

        $books = $query->latest()
            ->paginate(10)
            ->appends($request->query());

        $barbers = $user->level === 'admin'
            ? CustomerBook::select('barber_name')->distinct()->pluck('barber_name')
            : collect([$user->name]);

        return view('customer_books.index', compact(
            'books', 'barbers', 'search', 'barber', 'status', 'totalToday', 'showAll'
        ));
    }

    public function create()
    {
        $capsters = Capster::all();
        $filtering = User::where('level', 'kasir')->get();

        // Ambil user login saat ini
        $user = auth()->user();

        // Hitung antrian berdasarkan barber_name dan hari ini
        $today = now()->toDateString(); // tanggal saja
        $nextAntrian = CustomerBook::whereDate('created_at', $today)
            ->where('barber_name', $user->name)
            ->max('antrian') + 1;

        return view('customer_books.create', compact('capsters', 'filtering', 'nextAntrian'));
    }


    public function createWithCapster(CustomerBook $book)
    {
        $capsters = Capster::all();
        $today = now()->startOfDay();

        // Hitung antrian per barber
        $barberName = $book->barber_name;

        $nextAntrian = CustomerBook::whereDate('created_at', $today)
            ->where('barber_name', $barberName)
            ->max('antrian') + 1;

        return view('customer_books.createWithCap', [
            'book' => $book,
            'capsters' => $capsters,
            'nextAntrian' => $nextAntrian,
        ]);
    }

    /**
     * Proses update cap & antrian (mirip update())
     */
    public function storeWithCapster(Request $request, CustomerBook $book)
    {
        $data = $request->validate([
            'cap' => 'required|string',
            // 'antrian' => 'required|integer|min:1',
        ]);

        $book->update([
            'cap' => $data['cap'],
            // 'antrian' => $data['antrian'],
        ]);

        return redirect()
            ->route('customer-books.show', $book->id)
            ->with('success', 'Proses capster berhasil disimpan.');
    }

    
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer'        => 'required|string',
            // 'cap'           => 'nullable|string',
            // 'asisten'       => 'nullable|string',
            'haircut_type'    => 'required|string',
            'barber_name'     => 'required|string',
            // 'colouring_other'=> 'nullable|string',
            // 'sell_use_product'=>'nullable|string',
            // 'price'         => 'nullable|string',
            // 'qr'            => 'nullable|string',
            // 'rincian'       => 'nullable|string',
            'created_time'    => 'nullable|date',
            'antrian'         => 'nullable|integer|min:1',
        ]);

        $customerBook = CustomerBook::create($data);

        // Redirect ke halaman index, bukan show
        return redirect()
            ->route('customer-books.index')
            ->with('success', 'Customer book created successfully.');
    }

    public function show(CustomerBook $customerBook)
    {
        $customerBook->load('capster');
        return view('customer_books.show', compact('customerBook'));
    }
    public function edit(CustomerBook $customerBook)
    {
        $capsters = Capster::all();
        $capsters2 = Capster::all();
        $filtering = User::where('level', 'kasir')->get();
        return view('customer_books.edit', compact('customerBook', 'capsters', 'filtering','capsters2'));
    }

    public function update(Request $request, CustomerBook $customerBook)
    {
        $validator = Validator::make($request->all(), [
            'customer'         => 'required|string',
            'cap'              => 'required|string',
            'asisten'          => 'nullable|string',
            'haircut_type'     => 'required|string',
            'barber_name'      => 'required|string',
            'colouring_other'  => 'nullable|string',
            'sell_use_product' => 'nullable|string',
            'price'            => 'required|numeric|gt:0',
            'qr'               => 'nullable|string',
            'rincian'          => 'nullable|string',
            'created_time'     => 'nullable|date',
        ]);

        // Validasi tambahan: cap dan asisten tidak boleh sama
        $validator->after(function ($validator) use ($request) {
            if (
                $request->filled('cap') &&
                $request->filled('asisten') &&
                $request->cap === $request->asisten
            ) {
                $validator->errors()->add('asisten', 'Capster dan Asisten tidak boleh sama.');
            }
        });

        // Jika gagal validasi
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validasi sukses, update data
        $customerBook->update($validator->validated());

        return redirect()
            ->route('customer-books.show', $customerBook->id)
            ->with('success', 'Customer book updated successfully.');
    }

    public function destroy(CustomerBook $customerBook)
    {
        $customerBook->delete();
        return redirect()->route('customer-books.index')->with('success', 'Customer book deleted.');
    }
}