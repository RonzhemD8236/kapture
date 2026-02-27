@extends('layouts.base')

@section('body')
@include('layouts.flash-messages')

<div class="container-fluid px-4 py-3">

    {{-- Add button --}}
    <a href="{{ route('items.create') }}" class="btn btn-primary mb-3">Add Item</a>

    {{-- Excel import --}}
    <form action="{{ route('item.import') }}" method="POST" enctype="multipart/form-data"
          class="d-inline-flex align-items-center gap-2 mb-3">
        @csrf
        <input type="file" name="file" class="form-control form-control-sm" style="width:auto;">
        <button type="submit" class="btn btn-info text-white">Import Excel File</button>
    </form>

    {{-- Search --}}
    <form method="GET" action="{{ route('items.index') }}" class="mb-3">
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Search description..."
               class="form-control"
               style="width: 220px;">
    </form>

    {{-- Table --}}
    <table class="table table-bordered table-hover align-middle">
        <thead class="table-light">
            <tr>
                <th>Item ID</th>
                <th>Image</th>
                <th>Description</th>
                <th>Sell Price</th>
                <th>Cost Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($items as $item)
            <tr>
                <td>{{ $item->item_id }}</td>
                <td>
                    <img src="{{ $item->img_path === 'default.jpg'
                                    ? asset('images/default.jpg')
                                    : asset('storage/' . $item->img_path) }}"
                         alt="item image"
                         style="width: 60px; height: 60px; object-fit: cover;">
                </td>
                <td>{{ $item->description }}</td>
                <td>{{ number_format($item->sell_price, 2) }}</td>
                <td>{{ number_format($item->cost_price, 2) }}</td>
                <td>{{ $item->quantity ?? 0 }}</td>
                <td>
                    {{-- Edit --}}
                    <a href="{{ route('items.edit', $item->item_id) }}"
                       class="btn btn-sm btn-outline-primary mb-1">
                        <i class="bi bi-pencil-square"></i>
                    </a>

                    {{-- Delete --}}
                    <form action="{{ route('items.destroy', $item->item_id) }}"
                          method="POST"
                          class="d-inline"
                          onsubmit="return confirm('Delete this item?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mb-1">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center text-muted">No items found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{ $items->withQueryString()->links() }}
</div>
@endsection