<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Models\CustomerBook;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index(Note $note = null)
    {
        $user = Auth::user();
        $today = Carbon::today();

        $notes = Note::latest()->get();

        // Cek apakah kasir sudah buat catatan hari ini
        $todayNoteExists = Note::whereDate('created_at', $today)
            ->where('kasir_name', $user->name)
            ->exists();

        // Ambil data customer book sesuai role
        if ($user->role === 'admin') {
            $customerBooks = CustomerBook::whereDate('created_at', $today)
                ->orderBy('created_time')
                ->get()
                ->groupBy('barber_name');
        } else {
            $customerBooks = CustomerBook::whereDate('created_at', $today)
                ->where('barber_name', $user->name)
                ->orderBy('created_time')
                ->get()
                ->groupBy('barber_name');
        }

        return view('notes.index', compact('notes', 'note', 'customerBooks', 'todayNoteExists'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today();

        // Cek apakah kasir sudah membuat catatan hari ini
        $existingNote = Note::whereDate('created_at', $today)
            ->where('kasir_name', $user->name)
            ->first();

        if ($existingNote) {
            return redirect()->route('notes.index')->with('error', 'Catatan hari ini sudah ada.');
        }

        $request->validate(['note' => 'required|string']);

        Note::create([
            'note' => $request->note,
            'kasir_name' => $user->name,
        ]);

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil ditambahkan.');
    }

    public function update(Request $request, Note $note)
    {
        $request->validate(['note' => 'required|string']);
        $note->update($request->only('note'));
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diupdate.');
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus.');
    }

    public function edit(Note $note)
    {
        // Redirect ke index dengan query parameter atau lewat route binding
        return $this->index($note);
    }
}