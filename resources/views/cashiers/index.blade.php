@extends('layouts.app')

@section('title', 'Cashier Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark">👥 Cashier Accounts</h4>
    <a href="{{ route('kasirs.create') }}" class="btn btn-success shadow-sm">
        + Add Cashier
    </a>
</div>

<div class="table-responsive">
    <table class="table table-hover align-middle shadow-sm border rounded overflow-hidden">
        <thead class="table-primary">
            <tr>
                <th scope="col">👤 Name</th>
                <th scope="col">📧 Email</th>
                <th scope="col">⏱️ Last Login</th>
                <th scope="col" class="text-end">⚙️ Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($cashiers as $kasir)
                <tr>
                    <td class="fw-medium">{{ $kasir->name }}</td>
                    <td>{{ $kasir->email }}</td>
                    <td>
                        @if ($kasir->last_login_at)
                            <span class="badge bg-info text-dark">
                                {{ \Carbon\Carbon::parse($kasir->last_login_at)->translatedFormat('d M Y H:i') }}
                            </span>
                        @else
                            <span class="badge bg-secondary">Never logged in</span>
                        @endif
                    </td>
                    <td class="text-end">
                        {{-- <a href="{{ route('kasirs.edit', $kasir) }}" class="btn btn-sm btn-outline-primary me-1">
                            ✏️ Edit
                        </a> --}}
                        <form action="{{ route('kasirs.destroy', $kasir) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Are you sure you want to delete this cashier?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                🗑️ Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted">
                        No cashier accounts found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
