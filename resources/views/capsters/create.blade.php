@extends('layouts.app')

@section('title', 'Tambah Capster')

@section('content')
    <div class="max-w-3xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        <div class="bg-white border border-gray-200 rounded-2xl shadow-xl p-8">
            <form action="{{ route('capsters.store') }}" method="POST" enctype="multipart/form-data" novalidate
                class="space-y-6">
                @csrf

                @include('capsters._form')

                <div class="flex justify-end gap-4 pt-6 border-t border-gray-100">
                    <a href="{{ route('capsters.index') }}"
                        class="px-5 py-2 border border-gray-300 text-gray-600 rounded-lg hover:bg-gray-100 transition">
                        Batal
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-300 transition">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');

            form.addEventListener('submit', function(e) {
                e.preventDefault(); // hentikan submit default

                Swal.fire({
                    title: 'Simpan data?',
                    text: "Pastikan semua data sudah benar sebelum disimpan.",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, simpan!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true,
                    focusCancel: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit(); // lanjutkan submit
                    }
                });
            });
        });
    </script>
@endsection
