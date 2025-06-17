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
        </div>

        {{-- Detail Items --}}
        <div class="text-xs text-gray-700 space-y-3 print:text-black">
            @php
                $items = [
                    'Booking ID'    => $customerBook->id,
                    'Customer'      => $customerBook->customer,
                    'Capster'       => $customerBook->capster?->nama ?? $customerBook->cap,
                    'Style'         => $customerBook->haircut_type,
                    'Shop'          => $customerBook->barber_name,
                ];
            @endphp
            @foreach($items as $k => $v)
                <div class="flex justify-between border-b border-dashed pb-1 print:border-b print:border-black">
                    <span class="uppercase">{{ $k }}</span>
                    <span class="font-semibold text-right max-w-[100px] break-words">{{ $v }}</span>
                </div>
            @endforeach

            {{-- Services --}}
            <div class="border-b border-dashed pb-1 print:border-b print:border-black">
                <span class="uppercase">Services</span>
                <ul class="mt-1 pl-4 list-disc list-inside print:pl-2 print:list-none print:mt-0">
                    @if($customerBook->colouring_other)
                        @foreach(explode(', ', $customerBook->colouring_other) as $s)
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
                    @if($customerBook->sell_use_product)
                        @foreach(explode(',', $customerBook->sell_use_product) as $p)
                            <li class="break-words">{{ trim($p) }}</li>
                        @endforeach
                    @else
                        <li>-</li>
                    @endif
                </ul>
            </div>

            {{-- Total & Payment --}}
            <div class="flex justify-between pt-2 font-bold print:pt-1 print:font-semibold">
                <span class="uppercase text-sm">Total</span>
                <span class="text-sm">Rp {{ number_format($customerBook->price,0,',','.') }}</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600 print:text-black">
                <span>Payment</span>
                <span>{{ $customerBook->qr === 'qr_transfer' ? 'QR Transfer' : 'Cash' }}</span>
            </div>
            <div class="flex justify-between text-xs text-gray-600 print:text-black">
                <span>Time</span>
                <span>{{ $customerBook->created_at->format('H:i') }}</span>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="mt-6 grid grid-cols-2 gap-2 print:hidden">
            <a href="{{ route('customer-books.index') }}"
                class="block text-center py-2 bg-gray-200 rounded text-xs hover:bg-gray-300">Back</a>
            <button onclick="window.print()"
                class="block text-center py-2 bg-green-600 text-white rounded text-xs hover:bg-green-700">Print</button>
            <a href="{{ route('customer-books.edit', $customerBook->id) }}"
                class="block text-center py-2 bg-indigo-600 text-white rounded text-xs hover:bg-indigo-700">Edit</a>
            <form action="{{ route('customer-books.destroy', $customerBook->id) }}" method="POST"
                onsubmit="return confirm('Delete this receipt?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                    class="w-full py-2 bg-red-600 text-white rounded text-xs hover:bg-red-700">Delete</button>
            </form>
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

        .print\:hidden {
            display: none !important;
        }

        .print\:text-black {
            color: black !important;
        }

        .print\:border-black {
            border-color: black !important;
        }

        .print\:rounded-none {
            border-radius: 0 !important;
        }

        .print\:shadow-none {
            box-shadow: none !important;
        }

        .print\:p-0 {
            padding: 0 !important;
        }

        .print\:max-w-full {
            max-width: 100% !important;
        }

        .print\:w-\[58mm\] {
            width: 58mm !important;
        }

        .print\:font-normal {
            font-weight: normal !important;
        }

        .print\:text-sm {
            font-size: 11px !important;
        }
    }
</style>
@endsection