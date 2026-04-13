@extends('layouts.app')

@section('title', 'Capster')

@section('content')
    <div class="py-8">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="overflow-hidden rounded-3xl border border-amber-100 bg-white shadow-2xl">
                <div class="relative overflow-hidden bg-gradient-to-r from-zinc-950 via-zinc-900 to-amber-900 px-6 py-8 sm:px-8">
                    <div class="absolute inset-0 opacity-20">
                        <div class="absolute -top-10 -right-10 h-40 w-40 rounded-full bg-amber-400 blur-3xl"></div>
                        <div class="absolute -bottom-10 -left-10 h-40 w-40 rounded-full bg-pink-500 blur-3xl"></div>
                    </div>

                    <div class="relative flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
                        <div>
                            <div class="inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.2em] text-amber-200">
                                <i class="fa-solid fa-scissors"></i>
                                Manajemen Studio Barber
                            </div>

                            <h1 class="mt-4 text-3xl font-black tracking-tight text-white sm:text-4xl">
                                Capster
                            </h1>

                        </div>

                        <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                            <div class="rounded-2xl border border-white/10 bg-white/10 px-5 py-4 text-white shadow-lg backdrop-blur">
                                <p class="text-xs uppercase tracking-[0.2em] text-amber-200">Total Data</p>
                                <p class="mt-1 text-3xl font-extrabold">{{ $capsters->total() }}</p>
                            </div>

                            <a href="{{ route('capsters.create') }}"
                                class="inline-flex items-center justify-center rounded-full bg-amber-400 px-6 py-3 font-semibold text-zinc-950 shadow-lg transition hover:bg-amber-300 hover:shadow-xl">
                                <i class="fa-solid fa-plus mr-2"></i>
                                Tambah Capster
                            </a>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <form method="GET" action="{{ route('capsters.index') }}"
                        class="mb-8 grid gap-3 rounded-2xl border border-zinc-200 bg-zinc-50 p-4 shadow-sm lg:grid-cols-[1fr_auto_auto] lg:items-center">
                        <div class="relative">
                            <i class="fa-solid fa-magnifying-glass pointer-events-none absolute left-4 top-1/2 -translate-y-1/2 text-zinc-400"></i>
                            <input type="text" name="search" placeholder="Cari capster..." value="{{ request('search') }}"
                                class="w-full rounded-full border border-zinc-300 bg-white py-3 pl-11 pr-4 text-sm outline-none transition focus:border-amber-400 focus:ring-4 focus:ring-amber-100">
                        </div>

                        <button type="submit"
                            class="inline-flex items-center justify-center rounded-full bg-zinc-900 px-6 py-3 text-sm font-semibold text-white shadow-md transition hover:bg-amber-600">
                            <i class="fa-solid fa-filter mr-2"></i>
                            Cari
                        </button>

                        @if (request('search'))
                            <a href="{{ route('capsters.index') }}"
                                class="inline-flex items-center justify-center rounded-full bg-white px-6 py-3 text-sm font-semibold text-zinc-700 shadow-sm ring-1 ring-zinc-200 transition hover:bg-zinc-100">
                                <i class="fa-solid fa-rotate-left mr-2"></i>
                                Hapus
                            </a>
                        @endif
                    </form>

                    <div class="hidden md:block overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-lg">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-zinc-200">
                                <thead class="bg-gradient-to-r from-zinc-900 to-amber-900">
                                    <tr>
                                        @foreach (['#', 'Foto', 'Nama', 'Inisial', 'Jenis Kelamin', 'No. HP', 'Asal', 'Status', 'Aksi'] as $col)
                                            <th class="px-4 py-4 text-left text-xs font-bold uppercase tracking-wider text-white">
                                                {{ $col }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-zinc-100 bg-white">
                                    @forelse($capsters as $capster)
                                        <tr class="transition hover:bg-amber-50/60">
                                            <td class="px-4 py-4 text-sm font-medium text-zinc-700">
                                                {{ $loop->iteration + ($capsters->currentPage() - 1) * $capsters->perPage() }}
                                            </td>

                                            <td class="px-4 py-4">
                                                <img src="{{ $capster->foto_url }}" alt="{{ $capster->nama }}"
                                                    class="h-11 w-11 rounded-full border-2 border-amber-200 object-cover shadow-sm">
                                            </td>

                                            <td class="px-4 py-4 text-sm font-semibold text-zinc-900">
                                                {{ $capster->nama }}
                                            </td>

                                            <td class="px-4 py-4 text-sm text-zinc-700">
                                                {{ $capster->inisial }}
                                            </td>

                                            <td class="px-4 py-4 text-sm text-zinc-700">
                                                {{ $capster->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}
                                            </td>

                                            <td class="px-4 py-4 text-sm text-zinc-700">
                                                {{ $capster->no_hp ?? '-' }}
                                            </td>

                                            <td class="px-4 py-4 text-sm text-zinc-700">
                                                {{ \Illuminate\Support\Str::limit($capster->asal ?? '-', 70, '...') }}
                                            </td>

                                            <td class="px-4 py-4">
                                                @if (strtolower($capster->status) === 'aktif')
                                                    <span class="inline-flex items-center rounded-full bg-emerald-500 px-3 py-1 text-xs font-bold text-white shadow-sm">
                                                        <i class="fa-solid fa-circle-check mr-1"></i> Aktif
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center rounded-full bg-rose-500 px-3 py-1 text-xs font-bold text-white shadow-sm">
                                                        <i class="fa-solid fa-circle-xmark mr-1"></i> Tidak Aktif
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-4 py-4">
                                                <div class="flex items-center space-x-2">
                                                    <a href="{{ route('capsters.show', $capster) }}"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-500 text-white shadow transition hover:bg-sky-600 hover:scale-105"
                                                        title="Lihat">
                                                        <i class="fa-solid fa-eye text-sm"></i>
                                                    </a>

                                                    <a href="{{ route('capsters.edit', $capster) }}"
                                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 text-white shadow transition hover:bg-amber-600 hover:scale-105"
                                                        title="Ubah">
                                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                                    </a>

                                                    <form action="{{ route('capsters.destroy', $capster) }}" method="POST"
                                                        onsubmit="return confirm('Yakin ingin dihapus?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-rose-500 text-white shadow transition hover:bg-rose-600 hover:scale-105"
                                                            title="Hapus">
                                                            <i class="fa-solid fa-trash text-sm"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="px-4 py-10 text-center text-sm text-zinc-500">
                                                <div class="flex flex-col items-center">
                                                    <i class="fa-solid fa-scissors text-3xl text-zinc-300"></i>
                                                    <p class="mt-3 font-medium">Belum ada capster.</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="md:hidden space-y-4">
                        @forelse($capsters as $capster)
                            <div class="rounded-2xl border border-zinc-200 bg-white p-4 shadow-md transition hover:shadow-lg">
                                <div class="flex items-center justify-between gap-3">
                                    <div class="flex items-center space-x-3">
                                        <img src="{{ $capster->foto_url }}" alt="{{ $capster->nama }}"
                                            class="h-14 w-14 rounded-full border-2 border-amber-200 object-cover shadow">
                                        <div>
                                            <h3 class="text-base font-bold text-zinc-900">{{ $capster->nama }}</h3>
                                            <p class="text-sm text-zinc-500">{{ $capster->inisial ?? '-' }}</p>
                                        </div>
                                    </div>

                                    @if (strtolower($capster->status) === 'aktif')
                                        <span class="inline-flex items-center rounded-full bg-emerald-500 px-3 py-1 text-xs font-bold text-white">
                                            Aktif
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-rose-500 px-3 py-1 text-xs font-bold text-white">
                                            Tidak Aktif
                                        </span>
                                    @endif
                                </div>

                                <div class="mt-4 space-y-2 rounded-xl bg-zinc-50 p-3 text-sm text-zinc-700 ring-1 ring-zinc-100">
                                    <p><span class="font-semibold text-purple-600">Jenis kelamin:</span> {{ $capster->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                    <p><span class="font-semibold text-sky-600">No. HP:</span> {{ $capster->no_hp ?? '-' }}</p>
                                    <p><span class="font-semibold text-pink-600">Asal:</span> {{ $capster->asal ?? '-' }}</p>
                                </div>

                                <div class="mt-4 flex items-center space-x-2">
                                    <a href="{{ route('capsters.show', $capster) }}"
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-sky-500 text-white shadow transition hover:bg-sky-600"
                                        title="Lihat">
                                        <i class="fa-solid fa-eye text-sm"></i>
                                    </a>

                                    <a href="{{ route('capsters.edit', $capster) }}"
                                        class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-amber-500 text-white shadow transition hover:bg-amber-600"
                                        title="Ubah">
                                        <i class="fa-solid fa-pen-to-square text-sm"></i>
                                    </a>

                                    <form action="{{ route('capsters.destroy', $capster) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin dihapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex h-10 w-10 items-center justify-center rounded-full bg-rose-500 text-white shadow transition hover:bg-rose-600"
                                            title="Hapus">
                                            <i class="fa-solid fa-trash text-sm"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <div class="rounded-2xl border border-dashed border-zinc-300 bg-zinc-50 px-6 py-10 text-center text-zinc-500">
                                <i class="fa-solid fa-scissors text-3xl text-zinc-300"></i>
                                <p class="mt-3 font-medium">Belum ada capster.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-8 flex justify-center">
                        {{ $capsters->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
@endsection