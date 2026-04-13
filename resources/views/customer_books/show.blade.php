@extends('layouts.app')

@section('title', 'Lihat Customer Book #' . $customerBook->id . ' – ' . $customerBook->customer)

@section('content')
    <div class="flex justify-center bg-gray-50 min-h-screen py-12 px-4 print:bg-white print:min-h-fit">
        <div
            class="bg-white w-full max-w-sm p-6 rounded-2xl shadow-lg font-mono border border-gray-200 print:shadow-none print:border-none print:rounded-none print:p-0 print:max-w-full print:w-[58mm] print:text-sm print:font-normal">

            <div class="text-center mb-6 print:mb-2">
                <h1 class="text-lg font-bold text-gray-800 uppercase print:text-base print:font-semibold print:text-black">
                    Struk Pelanggan
                </h1>
                <p class="text-xs text-gray-500 print:text-black">
                    {{ $customerBook->created_at->format('d M Y') }}
                </p>
                @if ($customerBook->antrian)
                    <p class="text-xs text-gray-600 print:text-black">
                        <i class="fa-solid fa-chair mr-1"></i>
                        Nomor Antrian {{ $customerBook->antrian }}
                    </p>
                @endif
            </div>

            <div class="text-xs text-gray-700 space-y-3 print:text-black">
                @php
                    use Illuminate\Support\Str;

                    $priceMap = [
                        'Men Haircut Reguler' => 50000,
                        'Long Haircut For Men' => 60000,
                        'Ladies Haircut Reguler' => 75000,
                        'Baby Haircut' => 30000,
                        'Poni' => 25000,

                        'Keratin For Men' => 350000,
                        'Keratin S' => 400000,
                        'Keratin M' => 600000,
                        'Keratin L' => 800000,
                        'Keratin XL' => 950000,
                        'Keratin XXL' => 1000000,

                        'Kids Haircut' => 40000,
                        'Kids Haircut Female' => 65000,

                        'Shaving' => 10000,
                        'Shaving Razor' => 20000,
                        'Balding' => 60000,
                        'Hairtonic Massage' => 10000,
                        'Hair Tatto' => 35000,
                        'Hair Styling' => 50000,

                        'Men Hair Treatment' => 85000,
                        'Ladies Hair Treatment' => 100000,

                        'Hair Toning For Men' => 85000,
                        'Highlight For Men' => 300000,

                        'Hair Smoothing For Men' => 250000,
                        'Hair Smoothing S' => 300000,
                        'Hair Smoothing M' => 350000,
                        'Hair Smoothing L' => 400000,
                        'Hair Smoothing XL' => 450000,
                        'Hair Smoothing XXL' => 500000,
                        'Hair Smoothing XXXL' => 600000,
                        'Hair Smoothing Over' => 700000,

                        'Perming' => 300000,
                        'Downperm' => 150000,
                        'Downperm Up And Side' => 250000,
                        'Facial' => 80000,
                        'Eyelash' => 150000,
                        'Eyelash Retouch' => 50000,

                        'Pomade' => 85000,
                        'Clay' => 85000,
                        'Hair Powder' => 25000,
                    ];

                    $productNames = ['Pomade', 'Clay', 'Hair Powder'];

                    $rupiah = function ($n) {
                        return number_format((int) $n, 0, ',', '.');
                    };

                    $singkatAngka = function ($n) {
                        $n = (int) $n;
                        if ($n >= 1000000000000) {
                            return round($n / 1000000000000, 1) . 'T';
                        }
                        if ($n >= 1000000000) {
                            return round($n / 1000000000, 1) . 'M';
                        }
                        if ($n >= 1000000) {
                            return round($n / 1000000, 1) . 'jt';
                        }
                        if ($n >= 1000) {
                            return round($n / 1000) . 'rb';
                        }
                        return (string) $n;
                    };

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

                            return array_values(
                                array_filter(array_map('trim', preg_split('/\s*,\s*/', $value)), fn($v) => $v !== ''),
                            );
                        }

                        return [];
                    };

                    $priceMapNormalized = [];
                    foreach ($priceMap as $k => $v) {
                        $priceMapNormalized[$normalizeKey($k)] = (int) $v;
                    }

                    $productNamesNormalized = [];
                    foreach ($productNames as $pname) {
                        $productNamesNormalized[] = $normalizeKey($pname);
                    }

                    $manualPricesNormalized = [];
                    $manualOriginalNames = [];

                    if (!is_null($customerBook->hair_coloring_price) && $customerBook->hair_coloring_price !== '') {
                        $nk = $normalizeKey('Hair Coloring');
                        $manualPricesNormalized[$nk] = (int) $customerBook->hair_coloring_price;
                        $manualOriginalNames[$nk] = 'Hair Coloring';
                    }

                    if (!is_null($customerBook->hair_extension_price) && $customerBook->hair_extension_price !== '') {
                        $nk = $normalizeKey('Hair Extension');
                        $manualPricesNormalized[$nk] = (int) $customerBook->hair_extension_price;
                        $manualOriginalNames[$nk] = 'Hair Extension';
                    }

                    if (
                        !is_null($customerBook->hair_extension_services_price) &&
                        $customerBook->hair_extension_services_price !== ''
                    ) {
                        $nk = $normalizeKey('Hair Extension Services');
                        $manualPricesNormalized[$nk] = (int) $customerBook->hair_extension_services_price;
                        $manualOriginalNames[$nk] = 'Hair Extension Services';
                    }

                    $servicesRaw = [];
                    if (!empty($customerBook->services)) {
                        $servicesRaw = $toArrayList($customerBook->services);
                    } elseif (!empty($customerBook->colouring_other)) {
                        $servicesRaw = $toArrayList($customerBook->colouring_other);
                    }

                    $productsRaw = [];
                    if (!empty($customerBook->products)) {
                        $productsRaw = $toArrayList($customerBook->products);
                    } elseif (!empty($customerBook->sell_use_product)) {
                        $productsRaw = $toArrayList($customerBook->sell_use_product);
                    }

                    $fixedServicesRaw = [];
                    foreach ($servicesRaw as $item) {
                        $norm = $normalizeKey($item);
                        if (in_array($norm, $productNamesNormalized, true)) {
                            $productsRaw[] = $item;
                        } else {
                            $fixedServicesRaw[] = $item;
                        }
                    }
                    $servicesRaw = $fixedServicesRaw;

                    foreach ($manualPricesNormalized as $norm => $val) {
                        $exists = false;
                        foreach ($servicesRaw as $srv) {
                            if ($normalizeKey($srv) === $norm) {
                                $exists = true;
                                break;
                            }
                        }
                        if (!$exists) {
                            $servicesRaw[] = $manualOriginalNames[$norm] ?? $norm;
                        }
                    }

                    $resolveItems = function (array $rawItems, array $manualMap = []) use (
                        $normalizeKey,
                        $priceMapNormalized,
                        $priceMap,
                    ) {
                        $resolved = [];

                        foreach ($rawItems as $orig) {
                            $norm = $normalizeKey($orig);

                            if (isset($manualMap[$norm])) {
                                $price = $manualMap[$norm];
                            } elseif (isset($priceMapNormalized[$norm])) {
                                $price = $priceMapNormalized[$norm];
                            } else {
                                $found = 0;
                                foreach ($priceMap as $kpm => $vpm) {
                                    if (mb_strtolower(trim($kpm)) === mb_strtolower(trim($orig))) {
                                        $found = (int) $vpm;
                                        break;
                                    }
                                }
                                $price = $found;
                            }

                            $resolved[] = [
                                'original' => $orig,
                                'norm' => $norm,
                                'price' => (int) $price,
                            ];
                        }

                        $merged = [];
                        $order = [];
                        foreach ($resolved as $r) {
                            $k = $r['norm'];
                            if (!isset($merged[$k])) {
                                $merged[$k] = [
                                    'name' => $r['original'],
                                    'norm' => $k,
                                    'price' => $r['price'],
                                    'count' => 1,
                                ];
                                $order[] = $k;
                            } else {
                                $merged[$k]['price'] += $r['price'];
                                $merged[$k]['count'] += 1;
                            }
                        }

                        $mergedList = [];
                        foreach ($order as $k) {
                            $mergedList[] = $merged[$k];
                        }

                        $breakdownParts = [];
                        $breakdownTotal = 0;
                        foreach ($mergedList as $m) {
                            $label = $m['name'];
                            if ($m['count'] > 1) {
                                $label .= ' (' . $m['count'] . 'x)';
                            }
                            if ($m['price'] > 0) {
                                $breakdownParts[] = 'Rp ' . number_format($m['price'], 0, ',', '.') . ' · ' . $label;
                            } else {
                                $breakdownParts[] = $label;
                            }
                            $breakdownTotal += (int) $m['price'];
                        }

                        return [$mergedList, $breakdownParts, $breakdownTotal];
                    };

                    [$serviceList, $serviceBreakdownParts, $serviceTotal] = $resolveItems(
                        $servicesRaw,
                        $manualPricesNormalized,
                    );
                    [$productList, $productBreakdownParts, $productTotal] = $resolveItems($productsRaw, []);
                    $grandTotal = $serviceTotal + $productTotal;

                    $asistenNama = null;
                    if ($customerBook->asisten) {
                        $capsters = \App\Models\Capster::all()->keyBy('inisial');
                        $asistenNama = $capsters[$customerBook->asisten]->nama ?? $customerBook->asisten;
                    }

                    $items = [
                        'ID Booking' => $customerBook->id,
                        'Pelanggan' => $customerBook->customer,
                        'Capster' => $customerBook->capster?->nama ?? $customerBook->cap,
                        'Asisten' => $asistenNama ?? '-',
                        'Gaya' => $customerBook->haircut_type,
                        'Nama Barber' => $customerBook->barber_name,
                    ];
                @endphp

                @foreach ($items as $k => $v)
                    <div class="flex justify-between border-b border-dashed pb-1 print:border-b print:border-black">
                        <span class="uppercase">{{ $k }}</span>
                        <span class="font-semibold text-right max-w-[100px] break-words">{{ $v }}</span>
                    </div>
                @endforeach

                <div class="border-b border-dashed pb-1 print:border-b print:border-black">
                    <div class="flex items-center justify-between">
                        <span class="uppercase">Layanan</span>
                        <span class="text-xs text-gray-500">{{ count($serviceList) ?: '-' }}</span>
                    </div>

                    <ul class="mt-1 pl-4 list-disc list-inside print:pl-2 print:list-none print:mt-0">
                        @if (!empty($serviceList))
                            @foreach ($serviceList as $svc)
                                <li class="break-words flex justify-between items-center">
                                    <span class="truncate">
                                        {{ $svc['name'] }}
                                        @if ($svc['count'] > 1)
                                            <small class="text-gray-500">({{ $svc['count'] }}x)</small>
                                        @endif
                                    </span>
                                    <span class="ml-2 text-right">
                                        <span class="text-xs font-medium text-indigo-700">Rp
                                            {{ $rupiah($svc['price']) }}</span>
                                        <span
                                            class="text-xs text-indigo-600 ml-1">({{ $singkatAngka($svc['price']) }})</span>
                                    </span>
                                </li>
                            @endforeach
                        @else
                            <li>-</li>
                        @endif
                    </ul>

                    @if (!empty($serviceList))
                        <p class="mt-2 text-xs text-gray-600">
                            <span class="font-semibold">Rincian:</span>
                            <span class="ml-1">
                                {!! implode(' + ', array_map('e', $serviceBreakdownParts)) !!}
                                <span class="font-semibold"> = Rp {{ $rupiah($serviceTotal) }}</span>
                            </span>
                        </p>
                    @endif
                </div>

                <div class="border-b border-dashed pb-1 print:border-b print:border-black">
                    <div class="flex items-center justify-between">
                        <span class="uppercase">Produk</span>
                        <span class="text-xs text-gray-500">{{ count($productList) ?: '-' }}</span>
                    </div>

                    <ul class="mt-1 pl-4 list-disc list-inside print:pl-2 print:list-none print:mt-0">
                        @if (!empty($productList))
                            @foreach ($productList as $prd)
                                <li class="break-words flex justify-between items-center">
                                    <span class="truncate">
                                        {{ $prd['name'] }}
                                        @if ($prd['count'] > 1)
                                            <small class="text-gray-500">({{ $prd['count'] }}x)</small>
                                        @endif
                                    </span>
                                    <span class="ml-2 text-right">
                                        <span class="text-xs font-medium text-emerald-700">Rp
                                            {{ $rupiah($prd['price']) }}</span>
                                        <span
                                            class="text-xs text-emerald-600 ml-1">({{ $singkatAngka($prd['price']) }})</span>
                                    </span>
                                </li>
                            @endforeach
                        @else
                            <li>-</li>
                        @endif
                    </ul>

                    @if (!empty($productList))
                        <p class="mt-2 text-xs text-gray-600">
                            <span class="font-semibold">Rincian:</span>
                            <span class="ml-1">
                                {!! implode(' + ', array_map('e', $productBreakdownParts)) !!}
                                <span class="font-semibold"> = Rp {{ $rupiah($productTotal) }}</span>
                            </span>
                        </p>
                    @endif
                </div>

                <div class="border-b border-dashed pb-1 print:hidden">
                    <span class="uppercase">Catatan</span>
                    <p class="mt-1 break-words whitespace-pre-line">
                        {{ $customerBook->rincian ?? '-' }}
                    </p>
                </div>

                @php
                    $isPending = ($customerBook->price == 0 || is_null($customerBook->price)) && $grandTotal == 0;

                    if (is_null($customerBook->cap)) {
                        $status = 'Antri';
                        $statusColor = 'bg-gray-100 text-gray-600';
                    } elseif ($isPending) {
                        $status = 'Proses';
                        $statusColor = 'bg-yellow-100 text-yellow-700';
                    } else {
                        $status = 'Selesai';
                        $statusColor = 'bg-green-100 text-green-700';
                    }
                @endphp

                <div class="flex justify-between text-xs font-bold {{ $statusColor }} rounded-md px-3 py-1">
                    <span>Status</span>
                    <span>{{ $status }}</span>
                </div>

                <div class="flex justify-between pt-2 font-bold print:pt-1 print:font-semibold">
                    <span class="uppercase text-sm">Total</span>
                    <span class="text-sm">Rp {{ number_format((int) $customerBook->price, 0, ',', '.') }}</span>
                </div>

                @if ($serviceTotal + $productTotal != (int) $customerBook->price && $serviceTotal + $productTotal > 0)
                    <div class="text-xs text-red-600">
                        <small>
                            Catatan: jumlah rincian (Rp {{ $rupiah($grandTotal) }}) berbeda dengan total tersimpan
                            (Rp {{ $rupiah($customerBook->price) }}).
                        </small>
                    </div>
                @endif

                <div class="flex justify-between text-xs text-gray-600 print:text-black">
                    <span>Pembayaran</span>
                    <span
                        class="px-3 py-1 text-xs font-semibold rounded-full
                      @if ($customerBook->qr === 'qr_transfer') bg-purple-100 text-purple-800
                      @elseif($customerBook->qr === 'cash')
                        bg-gray-100 text-gray-800
                      @elseif($customerBook->qr === 'no revenue' || $customerBook->qr === null || $customerBook->qr === '')
                        bg-red-100 text-red-800
                      @else
                        bg-blue-100 text-blue-800 @endif
                    ">
                        @if ($customerBook->qr === 'qr_transfer')
                            <i class="fa-solid fa-qrcode mr-1"></i> Transfer QR
                        @elseif($customerBook->qr === 'cash')
                            <i class="fa-solid fa-money-bill-wave mr-1"></i> Tunai
                        @elseif($customerBook->qr === 'no revenue' || $customerBook->qr === null || $customerBook->qr === '')
                            <i class="fa-solid fa-ban mr-1"></i> Tanpa Pendapatan
                        @else
                            {{ Str::title($customerBook->qr) }}
                        @endif
                    </span>
                </div>

                <div class="flex justify-between text-xs text-gray-600 print:text-black">
                    <span>Waktu</span>
                    <span>
                        {{ \Carbon\Carbon::parse($customerBook->created_time)->translatedFormat('d F Y - H:i') }}
                    </span>
                </div>
            </div>

            @php
                $isPending = ($customerBook->price == 0 || is_null($customerBook->price)) && $grandTotal == 0;
                $isAntre = empty($customerBook->cap);
            @endphp

            <div class="mt-6 grid grid-cols-2 gap-2 print:hidden">
                <a href="{{ route('customer-books.index') }}"
                    class="w-full block text-center py-2 bg-gray-200 rounded text-xs hover:bg-gray-300">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Kembali
                </a>

                <button onclick="window.print()"
                    class="w-full block text-center py-2 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                    <i class="fa-solid fa-print mr-1"></i> Cetak
                </button>

                @if ($isAntre)
                    <a href="{{ route('customer-books.createWithCap', $customerBook) }}"
                        class="w-full block text-center py-2 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
                        <i class="fa-solid fa-play mr-1"></i> Proseskan
                    </a>
                    <form action="{{ route('customer-books.destroy', $customerBook) }}" method="POST" class="w-full"
                        onsubmit="return confirm('Hapus struk ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full block py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                            <i class="fa-solid fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                @else
                    @if (auth()->user()->level === 'admin')
                        <a href="{{ route('customer-books.edit', $customerBook) }}"
                            class="w-full block text-center py-2 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">
                            <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                        </a>

                        <form action="{{ route('customer-books.destroy', $customerBook) }}" method="POST" class="w-full"
                            onsubmit="return confirm('Hapus struk ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full block py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                            </button>
                        </form>
                    @elseif(auth()->user()->level === 'kasir')
                        @if ($isPending)
                            <a href="{{ route('customer-books.edit', $customerBook) }}"
                                class="w-full block text-center py-2 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">
                                <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                            </a>

                            <form action="{{ route('customer-books.destroy', $customerBook) }}" method="POST"
                                class="w-full" onsubmit="return confirm('Hapus struk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full block py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                    <i class="fa-solid fa-trash mr-1"></i> Hapus
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="w-full block text-center py-2 bg-gray-300 text-gray-500 rounded text-xs cursor-not-allowed">
                                <i class="fa-solid fa-circle-check mr-1"></i> Selesai
                            </button>
                            <button disabled
                                class="w-full block py-2 bg-gray-300 text-gray-500 rounded text-xs cursor-not-allowed">
                                <i class="fa-solid fa-trash mr-1"></i> Hapus
                            </button>
                        @endif
                    @endif
                @endif
            </div>
        </div>
    </div>

    <style>
        @media print {
            body {
                background: white !important;
                font-size: 11px;
                margin: 0;
                padding: 0;
            }

            * {
                color: black !important;
                box-shadow: none !important;
                background: transparent !important;
            }

            .print\\:hidden {
                display: none !important;
            }

            .print\\:text-black {
                color: black !important;
            }

            .print\\:border-black {
                border-color: black !important;
            }

            .print\\:rounded-none {
                border-radius: 0 !important;
            }

            .print\\:shadow-none {
                box-shadow: none !important;
            }

            .print\\:p-0 {
                padding: 0 !important;
            }

            .print\\:max-w-full {
                max-width: 100% !important;
            }

            .print\\:w-\[58mm\] {
                width: 58mm !important;
            }

            .print\\:font-normal {
                font-weight: normal !important;
            }

            .print\\:text-sm {
                font-size: 11px !important;
            }
        }
    </style>
@endsection