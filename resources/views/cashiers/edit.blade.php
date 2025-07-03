@extends('layouts.app')

@section('title', 'Edit Kasir')

@section('content')
<h4>Edit Kasir</h4>

<form method="POST" action="{{ route('kasirs.update') }}">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Nama</label>
        <input type="text" name="name" class="form-control" value="{{ $kasir->name }}" required>
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control" value="{{ $kasir->email }}" required>
    </div>

    <button class="btn btn-success">Update</button>
    <a href="{{ route('kasirs.index') }}" class="btn btn-secondary">Batal</a>
</form>
@endsection
