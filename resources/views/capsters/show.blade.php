@extends('layouts.app')

@section('title', 'Detail Capster')

@section('content')
    @php
        $hp = preg_replace('/\D/', '', $capster->no_hp ?? '');
        $formatted =
            strlen($hp) === 12
                ? substr($hp, 0, 4) . '-' . substr($hp, 4, 4) . '-' . substr($hp, 8)
                : $capster->no_hp ?? '-';

        $hpFam = preg_replace('/\D/', '', $capster->no_hp_keluarga ?? '');
        $formattedFam = $capster->no_hp_keluarga
            ? (strlen($hpFam) === 12
                ? substr($hpFam, 0, 4) . '-' . substr($hpFam, 4, 4) . '-' . substr($hpFam, 8)
                : $capster->no_hp_keluarga)
            : '-';

        $statusActive = strtolower($capster->status) === 'aktif';
    @endphp

    <div class="py-6 sm:py-10">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-zinc-200 bg-white shadow-2xl">
                {{-- Header --}}
                <div
                    class="relative overflow-hidden bg-gradient-to-r from-zinc-950 via-zinc-900 to-amber-900 px-6 py-8 sm:px-8">
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-amber-400 blur-3xl"></div>
                        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-pink-500 blur-3xl"></div>
                    </div>

                    <div class="relative flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <div
                                class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                                <span class="inline-block h-2 w-2 rounded-full bg-amber-300"></span>
                                Barber Studio Profile
                            </div>
                            <h1 class="mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl">
                                Detail Capster
                            </h1>
                            <p class="mt-2 max-w-2xl text-sm leading-6 text-zinc-200 sm:text-base">
                                Informasi lengkap capster dengan tampilan yang lebih rapi, modern, dan nyaman dilihat di
                                desktop maupun mobile.
                            </p>
                        </div>

                        <div class="flex flex-wrap gap-3">
                            <div
                                class="rounded-2xl border border-white/10 bg-white/10 px-5 py-4 text-white shadow-lg backdrop-blur">
                                <p class="text-xs uppercase tracking-[0.2em] text-amber-200">Status</p>
                                <p class="mt-1 text-sm font-bold">
                                    {{ $statusActive ? 'Aktif' : 'Keluar' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8">
                    {{-- Profile Area --}}
                    <div class="grid gap-6 lg:grid-cols-[280px_1fr] lg:items-start">
                        {{-- Left / Photo Card --}}
                        <div class="rounded-3xl border border-zinc-200 bg-zinc-50 p-5 shadow-sm">
                            <div class="flex flex-col items-center text-center">
                                <div class="relative">
                                    <button id="capsterPhotoBtn" type="button" class="group focus:outline-none">
                                        <img id="capsterPhoto" src="{{ $capster->foto_url }}" alt="Foto Capster"
                                            class="h-40 w-40 rounded-full border-4 border-white object-cover shadow-xl ring-4 ring-amber-200 transition duration-200 group-hover:scale-[1.02] group-hover:shadow-2xl">
                                        <span
                                            class="absolute bottom-3 right-3 inline-flex h-10 w-10 items-center justify-center rounded-full bg-zinc-900 text-white shadow-lg">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <circle cx="11" cy="11" r="8" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <line x1="21" y1="21" x2="16.65" y2="16.65"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </button>
                                </div>

                                <h2 class="mt-5 text-2xl font-extrabold text-zinc-900">{{ $capster->nama }}</h2>
                                <p class="mt-1 text-sm text-zinc-500">{{ $capster->inisial }}</p>

                                <div
                                    class="mt-4 inline-flex items-center gap-2 rounded-full px-4 py-2 text-sm font-semibold
                                    {{ $statusActive ? 'bg-emerald-100 text-emerald-800' : 'bg-rose-100 text-rose-800' }}">
                                    <span
                                        class="h-2.5 w-2.5 rounded-full {{ $statusActive ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                    {{ $statusActive ? 'Aktif' : 'Keluar' }}
                                </div>

                                <div class="mt-5 w-full rounded-2xl bg-white p-4 text-left shadow-sm ring-1 ring-zinc-100">
                                    <p class="text-xs uppercase tracking-[0.18em] text-zinc-400">Dibuat Pada</p>
                                    <p class="mt-2 text-sm font-semibold text-zinc-900">
                                        {{ $capster->created_at ? $capster->created_at->format('d M Y, H:i') : '-' }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Right / Info Card --}}
                        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm sm:p-6">
                            <div class="mb-5 flex items-center justify-between">
                                <div>
                                    <h3 class="text-xl font-bold text-zinc-900">Informasi Capster</h3>
                                    <p class="mt-1 text-sm text-zinc-500">Detail data pribadi dan kontak</p>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div class="rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100">
                                    <span
                                        class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Nama</span>
                                    <span class="mt-2 block text-sm font-semibold text-zinc-900">{{ $capster->nama }}</span>
                                </div>

                                <div class="rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100">
                                    <span
                                        class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Inisial</span>
                                    <span
                                        class="mt-2 block text-sm font-semibold text-zinc-900">{{ $capster->inisial }}</span>
                                </div>

                                <div class="rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100 flex items-start gap-3">

                                    {{-- ICON --}}
                                    <div
                                        class="p-2 rounded-lg
                                        {{ $capster->jenis_kelamin === 'L' ? 'bg-blue-100 text-blue-600' : 'bg-pink-100 text-pink-600' }}">

                                        @if ($capster->jenis_kelamin === 'L')
                                            {{-- ICON LAKI-LAKI --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="10" cy="14" r="5" stroke-width="2" />
                                                <line x1="14" y1="10" x2="21" y2="3"
                                                    stroke-width="2" />
                                                <line x1="15" y1="3" x2="21" y2="3"
                                                    stroke-width="2" />
                                                <line x1="21" y1="3" x2="21" y2="9"
                                                    stroke-width="2" />
                                            </svg>
                                        @else
                                            {{-- ICON PEREMPUAN --}}
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <circle cx="12" cy="8" r="5" stroke-width="2" />
                                                <line x1="12" y1="13" x2="12" y2="21"
                                                    stroke-width="2" />
                                                <line x1="9" y1="18" x2="15" y2="18"
                                                    stroke-width="2" />
                                            </svg>
                                        @endif

                                    </div>

                                    {{-- TEXT --}}
                                    <div>
                                        <span
                                            class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">
                                            Jenis Kelamin
                                        </span>
                                        <span class="mt-2 block text-sm font-semibold text-zinc-900">
                                            {{ $capster->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                    </div>
                                </div>

                                <div class="rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100">
                                    <span
                                        class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Tanggal
                                        Lahir</span>
                                    <span class="mt-2 block text-sm font-semibold text-zinc-900">
                                        {{ $capster->tgl_lahir ? $capster->tgl_lahir->format('d M Y') : '-' }}
                                    </span>
                                </div>

                                <div class="sm:col-span-2 rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100">
                                    <span
                                        class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">Asal
                                        / Alamat</span>
                                    <p class="mt-2 whitespace-pre-line text-sm leading-6 text-zinc-900">
                                        {{ $capster->asal ?? '-' }}
                                    </p>
                                </div>

                                <div class="rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100">
                                    <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">No.
                                        HP</span>
                                    <span
                                        class="mt-2 block text-sm font-semibold text-zinc-900">{{ $formatted }}</span>
                                </div>

                                <div class="rounded-2xl bg-zinc-50 p-4 ring-1 ring-zinc-100">
                                    <span class="block text-xs font-semibold uppercase tracking-[0.18em] text-zinc-400">HP
                                        Keluarga</span>
                                    <span
                                        class="mt-2 block text-sm font-semibold text-zinc-900">{{ $formattedFam }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('capsters.index') }}"
                            class="inline-flex flex-1 items-center justify-center rounded-full bg-zinc-200 px-5 py-3 font-semibold text-zinc-800 transition hover:bg-zinc-300">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>

                        <a href="{{ route('capsters.edit', $capster) }}"
                            class="inline-flex flex-1 items-center justify-center rounded-full bg-amber-500 px-5 py-3 font-semibold text-white shadow-lg transition hover:bg-amber-600">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mr-2 h-4 w-4" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z" />
                            </svg>
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Foto --}}
    <div id="modalBackdrop" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/70 p-4">

        <div class="w-full max-w-xl rounded-3xl bg-white shadow-2xl">

            {{-- HEADER --}}
            <div class="flex items-center justify-between border-b border-zinc-100 px-5 py-4">
                <div>
                    <h4 class="text-base font-bold text-zinc-900">Foto Capster</h4>
                    <p class="text-sm text-zinc-500">{{ $capster->nama }}</p>
                </div>
                <button id="closeModalBtn" type="button"
                    class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-zinc-100 text-zinc-600 hover:bg-zinc-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            {{-- IMAGE (NO SCROLL) --}}
            <div class="bg-zinc-50 p-4">
                <img src="{{ $capster->foto_url }}" alt="Foto Capster Detail"
                    class="w-full max-h-[80vh] object-contain rounded-2xl">
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.getElementById('modalBackdrop');
            const img = document.getElementById('capsterPhoto');
            const btn = document.getElementById('capsterPhotoBtn');
            const close = document.getElementById('closeModalBtn');

            let scrollY = 0;

            const openModal = () => {
                scrollY = window.scrollY;

                modal.classList.remove('hidden');

                // LOCK SCROLL TOTAL (desktop + mobile)
                document.documentElement.style.overflow = 'hidden';
                document.body.style.overflow = 'hidden';

                // fix iOS / mobile bounce scroll
                document.body.style.position = 'fixed';
                document.body.style.top = `-${scrollY}px`;
                document.body.style.width = '100%';
                document.body.style.touchAction = 'none';
            };

            const closeModal = () => {
                modal.classList.add('hidden');

                // UNLOCK
                document.documentElement.style.overflow = '';
                document.body.style.overflow = '';
                document.body.style.position = '';
                document.body.style.top = '';
                document.body.style.width = '';
                document.body.style.touchAction = '';

                window.scrollTo(0, scrollY);
            };

            if (img) img.addEventListener('click', openModal);
            if (btn) btn.addEventListener('click', openModal);
            if (close) close.addEventListener('click', closeModal);

            modal.addEventListener('click', (e) => {
                if (e.target === modal) closeModal();
            });

            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') closeModal();
            });
        });
    </script>
@endsection