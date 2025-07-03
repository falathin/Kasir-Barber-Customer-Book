@extends('layouts.app')

@section('title', 'Add Cashier')

@section('content')

<form method="POST" action="{{ route('kasirs.store') }}">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Full Name</label>
        <input type="text" id="name" name="name" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="email" class="form-label">Email Address</label>
        <input type="email" id="email" name="email" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" class="form-control" required>
    </div>

    <div class="mb-3">
        <label for="password_confirmation" class="form-label">Confirm Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
    </div>

    <button class="btn btn-success">Save</button>
    <a href="{{ route('kasirs.index') }}" class="btn btn-secondary">Cancel</a>
</form>
@endsection
