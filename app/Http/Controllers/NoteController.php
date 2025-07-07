<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\CustomerBook;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();
        $user = Auth::user();

        // Ambil semua catatan sesuai role
        $notes = Note::when($user->level !== 'admin', function ($query) use ($user) {
            $query->where('kasir_name', $user->name);
        })
        ->orderByDesc('created_at')
        ->get();

        // Ambil customer hanya sesuai kasir
        $customerBooks = CustomerBook::whereDate('created_time', $today)
            ->when($user->level !== 'admin', fn($q) => $q->where('barber_name', $user->name))
            ->get()
            ->groupBy('barber_name');

        $summary = "Total Customer: " . $customerBooks->flatten()->count();

        $todayNoteExists = Note::whereDate('created_at', $today)
            ->where('kasir_name', $user->name)
            ->exists();

        return view('notes.index', compact('notes', 'customerBooks', 'todayNoteExists', 'summary'));
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

    public function edit(Note $note)
    {
        return $this->indexWithEdit($note);
    }

    protected function indexWithEdit(Note $note)
    {
        $today = now()->toDateString();
        $user = Auth::user();

        $notes = Note::orderByDesc('created_at')->get();

        $customerBooks = CustomerBook::whereDate('created_time', $today)
            ->get()
            ->groupBy('barber_name');

        $summary = "Total Customer: " . $customerBooks->flatten()->count();

        $todayNoteExists = Note::whereDate('created_at', $today)
            ->where('kasir_name', $user->name)
            ->exists();

        return view('notes.index', compact('notes', 'customerBooks', 'todayNoteExists', 'summary', 'note'));
    }

    public function update(Request $request, Note $note)
    {
        $request->validate(['note' => 'required|string']);

        // Optional: hanya pemilik catatan yang bisa update
        if (Auth::user()->name !== $note->kasir_name) {
            abort(403, 'Unauthorized');
        }

        $note->update($request->only('note'));

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil diupdate.');
    }

    public function destroy(Note $note)
    {
        // Optional: hanya pemilik catatan yang bisa hapus
        if (Auth::user()->name !== $note->kasir_name) {
            abort(403, 'Unauthorized');
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Catatan berhasil dihapus.');
    }
}