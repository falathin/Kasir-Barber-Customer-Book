{{-- resources/views/notes/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Catatan Harian')

@section('content')
    <style>
        /* Paper-like background */
        .stationery {
            background: #f9f6f1;
            padding: 2rem;
            max-width: 800px;
            margin: 2rem auto;
            border: 1px solid #ddd;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="40" height="40"%3E%3Ctext x="0" y="32" font-family="serif" font-size="32" fill="%23e0d8c3" opacity="0.1"%3E✒️%3C/text%3E%3C/svg%3E');
            background-repeat: repeat;
            border-radius: 8px;
        }

        .header-title {
            font-family: 'Georgia', serif;
            font-size: 2.25rem;
            color: #2f3e46;
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .subheader {
            font-family: 'Arial', sans-serif;
            font-size: 1rem;
            color: #5a5a5a;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .note-form {
            background: #ffffff;
            border: 1px solid #ccc;
            padding: 1.5rem;
            border-radius: 6px;
            margin-bottom: 2rem;
        }

        .note-form textarea {
            width: 100%;
            border: 1px solid #bbb;
            border-radius: 4px;
            padding: 0.75rem;
            font-family: 'Georgia', serif;
            font-size: 1rem;
            resize: vertical;
        }

        .note-form button {
            background: #2f80ed;
            color: #fff;
            border: none;
            padding: 0.6rem 1.2rem;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            margin-right: 1rem;
        }

        .note-form button:disabled {
            background: #aaa;
            cursor: not-allowed;
        }

        .note-form .btn-cancel {
            background: #e0e0e0;
            color: #333;
        }

        .notes-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .note-item {
            background: #fff;
            border-left: 4px solid #2f80ed;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border-radius: 4px;
            box-shadow: 0 1px 4px rgba(0, 0, 0, 0.05);
            transition: background 0.2s;
        }

        .note-item:hover {
            background: #fbfbfb;
        }

        .note-content {
            font-family: 'Georgia', serif;
            font-size: 1rem;
            color: #333;
            white-space: pre-wrap;
        }

        .note-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.875rem;
            color: #777;
            margin-top: 0.75rem;
        }

        .note-actions {
            margin-top: 0.75rem;
        }

        .note-actions a,
        .note-actions button {
            font-size: 0.875rem;
            color: #2f80ed;
            background: transparent;
            border: none;
            cursor: pointer;
            margin-right: 1rem;
        }

        .note-actions a:hover,
        .note-actions button:hover {
            text-decoration: underline;
        }
    </style>

    <div class="stationery">
        <!-- Header -->
        <div>
            <h1 class="header-title">Catatan Harian</h1>
            <p class="subheader">Terima kasih atas dedikasi dan kerja keras Anda<br>
                Hari ini: {{ now()->translatedFormat('l, d F Y') }}
            </p>
        </div>

        <!-- Form Buat/Edit -->
        <div class="note-form">
            <form id="noteForm"
                action="{{ isset($note) && $note->exists ? route('notes.update', $note) : route('notes.store') }}"
                method="POST">
                @csrf
                @if (isset($note) && $note->exists)
                    @method('PUT')
                @endif

                <div>
                    <textarea name="note" id="noteTextarea" rows="6"
                        placeholder="Contoh: Baim mengambil uang 10.000 untuk kebutuhan operasional."
                        {{ $todayNoteExists && !isset($note) ? 'disabled' : '' }} required>{{ old('note', $note->note ?? '') }}</textarea>
                </div>

                <input type="hidden" name="created_time" value="{{ now()->toDateTimeString() }}">
                <input type="hidden" name="rincian" value="{{ $summary }}">

                <div style="margin-top:1rem;">
                    <button type="submit" id="submitBtn" {{ $todayNoteExists && !isset($note) ? 'disabled' : '' }}>
                        {{ isset($note) ? 'Perbarui Catatan' : 'Simpan Catatan' }}
                    </button>
                    @if (isset($note) && $note->exists)
                        <a href="{{ route('notes.index') }}" class="btn-cancel">Batal</a>
                    @endif
                </div>
            </form>
        </div>

        <!-- Daftar Catatan -->
        <ul class="notes-list">
            @forelse($notes as $item)
                @php
                    $noteDate = \Carbon\Carbon::parse($item->created_time ?? $item->created_at)->translatedFormat(
                        'd M Y',
                    );
                    $isToday = $noteDate === now()->translatedFormat('d M Y');
                @endphp

                <li class="note-item">
                    <div class="note-content">{{ $item->note }}</div>
                    <div class="note-meta">
                        <span>{{ $noteDate }}</span>
                        @if (auth()->user()->level === 'admin')
                            <span>✍️ oleh {{ $item->kasir_name }}</span>
                        @endif
                    </div>
                    @if ($isToday && $item->kasir_name === auth()->user()->name)
                        <div class="note-actions">
                            <a href="{{ route('notes.edit', $item) }}">Edit</a>
                            <form action="{{ route('notes.destroy', $item) }}" method="POST" style="display:inline"
                                onsubmit="return confirm('Hapus catatan ini?');">
                                @csrf @method('DELETE')
                                <button type="submit">Hapus</button>
                            </form>
                        </div>
                    @endif
                </li>
            @empty
                <p style="text-align:center; color:#777; font-style:italic;">
                    Belum ada catatan.
                </p>
            @endforelse
        </ul>
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
