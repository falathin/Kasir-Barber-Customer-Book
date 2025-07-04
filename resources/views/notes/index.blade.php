@extends('layouts.app')

@section('title', 'Daftar Catatan')

@section('content')
<div class="max-w-3xl mx-auto p-6 space-y-10">

    {{-- Catatan & Customer Hari Ini --}}
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-6 rounded-2xl shadow-md space-y-6">

        <h2 class="text-2xl font-semibold text-yellow-800 flex items-center gap-2">
            📘 Catatan Harian & Customer Hari Ini
        </h2>

        {{-- Form Buat / Edit --}}
        <div>
            <form 
                id="noteForm"
                action="{{ isset($note) && $note->exists ? route('notes.update', $note) : route('notes.store') }}" 
                method="POST"
            >
                @csrf
                @if(isset($note) && $note->exists)
                    @method('PUT')
                @endif

                <textarea 
                    name="note" 
                    id="noteTextarea"
                    rows="4" 
                    class="w-full border border-gray-300 rounded-lg p-3 focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-4 bg-white" 
                    placeholder="Tulis catatan di sini..."
                    required
                >{{ old('note', $note->note ?? '') }}</textarea>

                <div class="flex gap-3">
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg transition-colors duration-200"
                    >
                        {{ isset($note) && $note->exists ? 'Perbarui Catatan' : 'Simpan Catatan' }}
                    </button>
                    @if(isset($note) && $note->exists)
                        <a 
                            href="{{ route('notes.index') }}" 
                            class="text-gray-600 hover:text-gray-800 self-center underline"
                        >Batal Edit</a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Data Customer --}}
        <div class="space-y-8">
            @forelse ($customerBooks as $barber => $customers)
                <div class="bg-white p-4 rounded-xl border border-yellow-200 shadow">
                    <h3 class="text-lg font-bold text-yellow-700 mb-4">👨‍🔧 {{ $barber }}</h3>

                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-left text-gray-700 font-mono border border-gray-300">
                            <thead class="bg-yellow-100 text-gray-800 font-semibold">
                                <tr>
                                    <th class="px-3 py-2 border-b">🧍 Customer</th>
                                    <th class="px-3 py-2 border-b">✂️ Haircut</th>
                                    <th class="px-3 py-2 border-b">🎨 Warna / Lainnya</th>
                                    <th class="px-3 py-2 border-b">🧴 Produk</th>
                                    <th class="px-3 py-2 border-b">💵 Harga</th>
                                    <th class="px-3 py-2 border-b">⏰ Jam</th>
                                    <th class="px-3 py-2 border-b">📝 Rincian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($customers as $cust)
                                    <tr class="hover:bg-yellow-50">
                                        <td class="px-3 py-2 border-b">{{ $cust->customer }}</td>
                                        <td class="px-3 py-2 border-b">{{ $cust->haircut_type }}</td>
                                        <td class="px-3 py-2 border-b">{{ $cust->colouring_other ?? '-' }}</td>
                                        <td class="px-3 py-2 border-b">{{ $cust->sell_use_product ?? '-' }}</td>
                                        <td class="px-3 py-2 border-b">
                                            @if($cust->price)
                                                Rp {{ number_format($cust->price, 0, ',', '.') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 border-b">
                                            @if($cust->created_time)
                                                {{ \Carbon\Carbon::parse($cust->created_time)->format('H:i') }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td class="px-3 py-2 border-b">{{ $cust->rincian ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic">Belum ada customer hari ini.</p>
            @endforelse
        </div>
    </div>

    {{-- List Catatan Lain --}}
    <div>
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">🗒️ Daftar Catatan Lain</h2>

        @php
            $today = \Carbon\Carbon::today()->toDateString();
        @endphp

        @forelse ($notes as $item)
            @php
                $noteDate = \Carbon\Carbon::parse($item->created_at)->toDateString();
                $isToday = $noteDate === $today;
            @endphp

            <div class="border border-gray-200 bg-white p-4 rounded-xl shadow-sm mb-4 transition hover:shadow-md">
                <div class="flex justify-between items-start">
                    <p class="text-gray-700 mb-3 whitespace-pre-line">{{ $item->note }}</p>
                    <span class="text-xs text-gray-400">{{ $noteDate }}</span>
                </div>

                @if ($isToday)
                    <div class="flex gap-4 text-sm text-gray-500">
                        <a 
                            href="{{ route('notes.edit', $item) }}" 
                            class="hover:text-blue-600 transition-colors"
                        >Edit</a>

                        <form 
                            action="{{ route('notes.destroy', $item) }}" 
                            method="POST" 
                            onsubmit="return confirm('Hapus catatan ini?')" 
                            class="inline"
                        >
                            @csrf
                            @method('DELETE')
                            <button 
                                type="submit" 
                                class="hover:text-red-600 transition-colors"
                            >Hapus</button>
                        </form>
                    </div>
                @else
                    <div class="text-sm text-gray-400 italic">📌 History (tidak bisa diubah)</div>
                @endif
            </div>
        @empty
            <div class="text-gray-500 italic">Belum ada catatan lainnya.</div>
        @endforelse
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const todayNoteExists = @json($todayNoteExists);
    const form = document.getElementById('noteForm');
    const submitBtn = document.getElementById('submitBtn');
    const textarea = form.querySelector('textarea');

    // Jika sudah ada catatan hari ini dan belum dalam mode edit
    if (todayNoteExists && !@json(optional($note)->exists)) {
        submitBtn.disabled = true;
        textarea.disabled = true;
        submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
    }
});
</script>
@endsection
