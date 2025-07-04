<?php

namespace App\Http\Controllers;

use App\Models\Capster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;  // ← import Storage

class CapsterController extends Controller
{
    public function index(Request $request)
    {
        // Get the search term from the request
        $search = $request->input('search');

        // Start building the query
        $query = Capster::orderBy('created_at', 'desc'); // Menampilkan capster terbaru di atas

        // If a search term is provided, apply the filter
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%')
                    ->orWhere('inisial', 'like', '%' . $search . '%')
                    ->orWhere('no_hp', 'like', '%' . $search . '%')
                    ->orWhere('asal', 'like', '%' . $search . '%');
            });
        }

        // Paginate the results
        $capsters = $query->paginate(10);

        return view('capsters.index', compact('capsters'));
    }
    public function create()
    {
        return view('capsters.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'inisial' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|string|max:20',
            'tgl_lahir' => 'required|date',
            'asal' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('capsters', 'public');
        }

        Capster::create($data);

        return redirect()
            ->route('capsters.index')
            ->with('success', 'Capster berhasil ditambahkan.');
    }

    public function show(Capster $capster)
    {
        return view('capsters.show', compact('capster'));
    }

    public function edit(Capster $capster)
    {
        return view('capsters.edit', compact('capster'));
    }

    public function update(Request $request, Capster $capster)
    {
        $data = $request->validate([
            'nama' => 'required|string|max:255',
            'inisial' => 'required|string|max:10',
            'jenis_kelamin' => 'required|in:L,P',
            'no_hp' => 'required|string|max:20',
            'tgl_lahir' => 'required|date',
            'asal' => 'required|string|max:255',
            'foto' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            // hapus file lama jika ada
            if ($capster->foto) {
                Storage::disk('public')->delete($capster->foto);
            }
            $data['foto'] = $request->file('foto')->store('capsters', 'public');
        }

        $capster->update($data);

        return redirect()
            ->route('capsters.index')
            ->with('success', 'Capster berhasil diubah.');
    }

    public function destroy(Capster $capster)
    {
        if ($capster->foto) {
            Storage::disk('public')->delete($capster->foto);
        }
        $capster->delete();

        return redirect()
            ->route('capsters.index')
            ->with('success', 'Capster berhasil dihapus.');
    }
}
