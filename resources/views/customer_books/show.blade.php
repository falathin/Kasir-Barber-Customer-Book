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
                @foreach ($items as $k => $v)
                    <div class="flex justify-between border-b border-dashed pb-1 print:border-b print:border-black">
                        <span class="uppercase">{{ $k }}</span>
                        <span class="font-semibold text-right max-w-[100px] break-words">{{ $v }}</span>
                    </div>
                @endforeach

                {{-- Services --}}
                <div class="border-b border-dashed pb-1 print:border-b print:border-black">
                    <span class="uppercase">Services</span>
                    <ul class="mt-1 pl-4 list-disc list-inside print:pl-2 print:list-none print:mt-0">
                        @if ($customerBook->colouring_other)
                            @foreach (explode(', ', $customerBook->colouring_other) as $s)
                                <li class="break-words">{{ $s }}</li>
                            @endforeach
                        @else
                            <li>-</li>
                        @endif
                    </ul>
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

                {{-- Rincian (Rahasia: disembunyikan saat print) --}}
                <div class="border-b border-dashed pb-1 print:hidden">
                    <span class="uppercase">Rincian</span>
                    <p class="mt-1 break-words whitespace-pre-line">
                        {{ $customerBook->rincian ?? '-' }}
                    </p>
                </div>

                @php
                    $isPending = $customerBook->price == 0 && is_null($customerBook->colouring_other);
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
                    <span class="text-sm">Rp {{ number_format($customerBook->price, 0, ',', '.') }}</span>
                </div>
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
                $isPending = $customerBook->price == 0 && empty($customerBook->colouring_other);
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