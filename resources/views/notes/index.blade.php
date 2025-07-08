{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Catatan Harian')

@section('content')
    <style>
        /* Professional secretary theme */
        .stationery {
            background-color: #fdfcf6;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 80 80'%3E%3Ctext x='0' y='60' font-family='serif' font-size='60' fill='%23eee' opacity='0.1'%3E✒️%3C/text%3E%3C/svg%3E");
            background-repeat: repeat;
        }
        .header-title {
            font-family: 'Merriweather', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: #2c3e50;
            text-align: center;
        }
        .subheader {
            font-family: 'Roboto', sans-serif;
            font-size: 1rem;
            color: #7f8c8d;
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .note-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            border-left: 4px solid #3498db;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .note-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 14px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: #3498db;
            color: #fff;
        }
        .btn-primary:hover {
            background: #2980b9;
        }
        .btn-secondary {
            background: #ecf0f1;
            color: #2c3e50;
        }
        .btn-secondary:hover {
            background: #d0d7de;
        }
        .notes-list {
            max-height: 450px;
            overflow-y: auto;
        }
    </style>

    <div class="max-w-4xl mx-auto mt-8 mb-16 stationery p-8 rounded-lg">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="header-title">Catatan Harian</h1>
            <p class="subheader">Terima kasih atas dedikasi dan kerjakeras Anda<br>Hari ini: {{ now()->translatedFormat('l, d F Y') }}</p>
        </div>

        {{-- Form Buat / Edit --}}
        <div class="mb-12 bg-white p-8 rounded-xl shadow-sm">
            <form id="noteForm"
                  action="{{ isset($note) && $note->exists ? route('notes.update', $note) : route('notes.store') }}"
                  method="POST">
                @csrf
                @if(isset($note) && $note->exists)
                    @method('PUT')
                @endif

                <div class="mb-4">
                    <label for="noteTextarea" class="block text-gray-700 font-medium mb-2">
                        Tulis Catatan Anda
                    </label>
                    <textarea name="note" id="noteTextarea" rows="6"
                              class="w-full border border-gray-300 rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-blue-300 resize-none"
                              placeholder="Tuliskan refleksi atau apresiasi Anda hari ini..." required
                              {{ $todayNoteExists && !isset($note) ? 'disabled' : '' }}>{{ old('note', $note->note ?? '') }}</textarea>
                </div>

                <input type="hidden" name="created_time" value="{{ now()->toDateTimeString() }}">
                <input type="hidden" name="rincian" value="{{ $summary }}">

                <div class="flex items-center space-x-4">
                    <button type="submit" id="submitBtn" class="btn btn-primary px-6 py-2 rounded-md font-semibold"
                            {{ $todayNoteExists && !isset($note) ? 'disabled' : '' }}>
                        {{ isset($note) ? 'Perbarui Catatan' : 'Simpan Catatan' }}
                    </button>
                    @if(isset($note) && $note->exists)
                        <a href="{{ route('notes.index') }}" class="btn btn-secondary px-4 py-2 rounded-md font-medium underline">
                            Batal
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Daftar Catatan Lain --}}
        <div class="notes-list space-y-6">
            @forelse($notes as $item)
                @php
                    $noteDate = \Carbon\Carbon::parse($item->created_time ?? $item->created_at)->translatedFormat('d M Y');
                    $isToday = $noteDate === now()->translatedFormat('d M Y');
                @endphp

                <div class="note-card p-6 border-l-4 {{ $isToday ? 'border-blue-500' : 'border-gray-300' }}">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-800 whitespace-pre-line font-sans">{{ $item->note }}</p>
                    </div>
                    <div class="flex justify-between items-center mt-4 text-sm text-gray-500">
                        <span>{{ $noteDate }}</span>
                        @if(auth()->user()->level === 'admin')
                            <span>✍️ oleh {{ $item->kasir_name }}</span>
                        @endif
                    </div>
                    @if($isToday && $item->kasir_name === auth()->user()->name)
                        <div class="mt-4 flex space-x-6 text-sm">
                            <a href="{{ route('notes.edit', $item) }}" class="text-blue-600 hover:text-blue-800">
                                Edit
                            </a>
                            <form action="{{ route('notes.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800">Hapus</button>
                            </form>
                        </div>
                    @endif
                </div>
            @empty
                <p class="text-gray-600 italic text-center">Belum ada catatan.</p>
            @endforelse
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const todayNoteExists = @json($todayNoteExists);
            const isEditing = @json(isset($note) && $note->exists);
            if(todayNoteExists && !isEditing) {
                document.getElementById('noteTextarea').disabled = true;
                document.getElementById('submitBtn').disabled = true;
            }
        });
    </script>
@endsection