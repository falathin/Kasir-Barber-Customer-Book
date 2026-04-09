@extends('layouts.app')

@section('title', 'Customer Books')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
            <h1 class="text-3xl font-extrabold text-gray-800">
                <i class="fa-solid fa-book mr-2"></i> Customer Books
            </h1>

            @if (auth()->user()->level === 'admin')
                <div class="flex flex-wrap gap-2">
                    @if ($showAll)
                        <a href="{{ route('customer-books.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-300 text-gray-800 rounded-full shadow hover:bg-gray-400 transition duration-200">
                            <i class="fa-solid fa-arrow-left mr-2"></i> Hari Ini
                        </a>
                    @else
                        <a href="{{ route('customer-books.index', array_merge(request()->query(), ['show' => 'all'])) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition duration-200">
                            <i class="fa-solid fa-calendar-days mr-2"></i> Lihat Semua
                        </a>
                    @endif
                </div>
            @endif
        </div>

        <!-- Filters & Actions -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8 flex-wrap">
            @php
                use Carbon\Carbon;
                $defaultStart = request('start_date', Carbon::today()->toDateString());
                $defaultEnd = request('end_date', Carbon::tomorrow()->toDateString());
            @endphp

            <form method="GET" class="flex flex-wrap gap-3 items-end">
                <!-- Search -->
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}"
                    class="flex-1 min-w-[150px] px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />

                <!-- Barber Filter -->
                @if (auth()->user()->level === 'admin')
                    <select name="barber"
                        class="px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">-- All Barbers --</option>
                        @foreach ($barbers as $name)
                            <option value="{{ $name }}" {{ request('barber') === $name ? 'selected' : '' }}>
                                {{ $name }}
                            </option>
                        @endforeach
                    </select>
                @else
                    <div class="px-4 py-2 bg-gray-100 rounded-full text-sm">
                        Barber: <strong>{{ auth()->user()->name }}</strong>
                    </div>
                    <input type="hidden" name="barber" value="{{ auth()->user()->name }}">
                @endif

                <!-- Status Filter -->
                <select name="status"
                    class="px-4 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">-- All Status --</option>
                    <option value="antre" {{ request('status') === 'antre' ? 'selected' : '' }}>Antre</option>
                    <option value="proses" {{ request('status') === 'proses' ? 'selected' : '' }}>Proses</option>
                    <option value="done" {{ request('status') === 'done' ? 'selected' : '' }}>Done</option>
                </select>

                <!-- Date Filters -->
                <div class="flex items-center gap-2">
                    <label for="start_date" class="text-sm">From:</label>
                    <input type="date" id="start_date" name="start_date" value="{{ $defaultStart }}"
                        class="px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <div class="flex items-center gap-2">
                    <label for="end_date" class="text-sm">To:</label>
                    <input type="date" id="end_date" name="end_date" value="{{ $defaultEnd }}"
                        class="px-3 py-2 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                </div>

                <!-- Filter Button -->
                <button type="submit"
                    class="inline-flex items-center px-6 py-2 bg-indigo-600 text-white rounded-full shadow hover:bg-indigo-700 transition duration-200">
                    <i class="fa-solid fa-magnifying-glass mr-2"></i> Filter
                </button>
            </form>

            <!-- Create Button -->
            <a href="{{ route('customer-books.create') }}"
                class="inline-flex items-center px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-full shadow transition duration-200">
                <i class="fa-solid fa-plus mr-2"></i> Create
            </a>
        </div>

        <!-- Info Text -->
        @if ($showAll)
            <p class="text-sm text-gray-500 mb-4">Menampilkan <strong>semua</strong> data customer book.</p>
        @else
            <p class="text-sm text-gray-500 mb-4">
                Menampilkan data untuk <strong>hari ini</strong> ({{ \Carbon\Carbon::today()->format('d M Y') }})
            </p>
        @endif

        @php
            $productNames = ['Pomade', 'Clay', 'Hair Powder'];

            $normalizeKey = function ($s) {
                $s = (string) $s;
                $s = trim($s);
                $s = preg_replace('/\s*\(.*?\)\s*/', ' ', $s);
                $s = preg_replace('/[^\p{L}\p{N}\s\-\/]+/u', '', $s);
                $s = preg_replace('/\s+/', ' ', $s);
                return mb_strtolower(trim($s));
            };

            $toArrayList = function ($value) {
                if (is_array($value)) {
                    return array_values(array_filter(array_map('trim', $value), fn($v) => $v !== ''));
                }

                if (is_string($value) && $value !== '') {
                    $decoded = json_decode($value, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        return array_values(array_filter(array_map('trim', $decoded), fn($v) => $v !== ''));
                    }

                    return array_values(array_filter(array_map('trim', preg_split('/\s*,\s*/', $value)), fn($v) => $v !== ''));
                }

                return [];
            };
        @endphp

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 hidden md:table">
                <thead class="bg-gray-50">
                    <tr>
                        @foreach (['#', 'Customer', 'C&A', 'Antrian', 'Haircut', 'Services', 'Products', 'Barber', 'Price', 'Payment', 'Status', 'Aksi'] as $col)
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">
                                {{ $col }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="bg-white divide-y divide-gray-100 text-sm">
                    @forelse($books as $book)
                        @php
                            $serviceItems = [];
                            if (!empty($book->services)) {
                                $serviceItems = $toArrayList($book->services);
                            } elseif (!empty($book->colouring_other)) {
                                $serviceItems = $toArrayList($book->colouring_other);
                            }

                            $productItems = [];
                            if (!empty($book->products)) {
                                $productItems = $toArrayList($book->products);
                            } elseif (!empty($book->sell_use_product)) {
                                $productItems = $toArrayList($book->sell_use_product);
                            }

                            // produk yang dulu sempat nyangkut di services dipindah ke products
                            $fixedServices = [];
                            foreach ($serviceItems as $item) {
                                if (in_array($normalizeKey($item), array_map($normalizeKey, $productNames), true)) {
                                    $productItems[] = $item;
                                } else {
                                    $fixedServices[] = $item;
                                }
                            }
                            $serviceItems = $fixedServices;

                            $isDone = $book->price && $book->qr && (
                                !empty($serviceItems) ||
                                $book->hair_coloring_price ||
                                $book->hair_extension_price ||
                                $book->hair_extension_services_price ||
                                !empty($productItems)
                            );

                            $isProses = !$isDone && $book->cap;
                            $isAntre = !$isDone && !$isProses && $book->customer && $book->barber_name && $book->antrian;
                        @endphp

                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2">
                                {{ $books->total() - ($books->currentPage() - 1) * $books->perPage() - $loop->index }}
                            </td>
                            <td class="px-4 py-2">{{ $book->customer ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $book->cap ?? '-' }} &nbsp; {{ $book->asisten }}</td>
                            <td class="px-4 py-2">{{ $book->antrian ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $book->haircut_type ?? '-' }}</td>

                            <td class="px-4 py-2 align-top">
                                <div class="text-sm">
                                    @if (!empty($serviceItems))
                                        <div class="space-y-1">
                                            @foreach ($serviceItems as $item)
                                                <div class="text-gray-700">{{ $item }}</div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-400 mt-1">No service details</div>
                                    @endif

                                    @if ($book->hair_coloring_price)
                                        <div class="text-xs text-gray-500 mt-1">
                                            <span>Hair Coloring Price:</span>
                                            <span class="rupiah font-medium" data-price="{{ $book->hair_coloring_price }}"></span>
                                        </div>
                                    @endif

                                    @if ($book->hair_extension_price)
                                        <div class="text-xs text-gray-500">
                                            <span>Hair Extension Price:</span>
                                            <span class="rupiah font-medium" data-price="{{ $book->hair_extension_price }}"></span>
                                        </div>
                                    @endif

                                    @if ($book->hair_extension_services_price)
                                        <div class="text-xs text-gray-500">
                                            <span>Extension Services:</span>
                                            <span class="rupiah font-medium" data-price="{{ $book->hair_extension_services_price }}"></span>
                                        </div>
                                    @endif

                                    @if (!$book->hair_coloring_price && !$book->hair_extension_price && !$book->hair_extension_services_price && empty($serviceItems))
                                        <div class="text-xs text-gray-400 mt-1">No price details</div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-2 align-top">
                                <div class="text-sm">
                                    @if (!empty($productItems))
                                        <div class="space-y-1">
                                            @foreach ($productItems as $item)
                                                @php
                                                    $productPrice = match ($item) {
                                                        'Pomade' => 85000,
                                                        'Clay' => 85000,
                                                        'Hair Powder' => 25000,
                                                        default => null,
                                                    };
                                                @endphp
                                                <div class="text-gray-700">
                                                    {{ $item }}
                                                    @if ($productPrice)
                                                        <span class="text-xs text-emerald-600">
                                                            — <span class="rupiah" data-price="{{ $productPrice }}"></span>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="text-xs text-gray-400 mt-1">-</div>
                                    @endif
                                </div>
                            </td>

                            <td class="px-4 py-2">{{ $book->barber_name ?? '-' }}</td>
                            <td class="px-4 py-2 rupiah" data-price="{{ $book->price }}"></td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                @if ($book->qr === 'qr_transfer')
                                    <span class="inline-flex items-center whitespace-nowrap shrink-0 px-3 py-1 text-xs font-semibold bg-purple-100 text-purple-800 rounded-full">
                                        QR Transfer
                                    </span>
                                @elseif($book->qr === 'cash')
                                    <span class="inline-flex items-center whitespace-nowrap shrink-0 px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                        Cash
                                    </span>
                                @elseif($book->qr === 'no revenue' || $book->qr === null)
                                    <span class="inline-flex items-center whitespace-nowrap shrink-0 px-3 py-1 text-xs font-semibold bg-red-100 text-red-800 rounded-full">
                                        No Revenue
                                    </span>
                                @else
                                    <span class="inline-flex items-center whitespace-nowrap shrink-0 px-3 py-1 text-xs font-semibold bg-gray-100 text-gray-800 rounded-full">
                                        {{ Str::title($book->qr) }}
                                    </span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                @if ($isDone)
                                    <span class="px-3 py-1 text-xs font-semibold bg-green-100 text-green-800 rounded-full">Done</span>
                                @elseif($isProses)
                                    <span class="px-3 py-1 text-xs font-semibold bg-blue-100 text-blue-800 rounded-full">Proses</span>
                                @elseif($isAntre)
                                    <span class="px-3 py-1 text-xs font-semibold bg-yellow-100 text-yellow-800 rounded-full">Antre</span>
                                @else
                                    <span class="text-gray-400">-</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 whitespace-nowrap">
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('customer-books.show', $book) }}"
                                        class="p-2 bg-green-500 hover:bg-green-600 text-white rounded-full transition"
                                        title="Show">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>

                                    @if (auth()->user()->level === 'admin' || $isAntre)
                                        <a href="{{ route('customer-books.createWithCap', $book) }}"
                                            class="p-2 bg-blue-500 hover:bg-blue-600 text-white rounded-full transition"
                                            title="Proses">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                                viewBox="0 0 24 24">
                                                <path d="M12 22a10 10 0 100-20 10 10 0 000 20zm-1-6l6-4-6-4v8z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if (auth()->user()->level === 'admin' || $isProses)
                                        <a href="{{ route('customer-books.edit', $book) }}"
                                            class="p-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-full transition"
                                            title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.121
                                                    2.121 0 113 3L12 15l-4 1 1-4
                                                    9.586-9.586z" />
                                            </svg>
                                        </a>
                                    @endif

                                    @if (auth()->user()->level === 'admin' || $isAntre)
                                        <form action="{{ route('customer-books.destroy', $book) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-red-500 hover:bg-red-600 text-white rounded-full transition"
                                                title="Delete">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="13" class="py-6 text-center text-gray-500">
                                Tidak ada data ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <!-- MOBILE CARD VIEW -->
            <div class="space-y-6 md:hidden px-4 pb-10">
                @forelse($books as $book)
                    @php
                        $serviceItems = [];
                        if (!empty($book->services)) {
                            $serviceItems = $toArrayList($book->services);
                        } elseif (!empty($book->colouring_other)) {
                            $serviceItems = $toArrayList($book->colouring_other);
                        }

                        $productItems = [];
                        if (!empty($book->products)) {
                            $productItems = $toArrayList($book->products);
                        } elseif (!empty($book->sell_use_product)) {
                            $productItems = $toArrayList($book->sell_use_product);
                        }

                        $fixedServices = [];
                        foreach ($serviceItems as $item) {
                            if (in_array($normalizeKey($item), array_map($normalizeKey, $productNames), true)) {
                                $productItems[] = $item;
                            } else {
                                $fixedServices[] = $item;
                            }
                        }
                        $serviceItems = $fixedServices;

                        $isDone = $book->price && $book->qr && (
                            !empty($serviceItems) ||
                            $book->hair_coloring_price ||
                            $book->hair_extension_price ||
                            $book->hair_extension_services_price ||
                            !empty($productItems)
                        );

                        $isProses = !$isDone && $book->cap;

                        $isAntre = !$isDone
                            && !$isProses
                            && $book->customer
                            && $book->barber_name
                            && $book->antrian;

                        $status = $isDone
                            ? 'DONE'
                            : ($isProses
                                ? 'PROSES'
                                : ($isAntre
                                    ? 'ANTRE'
                                    : 'PENDING'));

                        $statusColor = $isDone
                            ? 'bg-green-100 text-green-700 border-green-500'
                            : ($isProses
                                ? 'bg-blue-100 text-blue-700 border-blue-500'
                                : ($isAntre
                                    ? 'bg-yellow-100 text-yellow-700 border-yellow-500'
                                    : 'bg-gray-100 text-gray-500 border-gray-400'));
                    @endphp

                    <div
                        class="relative bg-gradient-to-br from-white via-slate-50 to-gray-100 border border-gray-200 rounded-xl shadow-lg hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 overflow-hidden">
                        <div class="absolute top-0 left-0 right-0 border-t-2 border-dashed border-gray-300"></div>
                        <div class="absolute bottom-0 left-0 right-0 border-t-2 border-dashed border-gray-300"></div>

                        <div class="absolute inset-y-0 left-0 w-1 bg-gradient-to-b from-pink-300 via-blue-300 to-green-300 opacity-70"></div>

                        <div class="p-5 font-mono text-[13px] text-gray-800">
                            <div class="flex justify-between items-center mb-3">
                                <div>
                                    <p class="font-bold text-sm text-gray-900">{{ $book->customer ?? 'Unknown' }}</p>
                                    <p class="text-[11px] text-gray-500 mt-0.5">
                                        <i class="fa-solid fa-store mr-1"></i> {{ $book->barber_name ?? '-' }}
                                    </p>
                                </div>
                                <span
                                    class="px-2.5 py-1 border rounded-full text-[11px] font-bold uppercase tracking-wide {{ $statusColor }}">
                                    {{ $status }}
                                </span>
                            </div>

                            <div class="border-t border-dashed border-gray-300 mb-3"></div>

                            <div class="space-y-1.5 text-[13px]">
                                <div class="flex justify-between">
                                    <span>C&A</span>
                                    <span>{{ $book->cap ?? '-' }} {{ $book->asisten ? "({$book->asisten})" : '' }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span>Antrian</span>
                                    <span>{{ $book->antrian ?? '-' }}</span>
                                </div>

                                <div class="flex justify-between">
                                    <span>Haircut</span>
                                    <span>{{ $book->haircut_type ?? '-' }}</span>
                                </div>

                                <div class="flex justify-between items-start">
                                    <span>Services</span>
                                    <div class="text-right">
                                        @if (!empty($serviceItems))
                                            <div class="text-sm">
                                                @foreach ($serviceItems as $item)
                                                    <div class="text-gray-700">{{ $item }}</div>
                                                @endforeach
                                            </div>
                                        @else
                                            <div class="text-sm text-gray-400">-</div>
                                        @endif

                                        @if ($book->hair_coloring_price)
                                            <div class="text-xs text-gray-500">
                                                Hair Coloring: <span class="rupiah" data-price="{{ $book->hair_coloring_price }}"></span>
                                            </div>
                                        @endif

                                        @if ($book->hair_extension_price)
                                            <div class="text-xs text-gray-500">
                                                Extension Price: <span class="rupiah" data-price="{{ $book->hair_extension_price }}"></span>
                                            </div>
                                        @endif

                                        @if ($book->hair_extension_services_price)
                                            <div class="text-xs text-gray-500">
                                                Services: <span class="rupiah" data-price="{{ $book->hair_extension_services_price }}"></span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between items-start">
                                    <span>Products</span>
                                    <div class="text-right">
                                        @if (!empty($productItems))
                                            @foreach ($productItems as $item)
                                                @php
                                                    $productPrice = match ($item) {
                                                        'Pomade' => 85000,
                                                        'Clay' => 85000,
                                                        'Hair Powder' => 25000,
                                                        default => null,
                                                    };
                                                @endphp
                                                <div class="text-gray-700">
                                                    {{ $item }}
                                                    @if ($productPrice)
                                                        <span class="text-xs text-emerald-600">
                                                            — <span class="rupiah" data-price="{{ $productPrice }}"></span>
                                                        </span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="text-sm text-gray-400">-</div>
                                        @endif
                                    </div>
                                </div>

                                <div class="flex justify-between">
                                    <span>Price</span>
                                    <span class="rupiah font-semibold text-gray-900" data-price="{{ $book->price }}"></span>
                                </div>

                                <div class="flex justify-between items-center">
                                    <span>Payment</span>
                                    <span class="font-medium">
                                        @if ($book->qr === 'qr_transfer')
                                            <span class="text-purple-600">
                                                <i class="fa-solid fa-qrcode mr-1"></i> QR Transfer
                                            </span>
                                        @elseif($book->qr === 'cash')
                                            <span class="text-gray-700">
                                                <i class="fa-solid fa-money-bill-wave mr-1"></i> Cash
                                            </span>
                                        @elseif($book->qr === 'no revenue' || $book->qr === null)
                                            <span class="text-red-600">
                                                <i class="fa-solid fa-ban mr-1"></i> No Revenue
                                            </span>
                                        @else
                                            {{ Str::title($book->qr) }}
                                        @endif
                                    </span>
                                </div>
                            </div>

                            <div class="border-t border-dashed border-gray-300 mt-4 mb-3"></div>

                            <div class="flex justify-center space-x-5">
                                <a href="{{ route('customer-books.show', $book) }}"
                                    class="text-green-600 hover:text-green-800 transition transform hover:scale-110"
                                    title="Show">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5s8.268 2.943 9.542 7c-1.274 4.057-5.065 7-9.542 7s-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>

                                @if (auth()->user()->level === 'admin' || $isAntre)
                                    <a href="{{ route('customer-books.createWithCap', $book) }}"
                                        class="text-blue-600 hover:text-blue-800 transition transform hover:scale-110"
                                        title="Proses">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor"
                                            viewBox="0 0 24 24">
                                            <path d="M12 22a10 10 0 100-20 10 10 0 000 20zm-1-6l6-4-6-4v8z" />
                                        </svg>
                                    </a>
                                @endif

                                @if (auth()->user()->level === 'admin' || $isProses)
                                    <a href="{{ route('customer-books.edit', $book) }}"
                                        class="text-yellow-600 hover:text-yellow-800 transition transform hover:scale-110"
                                        title="Edit">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2.121 2.121 0 113 3L12 15l-4 1 1-4
                                                9.586-9.586z" />
                                        </svg>
                                    </a>
                                @endif

                                @if (auth()->user()->level === 'admin' || $isAntre)
                                    <form action="{{ route('customer-books.destroy', $book) }}" method="POST"
                                        onsubmit="return confirm('Are you sure?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="text-red-600 hover:text-red-800 transition transform hover:scale-110"
                                            title="Delete">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center text-gray-500 font-mono">-- No Data Found --</div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-6 flex justify-center">
            {{ $books->appends(request()->query())->links() }}
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.rupiah').forEach(el => {
                const raw = parseFloat(el.dataset.price) || 0;
                el.textContent = new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(raw).replace('Rp', 'Rp ');
            });
        });
    </script>
@endsection