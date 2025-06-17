@extends('layouts.app')

@section('title', 'Daftar Capster')

@section('content')
<div class="max-w-6xl mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800">Daftar Capster</h1>
        <a href="{{ route('capsters.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white font-medium rounded-lg shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
           <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" /></svg>
           Tambah Baru
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow border border-gray-200">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inisial</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. HP</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Lahir</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Asal</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($capsters as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->inisial }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->jenis_kelamin == 'L' ? 'Laki‑laki' : 'Perempuan' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                        @php
                            $hp = preg_replace('/\D/', '', $c->no_hp);
                            if(strlen($hp) === 12) {
                                echo substr($hp, 0, 4) . '-' . substr($hp, 4, 4) . '-' . substr($hp, 8);
                            } else {
                                echo $c->no_hp;
                            }
                        @endphp
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->tgl_lahir->format('d-m-Y') }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">{{ $c->asal }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium space-x-2">
                        <a href="{{ route('capsters.show', $c) }}" class="text-blue-600 hover:text-blue-800">Lihat</a>
                        <a href="{{ route('capsters.edit', $c) }}" class="text-green-600 hover:text-green-800">Edit</a>
                        <form action="{{ route('capsters.destroy', $c) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus capster ini?')"
                                class="text-red-600 hover:text-red-800">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $capsters->links() }}
    </div>
</div>
@endsection
