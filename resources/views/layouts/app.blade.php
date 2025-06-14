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
    <aside id="sidebar"
        class="fixed inset-y-0 left-0 z-20 w-64 transform -translate-x-full bg-white border-r border-gray-200
                transition-transform duration-300 ease-in-out md:translate-x-0">
        <div class="p-6 flex items-center space-x-3">
            <img src="{{ asset('images/bb-logo.png') }}" alt="Logo" class="w-10 h-10 rounded-full shadow-md">
            <h1 class="text-2xl font-bold bg-gradient-to-r from-orange-900 via-orange-800 to-yellow-800 bg-clip-text text-transparent"
                style="font-family: 'Rye', cursive;"">Barber Kasir</h1>
        </div>
        <nav class="mt-6">
            <ul>
                <li class="mb-1">
                    <a href="{{ route('dashboard') }}"
                        class="group flex items-center px-6 py-3 rounded-md transition-all duration-200 ease-in-out
        {{ request()->routeIs('dashboard')
            ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-600'
            : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} 
        relative overflow-hidden">

                        <span
                            class="absolute left-0 top-2 bottom-2 my-auto w-1 rounded-full
                     bg-indigo-600 scale-y-0 group-hover:scale-y-100 opacity-0 group-hover:opacity-100
                     transition-all duration-300 ease-out origin-top"></span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-3 text-gray-700 group-hover:text-indigo-600 
                   transition-all duration-200 transform group-hover:scale-110"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zm0 8a2 2 0 00-2 2v2a2 2 0
                     002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zm8-8a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0
                     002-2V5a2 2 0 00-2-2h-2zm0 8a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0
                     00-2-2h-2z" />
                        </svg>

                        <span class="flex-1 transition-opacity duration-200">Dashboard</span>
                    </a>
                </li>

                <li class="mb-1">
                    <a href="{{ route('customer-books.index') }}"
                        class="group flex items-center px-6 py-3 rounded-md transition-all duration-200 ease-in-out
        {{ request()->routeIs('customer-books.*')
            ? 'bg-indigo-50 text-indigo-600 border-l-4 border-indigo-600'
            : 'text-gray-700 hover:bg-indigo-50 hover:text-indigo-600' }} 
        relative overflow-hidden">

                        <span
                            class="absolute left-0 top-2 bottom-2 my-auto w-1 rounded-full
                     bg-indigo-600 scale-y-0 group-hover:scale-y-100 opacity-0 group-hover:opacity-100
                     transition-all duration-300 ease-out origin-top"></span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-3 text-gray-700 group-hover:text-indigo-600 
                   transition-all duration-200 transform group-hover:scale-110"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a4 4 0 100 8 4 4 0 000-8zM2 16a8 8 0 1116 0H2z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 transition-opacity duration-200">Customer Books</span>
                    </a>
                </li>
                <li class="mt-6 border-t pt-4">
                    <button type="submit"
                        class="w-full text-left group flex items-center px-6 py-3 rounded-md transition-all duration-200 ease-in-out
            text-red-600 hover:bg-red-50 hover:text-red-700 relative overflow-hidden">
                        <span
                            class="absolute left-0 top-2 bottom-2 my-auto w-1 rounded-full
                bg-red-600 scale-y-0 group-hover:scale-y-100 opacity-0 group-hover:opacity-100
                transition-all duration-300 ease-out origin-top"></span>

                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 mr-3 text-red-600 group-hover:text-red-700 transition-all duration-200 transform group-hover:scale-110"
                            fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M3 4a1 1 0 011-1h6a1 1 0 110 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm13.707 5.293a1 1 0 00-1.414 1.414L17.586 12H9a1 1 0 100 2h8.586l-2.293 2.293a1 1 0 001.414 1.414l4-4a1 1 0 000-1.414l-4-4z"
                                clip-rule="evenodd" />
                        </svg>

                        <span class="flex-1 transition-opacity duration-200">Logout</span>
                    </button>
                </li>

            </ul>
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
                <div class="relative">
                    <button class="text-gray-600 focus:outline-none">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6 text-gray-600 hover:text-indigo-600 transition duration-200 transform hover:scale-110"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0a3 3 0 11-6 0h6z" />
                        </svg>

                    </button>
                    <span
                        class="absolute top-0 right-0 inline-block w-2 h-2 bg-red-600 rounded-full animate-ping"></span>
                </div>
                <div>
                    <img src="https://ui-avatars.com/api/?name=Admin+Kasir&background=4F46E5&color=fff"
                        alt="Admin Kasir"
                        class="h-8 w-8 rounded-full border-2 border-indigo-500 animate__animated animate__fadeIn" />
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
