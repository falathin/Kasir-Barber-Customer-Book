<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') - Barber Kasir</title>

    <!-- Favicon di tab browser -->
    <link rel="icon" href="{{ asset('images/bb-logo.png') }}" type="image/png">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Rye&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
</head>

<body class="flex h-full flex-col bg-gray-100">
    <!-- Sidebar -->
{{-- resources/views/components/sidebar.blade.php --}}
<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-20 w-64 transform -translate-x-full bg-white border-r border-gray-200
   transition-transform duration-300 ease-in-out md:translate-x-0">
    <div class="p-6 flex items-center space-x-3">
        <img src="{{ asset('images/bb-logo.png') }}" alt="Logo" class="w-15 h-12 rounded-full shadow-md">
        <h3 class="text-center text-2xl font-bold bg-gradient-to-r from-orange-900 via-orange-800 to-yellow-800 bg-clip-text text-transparent"
            style="font-family: 'Rye', cursive;">
            <span class="block text-3xl leading-none">BB</span>
            Hair Studio
        </h3>
    </div>
    <nav class="mt-6">
        <ul>
@php
    $menus = [
        [
            'label' => 'Dashboard',
            'route' => 'dashboard',
            'icon'  => <<<'SVG'
<path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 8a2 2 0 00-2 2v2a2 2 0
002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zm8-8a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0
002-2V5a2 2 0 00-2-2h-2zm0 8a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0
00-2-2h-2z"/>
SVG,
        ],
        [
            'label' => 'Customer Books',
            'route' => 'customer-books.index',
            'icon'  => <<<'SVG'
<path fill-rule="evenodd"
    d="M10 2a4 4 0 100 8 4 4 0 000-8zM2 16a8 8 0 1116 0H2z"
    clip-rule="evenodd"/>
SVG,
        ],
        [
            'label' => 'Capsters',
            'route' => 'capsters.index',
            'icon'  => <<<'SVG'
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
    d="M12 2v2M12 20v2M15 4H9a1 1 0 00-1 1v14a1 1 0 001 1h6a1 1 0 001-1V5a1 1 0 00-1-1z" />
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
    d="M9 6l6 3-6 3 6 3-6 3" />
SVG,
            'stroke'=> true,
        ],
        [
            'label' => 'Notes',
            'route' => 'notes.index',
            'icon'  => <<<'SVG'
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
      d="M4 5a2 2 0 012-2h8.586a2 2 0 011.414.586l2.414 2.414A2 2 0 0119 7.414V19a2 2 0 01-2 2H6a2 2 0 01-2-2V5z" />
<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
      d="M8 8h8M8 11h8M8 14h6M8 17h4" />
SVG,
        ],
    ];
@endphp

        @foreach ($menus as $menu)
            @php
                $isCapster = $menu['label'] === 'Capsters';
                $isAdmin   = auth()->user()->level === 'admin';
                // Lewati Capsters jika bukan admin
                if ($isCapster && ! $isAdmin) continue;
                $isActive  = request()->routeIs(str_replace('.index', '*', $menu['route']));
            @endphp
            <li class="mb-1">
                <a href="{{ route($menu['route']) }}"
                   class="group flex items-center px-6 py-3 rounded-md relative overflow-hidden transition-all duration-200 ease-in-out
                   {{ $isActive ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-600' : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }}">

                    <span class="absolute left-0 top-2 bottom-2 my-auto w-1 rounded-full
                        bg-indigo-600 scale-y-0 group-hover:scale-y-100 opacity-0 group-hover:opacity-100
                        transition-all duration-300 ease-out origin-top"></span>

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 mr-3 {{ $isActive ? 'text-indigo-600' : 'text-gray-700 group-hover:text-indigo-600' }}
                         transition-all duration-200 transform group-hover:scale-110"
                         viewBox="0 0 20 20"
                         {{ isset($menu['stroke']) ? 'fill=none stroke=currentColor' : 'fill=currentColor' }}>
                        {!! $menu['icon'] !!}
                    </svg>

                    <span class="flex-1">{{ $menu['label'] }}</span>
                </a>
            </li>
        @endforeach

            <!-- Logout -->
            <li class="mt-6 border-t pt-4">
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="button" id="logout-button"
                        class="w-full text-left group flex items-center px-6 py-3 rounded-md transition-all duration-200 ease-in-out
                            text-red-600 hover:bg-red-50 hover:text-red-700 relative overflow-hidden">
                        <span class="absolute left-0 top-2 bottom-2 my-auto w-1 rounded-full
                                    bg-red-600 scale-y-0 group-hover:scale-y-100 opacity-0 group-hover:opacity-100
                                    transition-all duration-300 ease-out origin-top"></span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-3 text-red-600 group-hover:text-red-700 transition-all duration-200 transform group-hover:scale-110"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                            <polyline points="16 17 21 12 16 7"/>
                            <line x1="21" y1="12" x2="9" y2="12"/>
                        </svg>

                        <span class="flex-1">Logout</span>
                    </button>
                </form>
            </li>
        </ul>
        <!-- SweetAlert2 CDN -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const logoutBtn = document.getElementById("logout-button");
                const logoutForm = document.getElementById("logout-form");

                logoutBtn.addEventListener("click", function (e) {
                    e.preventDefault();

                    Swal.fire({
                        title: 'Yakin ingin logout?',
                        text: "Kamu akan keluar dari akun ini.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#aaa',
                        confirmButtonText: 'Ya, logout',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            logoutForm.submit();
                        }
                    });
                });
            });
        </script>
    </nav>
