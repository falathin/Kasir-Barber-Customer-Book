<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class KasirController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cashiers = User::where('level', 'kasir')->get();
        return view('cashiers.index', compact('cashiers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cashiers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => 'kasir',
        ]);

        return redirect()->route('kasirs.index')->with('success', 'Akun kasir berhasil dibuat.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $cashier = User::findOrFail($id);
        return view('cashiers.edit', compact('cashier'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $cashier = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $cashier->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $cashier->name = $request->name;
        $cashier->email = $request->email;

        if ($request->filled('password')) {
            $cashier->password = Hash::make($request->password);
        }

        $cashier->save();

        return redirect()->route('kasirs.index')->with('success', 'Akun kasir berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cashier = User::findOrFail($id);
        $cashier->delete();
        return redirect()->route('kasirs.index')->with('success', 'Kasir berhasil dihapus.');
    }
}
