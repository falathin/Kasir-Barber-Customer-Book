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
        $user = auth()->user();
        $today = \Carbon\Carbon::today();

        // ======================
        // REQUEST PARAMS
        // ======================
        $search    = $request->search;
        $barber    = $request->barber;
        $status    = in_array($request->status, ['antre', 'proses', 'done']) ? $request->status : null;
        $startDate = $request->start_date;
        $endDate   = $request->end_date;
        $showAll   = $request->show === 'all' || $search;

        // ======================
        // BASE QUERY
        // ======================
        $query = \App\Models\CustomerBook::query()

            // DATE FILTER
            ->when($startDate && $endDate, function ($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [
                    \Carbon\Carbon::parse($startDate)->startOfDay(),
                    \Carbon\Carbon::parse($endDate)->endOfDay(),
                ]);
            }, function ($q) use ($today, $showAll) {
                if (! $showAll) {
                    $q->whereDate('created_at', $today);
                }
            })

            // SEARCH (ALL COLUMNS)
            ->when($search, function ($q) use ($search) {
                $q->where(function ($s) use ($search) {
                    $s->where('customer', 'like', "%{$search}%")
                    ->orWhere('cap', 'like', "%{$search}%")
                    ->orWhere('asisten', 'like', "%{$search}%")
                    ->orWhere('haircut_type', 'like', "%{$search}%")
                    ->orWhere('barber_name', 'like', "%{$search}%")
                    ->orWhere('colouring_other', 'like', "%{$search}%")
                    ->orWhere('sell_use_product', 'like', "%{$search}%")
                    ->orWhere('antrian', 'like', "%{$search}%")
                    ->orWhere('qr', 'like', "%{$search}%")
                    ->orWhere('price', 'like', "%{$search}%")
                    ->orWhere('hair_coloring_price', 'like', "%{$search}%")
                    ->orWhere('hair_extension_price', 'like', "%{$search}%")
                    ->orWhere('hair_extension_services_price', 'like', "%{$search}%");
                });
            })

            // ROLE FILTER
            ->when($user->level !== 'admin', fn ($q) =>
                $q->where('barber_name', $user->name)
            )

            ->when($user->level === 'admin' && $barber, fn ($q) =>
                $q->where('barber_name', $barber)
            )

            // STATUS FILTER (FIX & CONSISTENT)
            ->when($status, function ($q) use ($status) {

                // DONE
                if ($status === 'done') {
                    $q->whereNotNull('price')
                    ->whereNotNull('qr')
                    ->where(function ($s) {
                        $s->whereNotNull('colouring_other')
                            ->orWhereNotNull('hair_coloring_price')
                            ->orWhereNotNull('hair_extension_price')
                            ->orWhereNotNull('hair_extension_services_price');
                    });
                }

                // PROSES
                if ($status === 'proses') {
                    $q->whereNotNull('cap')
                    ->whereNull('price')
                    ->whereNull('qr');
                }

                // ANTRE
                if ($status === 'antre') {
                    $q->whereNull('cap')
                    ->whereNotNull('customer')
                    ->whereNotNull('barber_name')
                    ->whereNotNull('antrian');
                }
            });

        // ======================
        // RESULT
        // ======================
        $books = $query->latest()
            ->paginate(15)
            ->appends($request->query());

        // ======================
        // SUPPORT DATA
        // ======================
        $totalToday = \App\Models\CustomerBook::whereDate('created_at', $today)->count();

        $barbers = $user->level === 'admin'
            ? \App\Models\CustomerBook::select('barber_name')
                ->whereNotNull('barber_name')
                ->distinct()
                ->pluck('barber_name')
            : collect([$user->name]);

        // ======================
        // VIEW
        // ======================
        return view('customer_books.index', compact(
            'books',
            'barbers',
            'search',
            'barber',
            'status',
            'totalToday',
            'showAll',
            'startDate',
            'endDate'
        ));
    }

    public function create()
    {
        // Ambil capster aktif
        $capsters = Capster::where('status', 'Aktif')->get();

        // Ambil user kasir
        $filtering = User::where('level', 'kasir')->get();

        $user = auth()->user();
        $today = now()->toDateString();

        $query = CustomerBook::whereDate('created_at', $today);

        // Kalau BUKAN admin & kasir → baru difilter barber_name
        if (!in_array($user->level, ['admin', 'kasir'])) {
            $query->where('barber_name', $user->name);
        }

        $nextAntrian = ($query->max('antrian') ?? 0) + 1;

        return view('customer_books.create', compact(
            'capsters',
            'filtering',
            'nextAntrian'
        ));
    }

    public function createWithCapster(CustomerBook $book)
    {
        $today = now()->startOfDay();
        $barberName = $book->barber_name;

        // Ambil semua capster yang aktif, atau capster yang sedang digunakan oleh `$book`
        $capsters = Capster::where('status', 'Aktif')
            ->orWhere('id', $book->capster_id)
            ->get();

        $nextAntrian = CustomerBook::whereDate('created_at', $today)
            ->where('barber_name', $barberName)
            ->max('antrian') + 1;

        return view('customer_books.createWithCap', [
            'book' => $book,
            'capsters' => $capsters,
            'nextAntrian' => $nextAntrian,
        ]);
    }

    public function storeWithCapster(Request $request, CustomerBook $book)
    {
        $data = $request->validate([
            'cap' => 'required|string',
        ], [
            'cap.required' => 'Capster wajib dipilih.',
            'cap.string' => 'Format capster tidak valid.',
        ]);

        $book->update(['cap' => $data['cap']]);

        return redirect()
            ->route('customer-books.show', $book->id)
            ->with('success', 'Proses capster berhasil disimpan.');
    }

    public function store(Request $request)
    {
        $messages = [
            'customer.required'    => 'Nama pelanggan wajib diisi.',
            'customer.string'      => 'Nama pelanggan harus berupa teks.',
            'haircut_type.required'=> 'Jenis potongan rambut wajib diisi.',
            'haircut_type.string'  => 'Jenis potongan rambut harus berupa teks.',
            'barber_name.required' => 'Nama barber wajib diisi.',
            'barber_name.string'   => 'Nama barber harus berupa teks.',
            'created_time.date'    => 'Format waktu pembuatan tidak valid.',
            'antrian.integer'      => 'Nomor antrian harus berupa angka.',
            'antrian.min'          => 'Nomor antrian minimal :min.',
        ];

        $data = $request->validate([
            'customer'     => 'required|string',
            'haircut_type' => 'required|string',
            'barber_name'  => 'required|string',
            'created_time' => 'nullable|date',
            'antrian'      => 'nullable|integer|min:1',
        ], $messages);

        CustomerBook::create($data);

        return redirect()
            ->route('customer-books.index')
            ->with('success', 'Customer book berhasil dibuat.');
    }

    public function show(CustomerBook $customerBook)
    {
        $customerBook->load('capster');
        return view('customer_books.show', compact('customerBook'));
    }

    public function edit(CustomerBook $customerBook)
    {
        $capsters = Capster::where('status', 'Aktif')
            ->orWhere('id', $customerBook->capster_id)
            ->get();

        $filtering = User::where('level', 'kasir')->get();

        $canInputManualPrice = auth()->user()->level === 'admin';

        return view('customer_books.edit', compact(
            'customerBook',
            'capsters',
            'filtering',
            'canInputManualPrice'
        ));
    }

    public function update(Request $request, CustomerBook $customerBook)
    {
        // Manual price field names (these should match the input hidden names)
        $manualFields = [
            'hair_coloring_price',
            'hair_extension_price',
            'hair_extension_services_price'
        ];

        // Normalize manual fields: keep digits-only or null
        foreach ($manualFields as $f) {
            $val = $request->input($f, null);
            if ($val !== null && $val !== '') {
                // remove non-digits
                $clean = preg_replace('/\D/', '', (string)$val);
                $request->merge([$f => ($clean === '' ? null : $clean)]);
            } else {
                $request->merge([$f => null]);
            }
        }

        $rules = [
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
            // manual columns: store as string (digits) or null
            'hair_coloring_price' => 'nullable|string',
            'hair_extension_price' => 'nullable|string',
            'hair_extension_services_price' => 'nullable|string',
        ];

        $messages = [
            'customer.required'   => 'Nama pelanggan wajib diisi.',
            'cap.required'        => 'Capster wajib dipilih.',
            'haircut_type.required'=> 'Jenis potongan rambut wajib diisi.',
            'barber_name.required'=> 'Nama barber wajib diisi.',
            'price.required'      => 'Harga wajib diisi.',
            'price.numeric'       => 'Harga harus berupa angka.',
            'price.gt'            => 'Harga harus lebih besar dari nol.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        $validator->after(function ($validator) use ($request) {
            if (
                $request->filled('cap') &&
                $request->filled('asisten') &&
                $request->cap === $request->asisten
            ) {
                $validator->errors()->add('asisten', 'Capster dan Asisten tidak boleh sama.');
            }
        });

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Save validated data. The manual fields are digits-only strings or null.
        $customerBook->update($validator->validated());

        return redirect()
            ->route('customer-books.show', $customerBook->id)
            ->with('success', 'Customer book berhasil diperbarui.');
    }

    public function destroy(CustomerBook $customerBook)
    {
        $customerBook->delete();
        return redirect()->route('customer-books.index')
                         ->with('success', 'Customer book berhasil dihapus.');
    }
}
