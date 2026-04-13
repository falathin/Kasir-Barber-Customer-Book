{{-- resources/views/kasirs/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Manajemen Kasir')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
        referrerpolicy="no-referrer" />

    <div class="px-4 py-6 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-6xl animate__animated animate__fadeInUp">
            <div class="overflow-hidden rounded-[2rem] border border-slate-200 bg-white shadow-2xl">
                <div class="h-2 bg-gradient-to-r from-[#e0a33a] via-[#7a1422] to-[#203b5a]"></div>

                <div class="p-5 sm:p-7 lg:p-10">
                    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm font-semibold uppercase tracking-[0.25em] text-[#7a1422]">Data Kasir</p>
                            <h2 class="mt-2 text-2xl font-black text-slate-900 sm:text-3xl">
                                <i class="fa-solid fa-user-group mr-2 text-[#e0a33a]"></i>
                                Manajemen Kasir
                            </h2>
                            <p class="mt-2 max-w-2xl text-sm italic text-slate-500">
                                “Hair is another name for style.”
                                <span class="block font-semibold text-[#7a1422]">— Vidal Sassoon</span>
                            </p>
                        </div>

                        <a href="{{ route('kasirs.create') }}"
                            class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#7a1422] via-[#a61d2b] to-[#203b5a] px-5 py-3 font-semibold text-white shadow-lg shadow-[#7a1422]/20 transition hover:scale-[1.01] hover:shadow-xl hover:shadow-[#7a1422]/25 active:scale-[0.99]">
                            <i class="fa-solid fa-user-plus mr-2 text-[#e0a33a]"></i>
                            Tambah Kasir
                        </a>
                    </div>

                    {{-- Desktop table --}}
                    <div
                        class="hidden overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm md:block">
                        <div class="overflow-x-auto">
                            <table class="min-w-full table-fixed divide-y divide-slate-200">
                                <thead class="bg-[#fdf8f0]">
                                    <tr>
                                        <th
                                            class="w-1/4 px-6 py-4 text-left text-xs font-bold uppercase tracking-[0.2em] text-slate-600">
                                            <i class="fa-solid fa-id-card mr-2 text-[#7a1422]"></i>
                                            Nama
                                        </th>
                                        <th
                                            class="w-2/5 px-6 py-4 text-left text-xs font-bold uppercase tracking-[0.2em] text-slate-600">
                                            <i class="fa-solid fa-envelope mr-2 text-[#7a1422]"></i>
                                            Email
                                        </th>
                                        <th
                                            class="w-1/4 px-6 py-4 text-center text-xs font-bold uppercase tracking-[0.2em] text-slate-600">
                                            <i class="fa-solid fa-clock mr-2 text-[#203b5a]"></i>
                                            Login Terakhir
                                        </th>
                                        <th
                                            class="w-1/6 px-6 py-4 text-right text-xs font-bold uppercase tracking-[0.2em] text-slate-600">
                                            <i class="fa-solid fa-gear mr-2 text-[#7a1422]"></i>
                                            Aksi
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-slate-200 bg-white">
                                    @forelse ($cashiers as $kasir)
                                        <tr class="transition hover:bg-[#fdf8f0]">
                                            <td class="px-6 py-4 align-top whitespace-normal break-words">
                                                <div class="flex items-start gap-3">
                                                    <div
                                                        class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7a1422] to-[#203b5a] text-sm font-bold text-white shadow-sm">
                                                        {{ strtoupper(substr($kasir->name, 0, 1)) }}
                                                    </div>
                                                    <div class="min-w-0">
                                                        <p class="break-words font-semibold text-slate-900">
                                                            {{ $kasir->name }}</p>
                                                        <p class="text-xs text-slate-500">Kasir</p>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="px-6 py-4 align-top whitespace-normal break-all text-slate-600">
                                                {{ $kasir->email }}
                                            </td>

                                            <td class="px-6 py-4 align-top whitespace-normal text-center">
                                                @if ($kasir->last_login_at)
                                                    <span
                                                        class="inline-flex max-w-full items-center rounded-full bg-[#e8f0fb] px-3 py-1 text-xs font-semibold text-[#203b5a]">
                                                        <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                                        <span class="break-words">
                                                            {{ \Carbon\Carbon::parse($kasir->last_login_at)->translatedFormat('d M Y H:i') }}
                                                        </span>
                                                    </span>
                                                @else
                                                    <span
                                                        class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                                        <i class="fa-solid fa-circle-question mr-2"></i>
                                                        Belum pernah login
                                                    </span>
                                                @endif
                                            </td>

                                            <td class="px-6 py-4 align-top text-right">
                                                <form action="{{ route('kasirs.destroy', $kasir) }}" method="POST"
                                                    class="inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus kasir ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="inline-flex items-center rounded-2xl bg-red-50 px-4 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                                                        <i class="fa-solid fa-trash-can mr-2"></i>
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="px-6 py-14 text-center">
                                                <div class="mx-auto flex max-w-sm flex-col items-center">
                                                    <div
                                                        class="mb-4 flex h-16 w-16 items-center justify-center rounded-3xl bg-[#fdf8f0] text-2xl text-[#7a1422]">
                                                        <i class="fa-solid fa-user-slash"></i>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-slate-900">Belum ada akun kasir</h3>
                                                    <p class="mt-2 text-sm text-slate-500">
                                                        Tambahkan akun kasir baru untuk mulai mengelola data.
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    {{-- Mobile cards --}}
                    <div class="space-y-4 md:hidden">
                        @forelse ($cashiers as $kasir)
                            <div
                                class="rounded-[1.5rem] border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-[#7a1422] to-[#203b5a] text-sm font-bold text-white">
                                            {{ strtoupper(substr($kasir->name, 0, 1)) }}
                                        </div>
                                        <div class="min-w-0">
                                            <p class="break-words font-semibold text-slate-900">{{ $kasir->name }}</p>
                                            <p class="break-all text-sm text-slate-500">{{ $kasir->email }}</p>
                                        </div>
                                    </div>

                                    <form action="{{ route('kasirs.destroy', $kasir) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus kasir ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center rounded-2xl bg-red-50 px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-100">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>

                                <div class="mt-4 border-t border-slate-100 pt-4">
                                    <p class="mb-2 text-xs font-bold uppercase tracking-[0.18em] text-slate-500">
                                        Login Terakhir
                                    </p>

                                    @if ($kasir->last_login_at)
                                        <span
                                            class="inline-flex items-center rounded-full bg-[#e8f0fb] px-3 py-1 text-xs font-semibold text-[#203b5a]">
                                            <i class="fa-solid fa-right-to-bracket mr-2"></i>
                                            {{ \Carbon\Carbon::parse($kasir->last_login_at)->translatedFormat('d M Y H:i') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-500">
                                            <i class="fa-solid fa-circle-question mr-2"></i>
                                            Belum pernah login
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="rounded-[1.5rem] border border-slate-200 bg-white p-8 text-center shadow-sm">
                                <div
                                    class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-3xl bg-[#fdf8f0] text-2xl text-[#7a1422]">
                                    <i class="fa-solid fa-user-slash"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900">Belum ada akun kasir</h3>
                                <p class="mt-2 text-sm text-slate-500">
                                    Tambahkan akun kasir baru untuk mulai mengelola data.
                                </p>
                                <a href="{{ route('kasirs.create') }}"
                                    class="mt-5 inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-[#7a1422] via-[#a61d2b] to-[#203b5a] px-5 py-3 font-semibold text-white shadow-lg shadow-[#7a1422]/20 transition hover:scale-[1.01]">
                                    <i class="fa-solid fa-user-plus mr-2 text-[#e0a33a]"></i>
                                    Tambah Kasir
                                </a>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
