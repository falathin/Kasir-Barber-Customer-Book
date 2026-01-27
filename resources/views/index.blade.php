@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
    <main class="space-y-6 p-4">

        {{-- ===================== GREETING CARD ===================== --}}
        <div class="rounded-2xl overflow-hidden shadow-2xl">

            {{-- Barber stripe dekoratif di atas card --}}
            <div class="flex h-1">
                <div class="w-1/3 bg-red-600"></div>
                <div class="w-1/3 bg-white"></div>
                <div class="w-1/3 bg-blue-600"></div>
            </div>

            <div id="greeting-card"
                class="p-6 rounded-b-2xl animate__animated animate__fadeInUp
                   flex flex-col md:flex-row items-center justify-between gap-6 bg-yellow-50">

                {{-- Bagian teks greeting --}}
                <div class="flex-1 min-w-0">
                    <h2 id="greeting" class="text-2xl font-semibold text-gray-800"></h2>
                    <p id="time" class="text-lg text-gray-700 mt-1 font-mono tracking-widest"></p>

                    <p class="mt-4 text-gray-600 leading-relaxed">
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
                
                {{-- Bagian ikon greeting --}}
                <div class="w-28 h-28 md:w-36 md:h-36 flex-shrink-0">
                    <img id="greeting-icon" src="https://cdn-icons-png.flaticon.com/512/869/869869.png"
                        class="w-full h-full object-cover rounded-xl shadow-sm animate__animated animate__fadeInRight"
                        alt="Greeting">
                </div>
            </div>
        </div>

        {{-- ===================== TOGGLE STATISTIK (RESPONSIVE MOBILE-CENTERED) ===================== --}}
        <div class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp">
            <button id="toggle-stats"
                class="px-5 py-2 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200"
                aria-controls="stats-panel" aria-expanded="true">
                Tampilkan Statistik Transaksi & Pelanggan
            </button>

            {{-- Panel statistik (bisa disembunyikan) --}}
            <div id="stats-panel" class="mt-6" role="region" aria-label="Statistics Panel">
                {{-- Grid:
                    - Mobile: 1 kolom, items centered
                    - Small (sm) ke atas: 2 kolom
                    - Large (lg) ke atas: auto-fit minmax 250px
                    - justify-items-center di mobile -> membuat card berada di tengah; di sm ke atas stretch agar layout tetap rapi --}}
                <div class="grid w-full grid-cols-1 sm:grid-cols-2 lg:grid-cols-[repeat(auto-fit,minmax(250px,1fr))] gap-6 gap-y-8 justify-items-center sm:justify-items-stretch">
                    {{-- ===================== Total Transaksi Hari Ini ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-green-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-md font-medium text-green-700 text-center sm:text-left">Total Transaksi Hari Ini</h3>
                            <div class="mt-3 sm:mt-0 bg-white rounded-full p-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-10 w-10 text-green-500 drop-shadow-lg transition-transform duration-300 hover:scale-110"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3h2l.4 2m0 0L7 13h10l4-8H5.4z" />
                                    <circle cx="9" cy="18" r="1.5" fill="currentColor" />
                                    <circle cx="17" cy="18" r="1.5" fill="currentColor" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-green-600 mt-4 text-center sm:text-left">{{ $totalTransaksi }}</p>
                    </div>

                    {{-- ===================== Total Pendapatan Hari Ini ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-blue-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-md font-medium text-blue-700 text-center sm:text-left">Total Pendapatan Hari Ini</h3>
                            <div class="mt-3 sm:mt-0 bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="6" width="18" height="12" rx="2" ry="2" stroke="currentColor" fill="none" />
                                    <circle cx="12" cy="12" r="3" stroke="currentColor" fill="none" />
                                    <line x1="6" y1="9" x2="6" y2="15" stroke="currentColor" />
                                    <line x1="18" y1="9" x2="18" y2="15" stroke="currentColor" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-blue-600 mt-4 text-center sm:text-left">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                    </div>

                    {{-- ===================== Total Pengembalian ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-red-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-md font-medium text-red-700 text-center sm:text-left">Total Belum Lunas (Pengembalian)</h3>
                            <div class="mt-3 sm:mt-0 bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="CurrentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4" />
                                    <path stroke-linecap="round" d="M5 21h14" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-red-600 mt-4 text-center sm:text-left">-Rp {{ number_format(abs($totalPengembalian), 0, ',', '.') }}</p>
                    </div>

                    {{-- ===================== Pelanggan Hari Ini ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-purple-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-md font-medium text-purple-700 text-center sm:text-left">Pelanggan Hari Ini</h3>
                            <div class="mt-3 sm:mt-0 bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-purple-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="8" r="4" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 20c0-4 4-7 8-7s8 3 8 7" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-purple-600 mt-4 text-center sm:text-left">{{ $customersToday }}</p>
                    </div>

                    {{-- ===================== Pelanggan Bulan Ini ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-pink-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-base font-semibold text-pink-700 tracking-wide text-center sm:text-left">Pelanggan Bulan Ini</h3>
                            <div class="mt-3 sm:mt-0 bg-pink-50 rounded-full p-2 shadow hover:shadow-md transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <rect x="3" y="5" width="18" height="16" rx="2" ry="2" />
                                    <line x1="3" y1="9" x2="21" y2="9" />
                                    <line x1="8" y1="3" x2="8" y2="7" />
                                    <line x1="16" y1="3" x2="16" y2="7" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-pink-600 mt-4 text-center sm:text-left">{{ $customersMonth }}</p>
                    </div>

                    {{-- ===================== Pendapatan Bulanan ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 bg-yellow-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-md font-medium text-yellow-700 text-center sm:text-left">Pendapatan Bulanan</h3>
                            <div class="mt-3 sm:mt-0 bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-yellow-500" fill="currentColor"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <line x1="3" y1="20" x2="21" y2="20" stroke="currentColor" stroke-width="2" />
                                    <rect x="6" y="12" width="2" height="8" rx="1" />
                                    <rect x="11" y="8" width="2" height="12" rx="1" />
                                    <rect x="16" y="14" width="2" height="6" rx="1" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-yellow-600 mt-4 text-center sm:text-left">Rp {{ number_format($pendapatanBulanan, 0, ',', '.') }}</p>
                    </div>

                    {{-- ===================== Pendapatan Tahunan ===================== --}}
                    <div class="w-full max-w-xs sm:max-w-none p-5 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between items-center">
                            <h3 class="text-md font-medium text-white text-center sm:text-left">Pendapatan Tahunan</h3>
                            <div class="mt-3 sm:mt-0 bg-white/20 backdrop-blur-md rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" class="h-8 w-8 text-white" aria-hidden="true"
                                    title="Icon Pendapatan Tahunan">
                                    <rect x="3" y="5" width="20" height="18" rx="2" ry="2" />
                                    <line x1="3" y1="9" x2="21" y2="9" />
                                    <line x1="8" y1="3" x2="8" y2="7" />
                                    <line x1="16" y1="3" x2="16" y2="7" />
                                    <rect x="9" y="16" width="2" height="4" rx="1" />
                                    <rect x="12" y="14" width="2" height="6" rx="1" />
                                    <rect x="15" y="12" width="2" height="8" rx="1" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-4xl font-extrabold text-white mt-3 drop-shadow-md text-center sm:text-left">
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
                                <span class="text-lg">{{ $medal ?? $index + 1 . '.' }}</span>
                                <span>{{ $item->barber_name }}</span>
                            </div>
                            <span class="text-indigo-600 font-bold text-lg">
                                Rp {{ number_format($item->total, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="relative w-full bg-gray-100 rounded-full h-5 overflow-hidden group">
                            <div class="h-5 rounded-full {{ $barColor }} transition-all duration-500"
                                style="width: {{ $percentage }}%;"></div>
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

    {{-- ===================== SCRIPTS ===================== --}}
    <script>
        // ===================== Fungsi Greeting Card =====================
        function updateGreeting() {
            const now = new Date();
            const hour24 = now.getHours();
            const minute = now.getMinutes();
            const second = now.getSeconds();

            const ampm = hour24 >= 12 ? 'PM' : 'AM';
            const hour12 = hour24 % 12 || 12;
            const formattedTime =
                `${String(hour12).padStart(2,'0')}:${String(minute).padStart(2,'0')}:${String(second).padStart(2,'0')} ${ampm}`;

            // Tentukan greeting, ikon, dan warna background berdasarkan jam
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
                `text-lg ${ textClass === 'text-white' ? 'text-gray-300' : 'text-gray-700'} mt-1 font-mono tracking-widest`;
            document.getElementById('greeting-icon').src = iconUrl;
        }
        setInterval(updateGreeting, 1000);
        updateGreeting();

        // ===================== Toggle Statistik dengan localStorage =====================
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