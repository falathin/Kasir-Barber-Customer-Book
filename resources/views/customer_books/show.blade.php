@extends('layouts.app')

@section('title', 'Show Customer Book #' . $customerBook->id . ' – ' . $customerBook->customer)

@section('content')
    <div class="flex justify-center bg-gray-50 min-h-screen py-12 px-4 print:bg-white print:min-h-fit">
        <div
            class="bg-white w-full max-w-sm p-6 rounded-2xl shadow-lg font-mono border border-gray-200 print:shadow-none print:border-none print:rounded-none print:p-0 print:max-w-full print:w-[58mm] print:text-sm print:font-normal">

            {{-- Header --}}
            <div class="text-center mb-6 print:mb-2">
                <h1 class="text-lg font-bold text-gray-800 uppercase print:text-base print:font-semibold print:text-black">
                    Customer Receipt
                </h1>
                <p class="text-xs text-gray-500 print:text-black">
                    {{ $customerBook->created_at->format('d M Y') }}
                </p>
                @if($customerBook->antrian)
                    <p class="text-xs text-gray-600 print:text-black">
                        🪑 Antrian Ke-{{ $customerBook->antrian }}
                    </p>
                @endif
            </div>

            {{-- Detail Items --}}
            <div class="text-xs text-gray-700 space-y-3 print:text-black">
                @php
                    /**
                     * show.blade.php (improved)
                     * - Prioritize DB manual columns:
                     *     hair_coloring_price
                     *     hair_extension_price
                     *     hair_extension_services_price
                     * - Fallback: manual_service_prices JSON (older rows)
                     * - Fallback: priceMap values
                     * - Include manual-only entries even jika colouring_other kosong
                     * - Merge duplicates, show (Nx) when duplicated
                     */

                    // priceMap must match edit.js / picker
                    $priceMap = [
                        "Men Haircut Reguler" => 50000,
                        "Ladies Haircut Reguler" => 60000,
                        "Baby Haircut" => 30000,
                        "Poni" => 25000,
                        "Fading Haircut" => 60000,
                        "Shaving" => 10000,
                        "Hair Tatto" => 35000,
                        "Hair Styling" => 50000,
                        "Men Hair Treatment" => 85000,
                        "Ladies Hair Treatment" => 100000,
                        "Hair Coloring" => 200000,
                        "Hair Toning For Men" => 85000,
                        "Highlight For Men" => 300000,
                        "Hair Smoothing For Men" => 250000,
                        "Hair Smoothing S" => 300000,
                        "Hair Smoothing M" => 350000,
                        "Hair Smoothing L" => 400000,
                        "Hair Smoothing XL" => 450000,
                        "Hair Smoothing XXL" => 500000,
                        "Hair Smoothing XXXL" => 600000,
                        "Hair Smoothing Over" => 700000,
                        "Keratin For Men" => 350000,
                        "Keratin S" => 400000,
                        "Keratin M" => 600000,
                        "Keratin L" => 800000,
                        "Keratin XL" => 950000,
                        "Keratin XXL" => 1000000,
                        "Kids Haircut" => 40000,
                        "Kids Haircut Female" => 65000,
                        "Perming" => 300000,
                        "Downperm" => 150000,
                        "Hair Extension" => 300000,
                        "Hair Extension services" => 350000,
                        "Facial" => 80000,
                        "Eyelash" => 150000,
                        "Eyelash Retouch" => 50000,
                        "Haircut Reguler" => 50000,
                        "Ladies Only Haircut" => 60000,
                    ];

                    // helpers
                    function rupiah($n) {
                        return number_format((int)$n, 0, ',', '.');
                    }
                    function shortForm($n) {
                        $n = (int)$n;
                        if ($n >= 1000000000000) return round($n / 1000000000000, 1) . 'T';
                        if ($n >= 1000000000) return round($n / 1000000000, 1) . 'M';
                        if ($n >= 1000000) return round($n / 1000000, 1) . 'jt';
                        if ($n >= 1000) return round($n / 1000) . 'rb';
                        return (string)$n;
                    }

                    // normalize: lowercase, strip parenthesis content, remove strange chars, collapse spaces
                    function normalize_key($s) {
                        $s = (string)$s;
                        $s = trim($s);
                        $s = preg_replace('/\s*\(.*?\)\s*/', ' ', $s); // remove (...) content
                        $s = preg_replace('/[^\p{L}\p{N}\s\-\/]+/u', '', $s); // keep letters/numbers/spaces/dash/slash
                        $s = preg_replace('/\s+/', ' ', $s);
                        return mb_strtolower(trim($s));
                    }

                    // Build normalized priceMap for tolerant lookup
                    $priceMapNormalized = [];
                    foreach ($priceMap as $k => $v) {
                        $priceMapNormalized[ normalize_key($k) ] = (int)$v;
                    }

                    // Build manual prices preferring DB columns (new approach)
                    $manualPricesNormalized = [];
                    $manualOriginalNames = []; // norm => original display name (from DB keys or JSON keys)

                    // DB column names: hair_coloring_price, hair_extension_price, hair_extension_services_price
                    if (!is_null($customerBook->hair_coloring_price) && $customerBook->hair_coloring_price !== '') {
                        $nk = normalize_key('Hair Coloring');
                        $manualPricesNormalized[$nk] = (int)$customerBook->hair_coloring_price;
                        $manualOriginalNames[$nk] = 'Hair Coloring';
                    }
                    if (!is_null($customerBook->hair_extension_price) && $customerBook->hair_extension_price !== '') {
                        $nk = normalize_key('Hair Extension');
                        $manualPricesNormalized[$nk] = (int)$customerBook->hair_extension_price;
                        $manualOriginalNames[$nk] = 'Hair Extension';
                    }
                    if (!is_null($customerBook->hair_extension_services_price) && $customerBook->hair_extension_services_price !== '') {
                        $nk = normalize_key('Hair Extension services');
                        $manualPricesNormalized[$nk] = (int)$customerBook->hair_extension_services_price;
                        $manualOriginalNames[$nk] = 'Hair Extension services';
                    }

                    // If DB columns empty, fallback to manual_service_prices JSON (older data)
                    if (empty($manualPricesNormalized) && !empty($customerBook->manual_service_prices)) {
                        $decoded = json_decode($customerBook->manual_service_prices, true);
                        if (is_array($decoded)) {
                            foreach ($decoded as $k => $v) {
                                $nk = normalize_key($k);
                                // accept strings with dots/commas -> strip non-digits
                                $numOnly = preg_replace('/[^\d]/', '', (string)$v);
                                $manualPricesNormalized[$nk] = $numOnly === '' ? 0 : (int)$numOnly;
                                $manualOriginalNames[$nk] = (string)$k;
                            }
                        }
                    }

                    // Parse colouring_other preserving order
                    $servicesRaw = [];
                    $servicesRawNorms = [];
                    if (!empty($customerBook->colouring_other)) {
                        $parts = preg_split('/\s*,\s*/', trim($customerBook->colouring_other));
                        foreach ($parts as $p) {
                            $p = trim((string)$p);
                            if ($p === '') continue;
                            $servicesRaw[] = $p;
                            $servicesRawNorms[] = normalize_key($p);
                        }
                    }

                    // Ensure manual-only entries are included in servicesRaw (if not present)
                    foreach ($manualPricesNormalized as $norm => $val) {
                        if (!in_array($norm, $servicesRawNorms, true)) {
                            // pick original name if available, otherwise fallback to priceMap label or norm
                            $label = $manualOriginalNames[$norm] ?? (array_search($val, $priceMap, true) ?: $norm);
                            $servicesRaw[] = $label;
                            $servicesRawNorms[] = $norm;
                        }
                    }

                    // Resolve each raw entry to price: prefer manualPricesNormalized -> priceMapNormalized -> direct priceMap match -> 0
                    $resolved = [];
                    foreach ($servicesRaw as $orig) {
                        $norm = normalize_key($orig);

                        if (isset($manualPricesNormalized[$norm])) {
                            $price = $manualPricesNormalized[$norm];
                        } elseif (isset($priceMapNormalized[$norm])) {
                            $price = $priceMapNormalized[$norm];
                        } else {
                            // try case-insensitive original key match in priceMap
                            $found = 0;
                            foreach ($priceMap as $kpm => $vpm) {
                                if (mb_strtolower(trim($kpm)) === mb_strtolower(trim($orig))) {
                                    $found = (int)$vpm;
                                    break;
                                }
                            }
                            $price = $found;
                        }

                        $resolved[] = [
                            'original' => $orig,
                            'norm' => $norm,
                            'price' => (int)$price,
                        ];
                    }

                    // Merge duplicates by normalized key (sum price, count occurrences, preserve first original name)
                    $merged = [];
                    $order = [];
                    foreach ($resolved as $r) {
                        $k = $r['norm'];
                        if (!isset($merged[$k])) {
                            $merged[$k] = [
                                'name' => $r['original'],
                                'norm' => $k,
                                'price' => $r['price'],
                                'count' => 1
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

                    // Build breakdownParts and breakdownTotal from mergedList
                    $breakdownParts = [];
                    $breakdownTotal = 0;
                    foreach ($mergedList as $m) {
                        $label = $m['name'];
                        if ($m['count'] > 1) $label .= ' (' . $m['count'] . 'x)';
                        if ($m['price'] > 0) {
                            $breakdownParts[] = 'Rp ' . rupiah($m['price']) . ' · ' . $label;
                        } else {
                            $breakdownParts[] = $label;
                        }
                        $breakdownTotal += (int)$m['price'];
                    }

                    // top metadata
                    $asistenNama = null;
                    if ($customerBook->asisten) {
                        $capsters = \App\Models\Capster::all()->keyBy('inisial');
                        $asistenNama = $capsters[$customerBook->asisten]->nama ?? $customerBook->asisten;
                    }

                    $items = [
                        'Booking ID' => $customerBook->id,
                        'Customer'   => $customerBook->customer,
                        'Capster'    => $customerBook->capster?->nama ?? $customerBook->cap,
                        'Asisten'    => $asistenNama ?? '-',
                        'Style'      => $customerBook->haircut_type,
                        'Shop'       => $customerBook->barber_name,
                    ];
                @endphp

                {{-- metadata --}}
                @foreach ($items as $k => $v)
                    <div class="flex justify-between border-b border-dashed pb-1 print:border-b print:border-black">
                        <span class="uppercase">{{ $k }}</span>
                        <span class="font-semibold text-right max-w-[100px] break-words">{{ $v }}</span>
                    </div>
                @endforeach

                {{-- Services --}}
                <div class="border-b border-dashed pb-1 print:border-b print:border-black">
                    <div class="flex items-center justify-between">
                        <span class="uppercase">Services</span>
                        <span class="text-xs text-gray-500">{{ count($mergedList) ?: '-' }}</span>
                    </div>

                    <ul class="mt-1 pl-4 list-disc list-inside print:pl-2 print:list-none print:mt-0">
                        @if (!empty($mergedList))
                            @foreach ($mergedList as $svc)
                                <li class="break-words flex justify-between items-center">
                                    <span class="truncate">
                                        {{ $svc['name'] }}
                                        @if($svc['count'] > 1)
                                            <small class="text-gray-500">({{ $svc['count'] }}x)</small>
                                        @endif
                                    </span>
                                    <span class="ml-2 text-right">
                                        <span class="text-xs font-medium text-indigo-700">Rp {{ rupiah($svc['price']) }}</span>
                                        <span class="text-xs text-indigo-600 ml-1">({{ shortForm($svc['price']) }})</span>
                                    </span>
                                </li>
                            @endforeach
                        @else
                            <li>-</li>
                        @endif
                    </ul>

                    {{-- Breakdown --}}
                    @if (!empty($mergedList))
                        <p class="mt-2 text-xs text-gray-600">
                            <span class="font-semibold">Keterangan:</span>
                            <span class="ml-1">
                                {!! implode(' + ', array_map('e', $breakdownParts)) !!}
                                <span class="font-semibold"> = Rp {{ rupiah($breakdownTotal) }}</span>
                            </span>
                        </p>
                    @endif
                </div>

                {{-- Products --}}
                <div class="border-b border-dashed pb-1 print:border-b print:border-black">
                    <span class="uppercase">Products</span>
                    <ul class="mt-1 pl-4 list-disc list-inside print:pl-2 print:list-none print:mt-0">
                        @if ($customerBook->sell_use_product)
                            @foreach (explode(',', $customerBook->sell_use_product) as $p)
                                <li class="break-words">{{ trim($p) }}</li>
                            @endforeach
                        @else
                            <li>-</li>
                        @endif
                    </ul>
                </div>

                {{-- Rincian --}}
                <div class="border-b border-dashed pb-1 print:hidden">
                    <span class="uppercase">Rincian</span>
                    <p class="mt-1 break-words whitespace-pre-line">
                        {{ $customerBook->rincian ?? '-' }}
                    </p>
                </div>

                @php
                    $isPending = ($customerBook->price == 0 || is_null($customerBook->price)) && empty($customerBook->colouring_other) && $breakdownTotal == 0;
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

                {{-- Total & Payment --}}
                <div class="flex justify-between pt-2 font-bold print:pt-1 print:font-semibold">
                    <span class="uppercase text-sm">Total</span>
                    <span class="text-sm">Rp {{ number_format((int)$customerBook->price, 0, ',', '.') }}</span>
                </div>

                {{-- mismatch note --}}
                @if (!empty($mergedList) && $breakdownTotal != (int)$customerBook->price)
                    <div class="text-xs text-red-600">
                        <small>Catatan: jumlah dari keterangan layanan (Rp {{ rupiah($breakdownTotal) }}) berbeda dengan total yang tersimpan (Rp {{ rupiah($customerBook->price) }}).</small>
                    </div>
                @endif

                <div class="flex justify-between text-xs text-gray-600 print:text-black">
                    <span>Payment</span>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                      @if($customerBook->qr === 'qr_transfer')
                        bg-purple-100 text-purple-800
                      @elseif($customerBook->qr === 'cash')
                        bg-gray-100 text-gray-800
                      @elseif($customerBook->qr === 'no revenue' || $customerBook->qr === null || $customerBook->qr === '')
                        bg-red-100 text-red-800
                      @else
                        bg-blue-100 text-blue-800
                      @endif
                    ">
                      @php use Illuminate\Support\Str; @endphp

                      @if($customerBook->qr === 'qr_transfer')
                        QR Transfer
                      @elseif($customerBook->qr === 'cash')
                        Cash
                      @elseif($customerBook->qr === 'no revenue' || $customerBook->qr === null || $customerBook->qr === '')
                        No Revenue
                      @else
                        {{ Str::title($customerBook->qr) }}
                      @endif
                    </span>
                </div>
                <div class="flex justify-between text-xs text-gray-600 print:text-black">
                    <span>Time</span>
                    <span>
                        {{ \Carbon\Carbon::parse($customerBook->created_time)->translatedFormat('d F Y - H:i') }}
                    </span>
                </div>
            </div>

            @php
                $isPending = ($customerBook->price == 0 || is_null($customerBook->price)) && empty($customerBook->colouring_other) && $breakdownTotal == 0;
                $isAntre   = empty($customerBook->cap);
            @endphp

            <div class="mt-6 grid grid-cols-2 gap-2 print:hidden">
                <a href="{{ route('customer-books.index') }}"
                    class="w-full block text-center py-2 bg-gray-200 rounded text-xs hover:bg-gray-300">
                    Back
                </a>

                <button onclick="window.print()"
                    class="w-full block text-center py-2 bg-green-600 text-white rounded text-xs hover:bg-green-700">
                    Print
                </button>

                @if($isAntre)
                    <a href="{{ route('customer-books.createWithCap', $customerBook) }}"
                        class="w-full block text-center py-2 bg-blue-500 text-white rounded text-xs hover:bg-blue-600">
                        Proseskan
                    </a>
                    <form action="{{ route('customer-books.destroy', $customerBook) }}"
                        method="POST"
                        class="w-full"
                        onsubmit="return confirm('Delete this receipt?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full block py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                            Delete
                        </button>
                    </form>
                @else
                    @if(auth()->user()->level === 'admin')
                        <a href="{{ route('customer-books.edit', $customerBook) }}"
                            class="w-full block text-center py-2 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">
                            Done
                        </a>

                        <form action="{{ route('customer-books.destroy', $customerBook) }}"
                            method="POST"
                            class="w-full"
                            onsubmit="return confirm('Delete this receipt?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="w-full block py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    @elseif(auth()->user()->level === 'kasir')
                        @if($isPending)
                            <a href="{{ route('customer-books.edit', $customerBook) }} "
                                class="w-full block text-center py-2 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">
                                Done
                            </a>

                            <form action="{{ route('customer-books.destroy', $customerBook) }} "
                                method="POST"
                                class="w-full"
                                onsubmit="return confirm('Delete this receipt?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full block py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">
                                    Delete
                                </button>
                            </form>
                        @else
                            <button disabled
                                class="w-full block text-center py-2 bg-gray-300 text-gray-500 rounded text-xs cursor-not-allowed">
                                Done
                            </button>
                            <button disabled
                                class="w-full block py-2 bg-gray-300 text-gray-500 rounded text-xs cursor-not-allowed">
                                Delete
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
