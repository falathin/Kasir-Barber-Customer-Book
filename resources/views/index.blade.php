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
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-10 w-10 text-green-500 drop-shadow-lg transition-transform duration-300 hover:scale-110" 
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                        d="M3 3h2l.4 2m0 0L7 13h10l4-8H5.4z" />
                                <circle cx="9" cy="18" r="1.5" fill="currentColor"/>
                                <circle cx="17" cy="18" r="1.5" fill="currentColor"/>
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
                            <div class="bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-7 w-7 text-blue-600"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <!-- Gambar lembar uang -->
                                <rect x="3" y="6" width="18" height="12" rx="2" ry="2" stroke="currentColor" fill="none"/>
                                <!-- Lingkaran di tengah (simbol uang) -->
                                <circle cx="12" cy="12" r="3" stroke="currentColor" fill="none"/>
                                <!-- Garis tambahan biar mirip uang -->
                                <line x1="6" y1="9" x2="6" y2="15" stroke="currentColor"/>
                                <line x1="18" y1="9" x2="18" y2="15" stroke="currentColor"/>
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
                            <div class="bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-7 w-7 text-red-500" fill="none" viewBox="0 0 24 24" 
                                    stroke="CurrentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v12m0 0l-4-4m4 4l4-4" />
                                    <path stroke-linecap="round" d="M5 21h14" />
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
                            <div class="bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-7 w-7 text-purple-500" fill="none" 
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <!-- Kepala -->
                                <circle cx="12" cy="8" r="4" />
                                <!-- Bahu -->
                                <path stroke-linecap="round" stroke-linejoin="round" 
                                    d="M4 20c0-4 4-7 8-7s8 3 8 7" />
                            </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-purple-600 mt-2">{{ $customersToday }}</p>
                    </div>

                    <!-- Pelanggan Bulan Ini -->
                    <div class="p-5 bg-pink-50 rounded-xl shadow hover:shadow-lg transition">
                        <div class="flex items-center justify-between">
                        <h3 class="text-base font-semibold text-pink-700 tracking-wide">
                            Pelanggan Bulan Ini
                        </h3>
                        <!-- Icon: Calendar -->
                        <div class="bg-pink-50 rounded-full p-2 shadow hover:shadow-md transition-all duration-300">
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                class="h-6 w-6 text-pink-500" fill="none" 
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" 
                                aria-hidden="true" title="Icon Kalender">
                            <!-- Badan kalender -->
                            <rect x="3" y="5" width="18" height="16" rx="2" ry="2" />
                            <!-- Garis header -->
                            <line x1="3" y1="9" x2="21" y2="9" />
                            <!-- Ring pengikat -->
                            <line x1="8" y1="3" x2="8" y2="7" />
                            <line x1="16" y1="3" x2="16" y2="7" />
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
                             <div class="bg-white rounded-full p-3 shadow-md hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg" 
                                    class="h-7 w-7 text-yellow-500" fill="currentColor" 
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <!-- Sumbu X -->
                                    <line x1="3" y1="20" x2="21" y2="20" stroke="currentColor" stroke-width="2" />
                                    <!-- Batang -->
                                    <rect x="6" y="12" width="2" height="8" rx="1" />
                                    <rect x="11" y="8" width="2" height="12" rx="1" />
                                    <rect x="16" y="14" width="2" height="6" rx="1" />
                                </svg>
                            </div>
                        </div>
                        <p class="text-3xl font-bold text-yellow-600 mt-2">Rp
                            {{ number_format($pendapatanBulanan, 0, ',', '.') }}</p>
                    </div>

                    <!-- Pendapatan Tahunan -->
                    <div class="p-5 rounded-2xl shadow-lg hover:shadow-2xl transition transform hover:-translate-y-1 
                                bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500">
                        
                        <div class="flex items-center justify-between">
                            <h3 class="text-md font-medium text-white">Pendapatan Tahunan</h3>
                            
                            <!-- Icon: Calendar with Chart (Pendapatan Tahunan) -->
                            <div class="bg-white/20 backdrop-blur-md rounded-full p-3 shadow-md 
                                        hover:shadow-lg transition-all duration-300">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2"
                                    class="h-8 w-8 text-white"
                                    aria-hidden="true" title="Icon Pendapatan Tahunan">

                                    <!-- Frame Kalender -->
                                    <rect x="3" y="5" width="20" height="18" rx="2" ry="2"/>
                                    <line x1="3" y1="9" x2="21" y2="9"/>
                                    <line x1="8" y1="3" x2="8" y2="7"/>
                                    <line x1="16" y1="3" x2="16" y2="7"/>

                                    <!-- Grafik Batang -->
                                    <rect x="9"  y="16" width="2" height="4" rx="1"/>
                                    <rect x="12" y="14" width="2" height="6" rx="1"/>
                                    <rect x="15" y="12" width="2" height="8" rx="1"/>
                                </svg>
                            </div>
                        </div>

                        <p class="text-4xl font-extrabold text-white mt-3 drop-shadow-md">
                            Rp {{ number_format($pendapatanTahunan, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

        </div>
        @php
            $pendapatanPerBarber = collect($pendapatanPerBarber);
            $maxTotal = $pendapatanPerBarber->max('total') ?: 1;
            $medals = ['🥇', '🥈', '🥉'];
            $colors = ['bg-yellow-400', 'bg-gray-400', 'bg-orange-400']; 
        @endphp


        @php
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