</aside>


    <!-- Main Content -->
    <div class="flex flex-1 flex-col overflow-auto ml-0 md:ml-64">
        <header class="flex items-center justify-between bg-white p-4 border-b border-gray-200">
            <button id="btn-toggle" class="text-gray-700 md:hidden">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <h2 class="ml-2 text-xl font-semibold text-gray-800">@yield('title', 'Dashboard')</h2>
            <div class="flex items-center space-x-4">
            @if(auth()->user()->level === 'admin')
                <div class="relative">
                    {{-- Link ke halaman customer books --}}
                    <a href="{{ route('customer-books.index') }}"
                        class="block text-gray-600 hover:text-indigo-600 transition duration-200 transform hover:scale-110 relative">
                        {{-- Bell Icon --}}
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 
                                0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 
                                2 0 10-4 0v.341C7.67 6.165 6 8.388 6 
                                11v3.159c0 .538-.214 1.055-.595 
                                1.436L4 17h5m6 0a3 3 0 11-6 0h6z" />
                        </svg>

                        {{-- Red Dot Ping Animation --}}
                        @if($pendingCount > 0)
                            <span class="absolute top-0 right-0 w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
                        @endif

                        {{-- Badge Count Number --}}
                        @if($pendingCount > 0)
                            <span
                                class="absolute -top-2 -right-2 min-w-[18px] h-[18px] px-1 bg-red-600 text-white text-xs font-bold rounded-full flex items-center justify-center shadow">
                                {{ $pendingCount }}
                            </span>
                        @endif
                    </a>
                </div>
            @endif

                @php
                    // anggap semua route admin dan kasirs.* dianggap aktif
                    $isAdminSection = request()->routeIs('admin.dashboard') 
                                    || request()->routeIs('kasirs.*');
                @endphp

                <div>
                    <a href="{{ route('profile.edit') }}">
                        <img
                            src="https://ui-avatars.com/api/?name=Admin+Kasir&background=4F46E5&color=fff"
                            alt="Admin Kasir"
                            @class([
                                'h-8 w-8 rounded-full border-2 transition-transform duration-200 ease-out animate__animated animate__fadeIn',
                                // jika aktif, beri border kuning dan sedikit diperbesar
                                'border-yellow-400 scale-110' => $isAdminSection,
                                // jika tidak aktif, pakai border default
                                'border-indigo-500 scale-100' => ! $isAdminSection,
                            ]) 
                        />
                    </a>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 bg-gray-100 overflow-auto animate__animated animate__fadeInUp">
            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="bg-white border-t border-gray-200 p-4 text-center text-sm text-gray-500">
            BBMen’s Haircut Customer Book &copy; {{ date('Y') }}
        </footer>
    </div>

    <script>
        const btn = document.getElementById('btn-toggle');
        const sidebar = document.getElementById('sidebar');
        const content = document.querySelector('div.ml-0');
        btn.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
            content.classList.toggle('ml-64');
        });
    </script>
</body>

</html>