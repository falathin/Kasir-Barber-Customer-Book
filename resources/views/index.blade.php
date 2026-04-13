@extends('layouts.app')

@section('title', 'Dasbor')

@section('content')
    <main class="space-y-6 p-4">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
        {{-- ===================== GREETING CARD ===================== --}}
        <div class="rounded-2xl overflow-hidden shadow-2xl">
            {{-- Barber stripe --}}
            <div class="flex h-1">
                <div class="w-1/3 bg-red-600"></div>
                <div class="w-1/3 bg-white"></div>
                <div class="w-1/3 bg-blue-600"></div>
            </div>

            <div id="greeting-card"
                class="p-6 rounded-b-2xl animate__animated animate__fadeInUp
        flex flex-col md:flex-row items-center justify-between gap-6 bg-yellow-50 transition-all duration-500">

                {{-- TEXT --}}
                <div class="flex-1 min-w-0">
                    <h2 id="greeting" class="text-2xl font-semibold text-gray-800"></h2>

                    <p id="time" class="text-lg text-gray-700 mt-1 font-mono tracking-widest"></p>

                    <p id="desc-text" class="mt-4 text-gray-600 leading-relaxed">
                        @if (auth()->user()->level === 'admin')
                            Hai <span class="font-semibold text-indigo-600">Admin</span> 👋
                        @else
                            Hai
                            <span class="font-semibold text-indigo-600">
                                Kasir {{ auth()->user()->name }}
                            </span> 👋
                        @endif
                        <br>
                        Semoga harimu lancar dan produktif. Statistik hari ini ada di bawah.
                    </p>
                </div>

                {{-- ICON --}}
                <div class="w-28 h-28 md:w-36 md:h-36 flex-shrink-0">
                    <img id="greeting-icon" src="https://cdn-icons-png.flaticon.com/512/869/869869.png"
                        class="w-full h-full object-cover rounded-xl shadow-sm animate__animated animate__fadeInRight"
                        alt="Greeting">
                </div>
            </div>
        </div>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        {{-- ===================== TOGGLE STATISTIK ===================== --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp">
            <div class="flex items-center justify-between gap-3 flex-wrap">

                {{-- Tombol Statistik --}}
                <button id="toggle-stats"
                    class="px-5 py-2 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200"
                    aria-controls="stats-panel" aria-expanded="true">
                    Tampilkan Statistik Transaksi & Pelanggan
                </button>

                @auth
                    @if (auth()->user()->level === 'admin')
                        <a href="{{ route('sales.export.form') }}"
                            class="px-5 py-2 bg-green-500 text-white rounded-full hover:bg-green-600 transition duration-200">
                            Export Excel
                        </a>
                    @endif
                @endauth

            </div>

            <div id="stats-panel" class="mt-6">
                <div
                    class="grid w-full grid-cols-1 sm:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-6 gap-y-8 justify-items-center sm:justify-items-stretch">

                    {{-- Total Transaksi --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-green-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-green-700">Total Transaksi Hari Ini</h3>
                            <div class="bg-white rounded-full p-3 shadow">
                                <i class="fa-solid fa-cart-shopping text-green-500 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-green-600 mt-4">{{ $totalTransaksi }}</p>
                    </div>

                    {{-- Pendapatan Hari Ini --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-blue-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-blue-700">Total Pendapatan Hari Ini</h3>
                            <div class="bg-white rounded-full p-3 shadow">
                                <i class="fa-solid fa-money-bill-wave text-blue-600 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-blue-600 mt-4">
                            Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Pengembalian --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-red-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-red-700">Total Belum Lunas</h3>
                            <div class="bg-white rounded-full p-3 shadow">
                                <i class="fa-solid fa-arrow-down text-red-500 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-red-600 mt-4">
                            -Rp {{ number_format(abs($totalPengembalian), 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Customer Hari Ini --}}
                    <div
                        class="w-full max-w-xs sm:max-w-none p-5 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-purple-700">Pelanggan Hari Ini</h3>
                            <div class="bg-white rounded-full p-3 shadow">
                                <i class="fa-solid fa-user text-purple-500 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-purple-600 mt-4">{{ $customersToday }}</p>
                    </div>

                    {{-- Customer Bulan --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-pink-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-pink-700">Pelanggan Bulan Ini</h3>
                            <div class="bg-white rounded-full p-3 shadow">
                                <i class="fa-solid fa-calendar-days text-pink-500 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-pink-600 mt-4">{{ $customersMonth }}</p>
                    </div>

                    {{-- Pendapatan Bulanan --}}
                    <div
                        class="w-full max-w-xs sm:max-w-none p-5 bg-yellow-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-yellow-700">Pendapatan Bulanan</h3>
                            <div class="bg-white rounded-full p-3 shadow">
                                <i class="fa-solid fa-chart-column text-yellow-500 text-xl"></i>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-yellow-600 mt-4">
                            Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}
                        </p>
                    </div>

                    {{-- Pendapatan Tahunan --}}
                    <div
                        class="w-full max-w-xs sm:max-w-none p-5 rounded-2xl shadow-lg hover:shadow-2xl transition bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                        <div class="flex justify-between items-center">
                            <h3 class="text-md font-medium text-white">Pendapatan Tahunan</h3>
                            <div class="bg-white/20 rounded-full p-3">
                                <i class="fa-solid fa-chart-line text-white text-xl"></i>
                            </div>
                        </div>
                        <p class="text-4xl font-extrabold text-white mt-3">
                            Rp {{ number_format($pendapatanTahunan, 0, ',', '.') }}
                        </p>
                    </div>

                </div>
            </div>
        </div>

        {{-- ===================== Ranking Pendapatan Per Barber ===================== --}}
        @php
            $pendapatanPerBarber = collect($pendapatanPerBarber);
            $maxTotal = $pendapatanPerBarber->max('total') ?: 1;
            $medals = ['🥇', '🥈', '🥉'];
            $colors = ['bg-yellow-400', 'bg-gray-400', 'bg-orange-400'];
            $role = Auth::user()->level ?? 'kasir';
        @endphp

        @if ($role === 'admin')
            <div class="mt-10 bg-white p-6 rounded-2xl shadow-xl animate__animated animate__fadeInUp">

                {{-- HEADER --}}
                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">
                    <h2 class="text-2xl font-bold text-indigo-700 flex items-center gap-2">
                        <i class="fa-solid fa-chart-column"></i>
                        Ranking Pendapatan Per Barber
                    </h2>
                </div>

                {{-- CONTENT --}}
                @forelse ($pendapatanPerBarber as $index => $item)
                    @php
                        $percentage = round(($item->total / $maxTotal) * 100);
                        $barColor = $colors[$index] ?? 'bg-indigo-500';
                        $medal = $medals[$index] ?? null;
                    @endphp

                    <div class="mb-6">

                        {{-- TOP INFO --}}
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-3 text-gray-700 font-semibold">
                                <span class="text-lg">
                                    {{ $medal ?? $index + 1 . '.' }}
                                </span>
                                <span class="truncate">
                                    {{ $item->barber_name }}
                                </span>
                            </div>

                            <span class="text-indigo-600 font-bold text-lg whitespace-nowrap">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </span>
                        </div>

                        {{-- PROGRESS BAR --}}
                        <div class="relative w-full bg-gray-100 rounded-full h-5 overflow-hidden group">
                            <div class="h-5 rounded-full {{ $barColor }} transition-all duration-500"
                                style="width: {{ $percentage }}%;">
                            </div>

                            {{-- PERCENT HOVER --}}
                            <span
                                class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-600 opacity-0 group-hover:opacity-100 transition">
                                {{ $percentage }}%
                            </span>
                        </div>

                    </div>

                @empty
                    <div class="text-center py-10 text-gray-500">
                        <i class="fa-solid fa-chart-column text-3xl mb-3"></i>
                        <p>Belum ada data pendapatan.</p>
                    </div>
                @endforelse

            </div>
        @endif

    </main>

    {{-- ===================== SCRIPTS ===================== --}}
    <script>
        function updateGreeting() {
            const now = new Date();
            const hour24 = now.getHours();
            const minute = now.getMinutes();
            const second = now.getSeconds();

            const ampm = hour24 >= 12 ? 'PM' : 'AM';
            const hour12 = hour24 % 12 || 12;

            const formattedTime =
                `${String(hour12).padStart(2,'0')}:${String(minute).padStart(2,'0')}:${String(second).padStart(2,'0')} ${ampm}`;

            let greetingText, iconUrl, bgClass, textClass, subTextClass;

            if (hour24 < 10) {
                greetingText = 'Selamat pagi!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/869/869869.png';
                bgClass = 'bg-yellow-50';
                textClass = 'text-gray-800';
                subTextClass = 'text-gray-600';

            } else if (hour24 < 15) {
                greetingText = 'Selamat siang!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/1163/1163661.png';
                bgClass = 'bg-blue-50';
                textClass = 'text-gray-800';
                subTextClass = 'text-gray-600';

            } else if (hour24 < 18) {
                greetingText = 'Selamat sore!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/414/414927.png';
                bgClass = 'bg-orange-50';
                textClass = 'text-gray-800';
                subTextClass = 'text-gray-600';

            } else {
                greetingText = 'Selamat malam!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/1163/1163624.png';
                bgClass = 'bg-gradient-to-r from-gray-900 to-gray-800'; // 🔥 lebih keren
                textClass = 'text-white';
                subTextClass = 'text-gray-300';
            }

            const card = document.getElementById('greeting-card');

            card.className =
                `p-6 rounded-b-2xl animate__animated animate__fadeInUp flex flex-col md:flex-row items-center justify-between gap-6 transition-all duration-500 ${bgClass}`;

            // 🌙 Glow effect malam
            if (hour24 >= 18) {
                card.classList.add('shadow-[0_0_30px_rgba(255,255,255,0.05)]');
            }

            // TEXT UTAMA
            const greetingEl = document.getElementById('greeting');
            greetingEl.textContent = greetingText;
            greetingEl.className = `text-2xl font-semibold ${textClass}`;

            // JAM
            const timeEl = document.getElementById('time');
            timeEl.textContent = formattedTime;
            timeEl.className = `text-lg ${subTextClass} mt-1 font-mono tracking-widest`;

            // DESKRIPSI
            const descEl = document.getElementById('desc-text');
            descEl.className = `mt-4 ${subTextClass} leading-relaxed`;

            // ICON
            document.getElementById('greeting-icon').src = iconUrl;
        }

        setInterval(updateGreeting, 1000);
        updateGreeting();

        // ===================== TOGGLE STATS =====================
        document.addEventListener('DOMContentLoaded', () => {
            const stats = document.getElementById('stats-panel');
            const btn = document.getElementById('toggle-stats');

            function applyStatsState(show) {
                stats.classList.toggle('hidden', !show);
                btn.textContent = show ?
                    'Sembunyikan Statistik Transaksi & Pelanggan' :
                    'Tampilkan Statistik Transaksi & Pelanggan';
                btn.setAttribute('aria-expanded', show ? 'true' : 'false');
            }

            const saved = localStorage.getItem('showStats');
            const initialShow = saved === null ? true : (saved === 'true');

            applyStatsState(initialShow);

            btn.addEventListener('click', () => {
                const newShow = stats.classList.contains('hidden');
                localStorage.setItem('showStats', String(newShow));
                applyStatsState(newShow);
            });
        });
    </script>
@endsection
