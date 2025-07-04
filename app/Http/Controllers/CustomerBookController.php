<?php

namespace App\Http\Controllers;

use App\Models\CustomerBook;
use App\Models\Capster;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $barber = $request->input('barber');
        $user = auth()->user();

        $books = CustomerBook::query()
            ->when($search, fn($q) => $q->where(function ($query) use ($search) {
                $query->where('customer', 'like', "%{$search}%")
                    ->orWhere('haircut_type', 'like', "%{$search}%")
                    ->orWhere('cap', 'like', "%{$search}%");
            }))
            ->when($user->level !== 'admin', fn($q) => $q->where('barber_name', $user->name))
            ->when($user->level === 'admin' && $barber, fn($q) => $q->where('barber_name', $barber))
            ->latest()
            ->paginate(10)
            ->appends(compact('search', 'barber'));

        $barbers = $user->level === 'admin'
            ? CustomerBook::select('barber_name')->distinct()->pluck('barber_name')
            : collect([$user->name]);

        // hitung pending (price=0 & no service)
        $pendingCount = CustomerBook::where('price', 0)
            ->whereNull('colouring_other')
            ->count();

        return view('customer_books.index', compact('books', 'barbers', 'search', 'barber', 'pendingCount'));
    }

    public function create()
    {
        $capsters = Capster::all();
        $filtering = User::where('level', 'kasir')->get();

        // Hitung antrian untuk hari ini
        $today = now()->startOfDay();
        $nextAntrian = CustomerBook::whereDate('created_at', $today)->max('antrian') + 1;

        return view('customer_books.create', compact('capsters', 'filtering', 'nextAntrian'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|string',
            'cap' => 'required|string',
            // 'asisten' => 'nullable|string',
            'haircut_type' => 'required|string',
            'barber_name' => 'required|string',
            // 'colouring_other' => 'nullable|string',
            // 'sell_use_product' => 'nullable|string',
            // 'price' => 'required|string',
            // 'qr' => 'nullable|string',
            // 'rincian' => 'nullable|string',
            'created_time' => 'nullable|date',
            'antrian' => 'nullable|integer|min:1',
        ]);

        $customerBook = CustomerBook::create($data);

        return redirect()->route('customer-books.show', $customerBook->id)
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
        $filtering = User::where('level', 'kasir')->get();
        return view('customer_books.edit', compact('customerBook', 'capsters', 'filtering'));
    }

    public function update(Request $request, CustomerBook $customerBook)
    {
        $data = $request->validate([
            'customer'         => 'required|string',
            'cap'              => 'required|string',
            'asisten'          => 'nullable|string',
            'haircut_type'     => 'required|string',
            'barber_name'      => 'required|string',
            'colouring_other'  => 'nullable|string',
            'sell_use_product' => 'nullable|string',
            'price'            => 'required|string',
            'qr'               => 'nullable|string',
            'rincian'          => 'nullable|string',
            'created_time'     => 'nullable|date',
        ]);

        $customerBook->update($data);

        // Redirect ke halaman 'show' untuk CustomerBook yang di-update
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