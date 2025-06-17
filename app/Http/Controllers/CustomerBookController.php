<?php

namespace App\Http\Controllers;

use App\Models\CustomerBook;
use App\Models\Capster;
use Illuminate\Http\Request;

class CustomerBookController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $barber = $request->input('barber');

        $books = CustomerBook::query()
            ->when($search, function ($query, $search) {
                $query->where('customer', 'like', '%' . $search . '%')
                    ->orWhere('haircut_type', 'like', '%' . $search . '%')
                    ->orWhere('cap', 'like', '%' . $search . '%');
            })
            ->when($barber, function ($query, $barber) {
                $query->where('barber_name', $barber);
            })
            ->latest()
            ->paginate(10)
            ->appends(['search' => $search, 'barber' => $barber]);

        $barbers = CustomerBook::select('barber_name')->distinct()->pluck('barber_name');

        return view('customer_books.index', compact('books', 'barbers', 'search', 'barber'));
    }

    public function create()
    {
        $capsters = Capster::all();
        return view('customer_books.create', compact('capsters'));
    }
    public function store(Request $request)
    {
        $data = $request->validate([
            'customer' => 'required|string',
            'cap' => 'required|string',
            'haircut_type' => 'required|string',
            'barber_name' => 'required|string',
            'colouring_other' => 'nullable|string',
            'sell_use_product' => 'nullable|string',
            'price' => 'required|string',
            'qr' => 'nullable|string',
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
        return view('customer_books.edit', compact('customerBook', 'capsters'));
    }

    public function update(Request $request, CustomerBook $customerBook)
    {
        $data = $request->validate([
            'customer' => 'required|string',
            'cap' => 'required|string',
            'haircut_type' => 'required|string',
            'barber_name' => 'required|string',
            'colouring_other' => 'nullable|string',
            'sell_use_product' => 'nullable|string',
            'price' => 'required|string',
            'qr' => 'nullable|string',
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