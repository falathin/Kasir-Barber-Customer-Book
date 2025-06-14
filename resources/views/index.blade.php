@extends('layouts.app')

@section('title', 'Dashboard Kasir')

@section('content')
<main class="space-y-6">
    <!-- Greeting Section -->
    <div id="greeting-card"
        class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp flex flex-col md:flex-row items-center justify-between gap-6">
        <div>
            <h2 id="greeting" class="text-2xl font-semibold text-gray-800"></h2>
            <p id="time" class="text-lg text-gray-700 mt-1 font-mono tracking-widest"></p>

            <p class="mt-4 text-gray-600 leading-relaxed">
                Selamat datang kembali, <span class="font-semibold text-indigo-600">Admin Kasir</span>! <br>
                Semoga harimu menyenangkan dan penuh produktivitas. Silakan lihat statistik harianmu di bawah ini.
            </p>
        </div>
        <div class="w-32 h-32 md:w-40 md:h-40">
            <img id="greeting-icon" src="https://cdn-icons-png.flaticon.com/512/219/219969.png" alt="Welcome"
                class="w-full h-full object-cover animate__animated animate__fadeInRight" />
        </div>
    </div>

    <!-- Toggleable Stats Section -->
    <div class="bg-white p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp">
        <button id="toggle-stats"
            class="px-5 py-2 bg-indigo-500 text-white rounded-full hover:bg-indigo-600 transition duration-200">
            Tampilkan Statistik Transaksi
        </button>

        <div id="stats-panel" class="mt-6 space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="p-5 bg-green-50 rounded-xl shadow">
                    <h3 class="text-md font-medium text-green-700">Total Transaksi Hari Ini</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ $totalTransaksi }}</p>
                </div>
                <div class="p-5 bg-blue-50 rounded-xl shadow">
                    <h3 class="text-md font-medium text-blue-700">Total Pendapatan</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">Rp
                        {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <div class="p-5 bg-yellow-50 rounded-xl shadow">
                    <h3 class="text-md font-medium text-yellow-700">Produk Terjual</h3>
                    <p class="text-3xl font-bold text-yellow-600 mt-2">{{ $produkTerjual }}</p>
                </div>
                <div class="p-5 bg-red-50 rounded-xl shadow">
                    <h3 class="text-md font-medium text-red-700">Komisi Kasir Hari Ini</h3>
                    <p class="text-3xl font-bold text-red-600 mt-2">Rp {{ number_format($komisiKasir, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>
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

        const formattedTime = `${String(hour12).padStart(2, '0')}:${String(minute).padStart(2, '0')}:${String(second).padStart(2, '0')} ${ampm}`;

        let greetingText, iconUrl, bgClass;

        if (hour24 < 10) {
            greetingText = 'Selamat pagi!';
            iconUrl = 'https://cdn-icons-png.flaticon.com/512/869/869869.png'; // Morning
            bgClass = 'bg-yellow-50';
        } else if (hour24 < 15) {
            greetingText = 'Selamat siang!';
            iconUrl = 'https://cdn-icons-png.flaticon.com/512/1163/1163661.png'; // Noon
            bgClass = 'bg-blue-50';
        } else if (hour24 < 18) {
            greetingText = 'Selamat sore!';
            iconUrl = 'https://cdn-icons-png.flaticon.com/512/414/414927.png'; // Afternoon
            bgClass = 'bg-orange-50';
        } else {
            greetingText = 'Selamat malam!';
            iconUrl = 'https://cdn-icons-png.flaticon.com/512/1163/1163624.png'; // Night
            bgClass = 'bg-gray-800 text-white';
        }

        document.getElementById('greeting').textContent = greetingText;
        document.getElementById('time').textContent = formattedTime;
        document.getElementById('greeting-icon').src = iconUrl;

        const card = document.getElementById('greeting-card');
        card.className = `p-6 rounded-2xl shadow-lg animate__animated animate__fadeInUp flex flex-col md:flex-row items-center justify-between gap-6 ${bgClass}`;
    }

    setInterval(updateGreeting, 1000);
    updateGreeting();

    // Toggle statistik
    document.getElementById('toggle-stats').addEventListener('click', () => {
        const stats = document.getElementById('stats-panel');
        const toggleBtn = document.getElementById('toggle-stats');
        stats.classList.toggle('hidden');
        toggleBtn.textContent = stats.classList.contains('hidden')
            ? 'Tampilkan Statistik Transaksi'
            : 'Sembunyikan Statistik Transaksi';
    });
</script>
@endsection