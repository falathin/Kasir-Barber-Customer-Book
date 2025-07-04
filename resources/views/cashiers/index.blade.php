
<!-- resources/views/kasirs/index.blade.php -->
@extends('layouts.app')

@section('title', 'Cashier Management')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h2 class="text-3xl font-bold text-gray-800">👥 Cashier Accounts</h2>
        <a href="{{ route('kasirs.create') }}"
            class="px-5 py-2 bg-yellow-400 text-white font-semibold rounded-full shadow hover:bg-yellow-500 transition animate__animated animate__fadeInUp">+ Add Cashier</a>
    </div>

    <div class="overflow-x-auto bg-white rounded-2xl shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-yellow-50">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">👤 Name</th>
                    <th class="px-6 py-3 text-left text-sm font-medium text-gray-600 uppercase tracking-wider">📧 Email</th>
                    <th class="px-6 py-3 text-center text-sm font-medium text-gray-600 uppercase tracking-wider">⏱️ Last Login</th>
                    <th class="px-6 py-3 text-right text-sm font-medium text-gray-600 uppercase tracking-wider">⚙️ Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($cashiers as $kasir)
                <tr class="hover:bg-yellow-50 transition">
                    <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-800">{{ $kasir->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $kasir->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        @if ($kasir->last_login_at)
                        <span
                            class="inline-block px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">{{ \Carbon\Carbon::parse($kasir->last_login_at)->translatedFormat('d M Y H:i') }}</span>
                        @else
                        <span
                            class="inline-block px-2 py-1 bg-gray-200 text-gray-600 rounded-full text-xs font-semibold">Never logged in</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right">
                        <form action="{{ route('kasirs.destroy', $kasir) }}" method="POST" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this cashier?')">
                            @csrf
                            @method('DELETE')
                            <button
                                class="px-3 py-1 bg-red-100 text-red-600 rounded-full text-sm font-semibold hover:bg-red-200 transition">🗑️ Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-4 text-center text-gray-500">No cashier accounts found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
