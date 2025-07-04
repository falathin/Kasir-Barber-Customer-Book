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
            ->when($user->level !== 'admin', fn($q) => $q->where('barber_name', $user->name)) // <-- Filter untuk kasir
            ->when($user->level === 'admin' && $barber, fn($q) => $q->where('barber_name', $barber))
            ->latest()
            ->paginate(10)
            ->appends(compact('search', 'barber'));

        // Daftar barber_name untuk dropdown filter (jika admin)
        $barbers = $user->level === 'admin'
            ? CustomerBook::select('barber_name')->distinct()->pluck('barber_name')
            : collect([$user->name]);

        return view('customer_books.index', compact('books', 'barbers', 'search', 'barber'));
    }


    public function create()
    {
        $capsters = Capster::all(); // Mengambil semua capster
        $filtering = User::where('level', 'kasir')->get();

        return view('customer_books.create', compact('capsters', 'filtering'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|string',
            'cap' => 'required|string',
            'asisten' => 'nullable|string', // <-- tambahkan ini
            'haircut_type' => 'required|string',
            'barber_name' => 'required|string',
            'colouring_other' => 'nullable|string',
            'sell_use_product' => 'nullable|string',
            'price' => 'required|string',
            'qr' => 'nullable|string',
            'rincian' => 'nullable|string',
            'created_time' => 'nullable|date'
        ]);


        CustomerBook::create($data);

        return redirect()->route('customer-books.index')->with('success', 'Customer book created successfully.');
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
            'customer' => 'required|string',
            'cap' => 'required|string',
            'asisten' => 'nullable|string', // <-- tambahkan ini
            'haircut_type' => 'required|string',
            'barber_name' => 'required|string',
            'colouring_other' => 'nullable|string',
            'sell_use_product' => 'nullable|string',
            'price' => 'required|string',
            'qr' => 'nullable|string',
            'rincian' => 'nullable|string',
            'created_time' => 'nullable|date'
        ]);

        $customerBook->update($data);

        return redirect()->route('customer-books.index')->with('success', 'Customer book updated successfully.');
    }

    public function destroy(CustomerBook $customerBook)
    {
        $customerBook->delete();
        return redirect()->route('customer-books.index')->with('success', 'Customer book deleted.');
    }
}