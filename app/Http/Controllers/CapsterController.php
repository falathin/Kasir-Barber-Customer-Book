<?php

namespace App\Http\Controllers;

use App\Models\Capster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CapsterController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = Capster::orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('inisial', 'like', "%{$search}%")
                  ->orWhere('no_hp', 'like', "%{$search}%")
                  ->orWhere('asal', 'like', "%{$search}%");
            });
        }

        $capsters = $query->paginate(10);
        return view('capsters.index', compact('capsters'));
    }

    public function create()
    {
        return view('capsters.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'nama.required'       => 'Nama capster wajib diisi.',
            'nama.string'         => 'Nama capster harus berupa teks.',
            'nama.max'            => 'Nama capster maksimal :max karakter.',

            'inisial.required'    => 'Inisial wajib diisi.',
            'inisial.string'      => 'Inisial harus berupa teks.',
            'inisial.max'         => 'Inisial maksimal :max karakter.',
            'inisial.unique'      => 'Inisial ":input" sudah terdaftar.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus "L" atau "P".',

            'no_hp.required'      => 'Nomor handphone wajib diisi.',
            'no_hp.string'        => 'Nomor handphone harus berupa teks.',
            'no_hp.max'           => 'Nomor handphone maksimal :max karakter.',

            'tgl_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.date'      => 'Tanggal lahir tidak valid.',

            'asal.required'       => 'Asal wajib diisi.',
            'asal.string'         => 'Asal harus berupa teks.',
            'asal.max'            => 'Asal maksimal :max karakter.',

            'foto.image'          => 'File harus berupa gambar.',
            'foto.max'            => 'Ukuran gambar maksimal 2MB.',
        ];

        $data = $request->validate([
            'nama'           => 'required|string|max:255',
            'inisial'        => 'required|string|max:10|unique:capsters,inisial',
            'jenis_kelamin'  => 'required|in:L,P',
            'no_hp'          => 'required|string|max:20',
            'tgl_lahir'      => 'required|date',
            'asal'           => 'required|string|max:255',
            'foto'           => 'nullable|image|max:2048',
        ], $messages);

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
        $messages = [
            'nama.required'       => 'Nama capster wajib diisi.',
            'nama.string'         => 'Nama capster harus berupa teks.',
            'nama.max'            => 'Nama capster maksimal :max karakter.',

            'inisial.required'    => 'Inisial wajib diisi.',
            'inisial.string'      => 'Inisial harus berupa teks.',
            'inisial.max'         => 'Inisial maksimal :max karakter.',
            'inisial.unique'      => 'Inisial ":input" sudah terdaftar.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus "L" atau "P".',

            'no_hp.required'      => 'Nomor handphone wajib diisi.',
            'no_hp.string'        => 'Nomor handphone harus berupa teks.',
            'no_hp.max'           => 'Nomor handphone maksimal :max karakter.',

            'tgl_lahir.required'  => 'Tanggal lahir wajib diisi.',
            'tgl_lahir.date'      => 'Tanggal lahir tidak valid.',

            'asal.required'       => 'Asal wajib diisi.',
            'asal.string'         => 'Asal harus berupa teks.',
            'asal.max'            => 'Asal maksimal :max karakter.',

            'foto.image'          => 'File harus berupa gambar.',
            'foto.max'            => 'Ukuran gambar maksimal 2MB.',
        ];

        $data = $request->validate([
            'nama'           => 'required|string|max:255',
            'inisial'        => 'required|string|max:10|unique:capsters,inisial,' . $capster->id,
            'jenis_kelamin'  => 'required|in:L,P',
            'no_hp'          => 'required|string|max:20',
            'tgl_lahir'      => 'required|date',
            'asal'           => 'required|string|max:255',
            'foto'           => 'nullable|image|max:2048',
        ], $messages);

        if ($request->hasFile('foto')) {
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