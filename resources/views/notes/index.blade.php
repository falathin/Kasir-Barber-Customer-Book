{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Catatan')

@section('content')
    <style>
        /* Latar kertas bergaris dengan nuansa hangat */
        .lined-paper {
            background-color: #FFF4E5;
            background-image:
                linear-gradient(to bottom, transparent 0%, transparent 93%, #FFD6A5 93%, #FFD6A5 100%);
            background-size: 100% 2rem;
        }

        /* Judul harian dengan efek tulisan tangan */
        .diary-header {
            font-family: 'Pacifico', cursive;
            font-size: 3rem;
            background: linear-gradient(45deg, #FFA726, #FB8C00);
            -webkit-background-clip: text;
            color: transparent;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        /* Card catatan dengan border warna aksen */
        .note-card {
            background: #FFFFFF;
            border-radius: 1rem;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.08);
            border-left: 6px solid #FFA726;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .note-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.12);
        }

        /* Tombol primary yang cerah */
        .btn-primary {
            background: #FB8C00;
            color: #FFF;
            box-shadow: 0 2px 6px rgba(251, 140, 0, 0.4);
        }

        .btn-primary:hover {
            background: #F57C00;
        }

        /* Tombol secondary netral */
        .btn-secondary {
            background: #F1F5F9;
            color: #334155;
        }

        .btn-secondary:hover {
            background: #E2E8F0;
        }

        /* Style scrollbar halus */
        .notes-list::-webkit-scrollbar {
            width: 6px;
        }

        .notes-list::-webkit-scrollbar-thumb {
            background-color: rgba(251, 140, 0, 0.5);
            border-radius: 3px;
        }

        .notes-list::-webkit-scrollbar-track {
            background: transparent;
        }
    </style>


    <div class="max-w-3xl mx-auto mt-8 mb-16 lined-paper p-6 rounded-lg shadow-lg">
        {{-- Header Harian --}}
        <div class="text-center mb-8">
            <h1 class="diary-header">Catatan Harian</h1>
            <p class="text-gray-600 mt-1">Tanggal: {{ now()->format('l, d F Y') }}</p>
        </div>

        {{-- Form Buat / Edit --}}
        <div class="mb-12">
            <form id="noteForm"
                action="{{ isset($note) && $note->exists ? route('notes.update', $note) : route('notes.store') }}"
                method="POST" class="bg-white/80 p-6 rounded-xl border border-yellow-300">
                @csrf
                @if (isset($note) && $note->exists)
                    @method('PUT')
                @endif

                <label for="noteTextarea" class="block text-gray-700 font-medium mb-2">
                    Tulis Catatan Hari Ini
                </label>
                <textarea name="note" id="noteTextarea" rows="6"
                    class="w-full border border-gray-300 rounded-lg p-4 focus:outline-none focus:ring-2 focus:ring-yellow-400 resize-none mb-4 bg-white"
                    placeholder="Hari ini saya..." required {{ $todayNoteExists && !isset($note) ? 'disabled' : '' }}>{{ old('note', $note->note ?? '') }}</textarea>

                {{-- Hidden untuk auto-fill --}}
                <input type="hidden" name="created_time" value="{{ now()->toDateTimeString() }}">
                <input type="hidden" name="rincian" value="{{ $summary }}">

                <div class="flex items-center space-x-4">
                    <button type="submit" id="submitBtn"
                        class="bg-yellow-400 hover:bg-yellow-500 text-white px-6 py-2 rounded-lg font-semibold transition-opacity duration-200
                           {{ $todayNoteExists && !isset($note) ? 'opacity-50 cursor-not-allowed' : '' }}"
                        {{ $todayNoteExists && !isset($note) ? 'disabled' : '' }}>
                        {{ isset($note) ? 'Perbarui Catatan' : 'Simpan Catatan' }}
                    </button>
                    @if (isset($note) && $note->exists)
                        <a href="{{ route('notes.index') }}" class="text-gray-600 hover:text-gray-800 underline">
                            Batal Edit
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Daftar Catatan Lain --}}
        <div class="notes-list max-h-[400px] overflow-y-auto space-y-6 pb-4">
            @forelse ($notes as $item)
                @php
                    $noteDate = \Carbon\Carbon::parse($item->created_time ?? $item->created_at)->format('d M Y');
                    $isToday = $noteDate === now()->format('d M Y');
                @endphp

                <div
                    class="bg-white/90 p-5 rounded-lg border-l-4 {{ $isToday ? 'border-yellow-500' : 'border-gray-300' }} shadow-sm">
                    <div class="flex justify-between items-start">
                        <p class="text-gray-800 whitespace-pre-line">{{ $item->note }}</p>
                    </div>

                    {{-- Label Tanggal dan Penulis --}}
                    <div class="flex justify-between items-center mt-2">
                        <span class="text-xs text-gray-400">
                            {{ $noteDate }}
                        </span>
                        @if (auth()->user()->level === 'admin')
                            <span class="text-xs text-gray-500 italic">
                                ✍️ oleh {{ $item->kasir_name }}
                            </span>
                        @endif
                    </div>

                    {{-- Tombol Edit & Hapus jika kasir yang buat --}}
                    @if ($isToday && $item->kasir_name === auth()->user()->name)
                        <div class="mt-3 flex space-x-4 text-sm">
                            <a href="{{ route('notes.edit', $item) }}"
                                class="text-yellow-600 hover:text-yellow-800 transition-colors">
                                Edit
                            </a>
                            <form action="{{ route('notes.destroy', $item) }}" method="POST"
                                onsubmit="return confirm('Hapus catatan ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">
                                    Hapus
                                </button>
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
            if (todayNoteExists && !isEditing) {
                document.getElementById('noteTextarea').disabled = true;
                document.getElementById('submitBtn').disabled = true;
            }
        });
    </script>
@endsection