@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
    <main class="space-y-6 p-4">
        <!-- Greeting Section -->
        <div id="greeting-card"
            class="p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp flex flex-col md:flex-row items-center justify-between gap-6 bg-yellow-50">
            <div>
                <h2 id="greeting" class="text-2xl font-semibold text-gray-800"></h2>
                <p id="time" class="text-lg text-gray-700 mt-1 font-mono tracking-widest"></p>

                <p class="mt-4 text-gray-600 leading-relaxed">
                    Hai <span class="font-semibold text-indigo-600">
                        {{ auth()->user()->level === 'admin' ? 'Admin Barber' : 'Kasir' }}
                    </span> <span class="font-semibold text-indigo-600">{{ auth()->user()->name }}</span>! <br>
                    Semoga harimu menyenangkan dan penuh produktivitas. Silakan lihat statistik harianmu di bawah ini.
                </p>

            </div>
            <div class="w-32 h-32 md:w-40 md:h-40">
                <img id="greeting-icon" src="https://cdn-icons-png.flaticon.com/512/869/869869.png" alt="Welcome"
                    class="w-full h-full object-cover animate__animated animate__fadeInRight" />
            </div>
        </div>

        <!-- Toggleable Stats Section -->
        <div class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp">
            <button id="toggle-stats"
                class="px-5 py-2 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200">
                Tampilkan Statistik Transaksi & Pelanggan
            </button>

            <div id="stats-panel" class="mt-6 block" role="region" aria-label="Statistics Panel">
                <div class="grid w-full grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-6 gap-y-8">
                    <!-- Transaksi Hari Ini -->
                    <div class="p-5 bg-green-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-green-700">Total Transaksi Hari Ini</h3>
                            <!-- Icon: Shopping Cart -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                    title="Icon Keranjang Belanja">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 9m5-9v9m4-9v9m4-9l2 9" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalTransaksi }}</p>
                    </div>

                    <!-- Pendapatan Hari Ini -->
                    <div class="p-5 bg-blue-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-blue-700">Total Pendapatan Hari Ini</h3>
                            <!-- Icon: Cash -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" title="Icon Uang">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8c-1.657 0-3 1.343-3 3v2a3 3 0 006 0v-2c0-1.657-1.343-3-3-3zm0 0V6m0 14v-2" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-blue-600 mt-2">Rp
                            {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>

                    <!-- Pengembalian -->
                    <div class="p-5 bg-red-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-red-700">Total Belum Lunas (Pengembalian)</h3>
                            <!-- Icon: Arrow U-turn Left -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" title="Icon Pengembalian">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 14l-5-5m0 0l5-5m-5 5h12a9 9 0 019 9v3" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-red-600 mt-2">-Rp
                            {{ number_format(abs($totalPengembalian), 0, ',', '.') }}</p>
                    </div>

                    <!-- Pelanggan Hari Ini -->
                    <div class="p-5 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-purple-700">Pelanggan Hari Ini</h3>
                            <!-- Icon: User -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" title="Icon Pengguna">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.668 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $customersToday }}</p>
                    </div>

                    <!-- Pelanggan Bulan Ini -->
                    <div class="p-5 bg-pink-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-pink-700">Pelanggan Bulan Ini</h3>
                            <!-- Icon: Calendar -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true" title="Icon Kalender">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-pink-600 mt-2">{{ $customersMonth }}</p>
                    </div>

                    <!-- Pendapatan Bulanan -->
                    <div class="p-5 bg-yellow-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-yellow-700">Pendapatan Bulanan</h3>
                            <!-- Icon: Chart Bar -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                    title="Icon Grafik Batang">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-6m4 6v-10m4 10v-4M3 21h18" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">Rp
                            {{ number_format($pendapatanBulanan, 0, ',', '.') }}</p>
                    </div>

                    <!-- Pendapatan Tahunan -->
                    <div class="p-5 bg-indigo-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-indigo-700">Pendapatan Tahunan</h3>
                            <!-- Icon: Calendar with Dollar -->
                            <div class="bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true"
                                    title="Icon Kalender Uang">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M12 12v4m2-2h-4m4 0h-4m0 0v4m0-4v-4m-6 8h12a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v7a2 2 0 002 2z" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-indigo-600 mt-2">Rp
                            {{ number_format($pendapatanTahunan, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

        </div>
        @php
            $pendapatanPerBarber = collect($pendapatanPerBarber); // pastikan ini Collection
            $maxTotal = $pendapatanPerBarber->max('total') ?: 1;
            $medals = ['🥇', '🥈', '🥉'];
            $colors = ['bg-yellow-400', 'bg-gray-400', 'bg-orange-400']; // Top 3 colors
        @endphp


@php
    $role = Auth::user()->role ?? 'kasir';
@endphp

@if ($role !== 'kasir')
    <div class="mt-10 bg-white p-6 rounded-xl shadow-xl animate__animated animate__fadeInUp">
        <h2 class="text-2xl font-bold text-indigo-700 mb-6">📊 Ranking Pendapatan Per Barber</h2>

        @forelse ($pendapatanPerBarber as $index => $item)
            @php
                $percentage = round(($item->total / $maxTotal) * 100);
                $barColor = $colors[$index] ?? 'bg-indigo-500';
                $medal = $medals[$index] ?? null;
            @endphp

            <div class="mb-6">
                <div class="flex items-center justify-between mb-2">
                    <div class="flex items-center gap-2 text-gray-700 font-semibold">
                        <span class="text-lg">
                            {{ $medal ?? $index + 1 . '.' }}
                        </span>
                        <span>{{ $item->barber_name }}</span>
                    </div>
                    <span class="text-indigo-600 font-bold text-lg">
                        Rp {{ number_format($item->total, 0, ',', '.') }}
                    </span>
                </div>
                <div class="relative w-full bg-gray-100 rounded-full h-5 overflow-hidden group">
                    <div class="h-5 rounded-full {{ $barColor }} transition-all duration-500"
                        style="width: {{ $percentage }}%;">
                    </div>
                    <span
                        class="absolute right-2 top-1/2 -translate-y-1/2 text-xs text-gray-600 opacity-0 group-hover:opacity-100 transition">
                        {{ $percentage }}%
                    </span>
                </div>
            </div>
        @empty
            <p class="text-gray-500 italic">Belum ada data pendapatan.</p>
        @endforelse
    </div>
@endif

    </main>

    <!-- Scripts -->
    <script>
        function updateGreeting() {
            const now = new Date();
            const hour24 = now.getHours();
            const minute = now.getMinutes();
            const second = now.getSeconds();

            // Convert to 12-hour format
            const ampm = hour24 >= 12 ? 'PM' : 'AM';
            const hour12 = hour24 % 12 || 12;
            const formattedTime =
                `${String(hour12).padStart(2, '0')}:${String(minute).padStart(2, '0')}:${String(second).padStart(2, '0')} ${ampm}`;

            // Determine greeting text and styles
            let greetingText, iconUrl, bgClass, textClass;
            if (hour24 < 10) {
                greetingText = 'Selamat pagi!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/869/869869.png';
                bgClass = 'bg-yellow-50';
                textClass = 'text-gray-800';
            } else if (hour24 < 15) {
                greetingText = 'Selamat siang!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/1163/1163661.png';
                bgClass = 'bg-blue-50';
                textClass = 'text-gray-800';
            } else if (hour24 < 18) {
                greetingText = 'Selamat sore!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/414/414927.png';
                bgClass = 'bg-orange-50';
                textClass = 'text-gray-800';
            } else {
                greetingText = 'Selamat malam!';
                iconUrl = 'https://cdn-icons-png.flaticon.com/512/1163/1163624.png';
                bgClass = 'bg-gray-800';
                textClass = 'text-white';
            }

            const card = document.getElementById('greeting-card');
            card.className =
                `p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp flex flex-col md:flex-row items-center justify-between gap-6 ${bgClass}`;

            document.getElementById('greeting').textContent = greetingText;
            document.getElementById('greeting').className = `text-2xl font-semibold ${textClass}`;
            document.getElementById('time').textContent = formattedTime;
            document.getElementById('time').className =
                `text-lg ${ textClass === 'text-white' ? 'text-gray-300' : 'text-gray-700' } mt-1 font-mono tracking-widest`;
            document.getElementById('greeting-icon').src = iconUrl;
        }
        setInterval(updateGreeting, 1000);
        updateGreeting();

        // Toggle statistik
        document.getElementById('toggle-stats').addEventListener('click', () => {
            const stats = document.getElementById('stats-panel');
            const btn = document.getElementById('toggle-stats');
            stats.classList.toggle('hidden');
            btn.textContent = stats.classList.contains('hidden') ?
                'Tampilkan Statistik Transaksi & Pelanggan' :
                'Sembunyikan Statistik Transaksi & Pelanggan';
        });
    </script>
@endsection
