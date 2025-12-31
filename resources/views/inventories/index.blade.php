@extends('layouts.admin')
@section('page_title', 'Inventories')
@section('content')
<div class="card-panel">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Inventories</h4>
    </div>
    <div class="table-responsive">
        <table class="table text-center align-middle table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Product</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Last Updated</th>
                </tr>
            </thead>
            <tbody>
                @forelse($inventories as $inventory)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            {{ $inventory->product->name ?? 'N/A' }}
                        </td>
                        <td>
                            <span class="fw-semibold">
                                {{ $inventory->stock }}
                            </span>
                        </td>
                        <td>
                            @if($inventory->stock > 0)
                                <span class="badge bg-success">In Stock</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </td>
                        <td>
                            {{ $inventory->updated_at->format('d M Y, h:i A') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            No inventory records found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
