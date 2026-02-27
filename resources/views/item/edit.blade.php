@extends('layouts.base')

@section('body')
<div class="container py-4" style="max-width: 600px;">
    <h4 class="mb-4">Edit Item #{{ $item->item_id }}</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.update', $item->item_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description', $item->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Sell Price</label>
            <input type="number" step="0.01" name="sell_price"
                   class="form-control"
                   value="{{ old('sell_price', $item->sell_price) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cost Price</label>
            <input type="number" step="0.01" name="cost_price"
                   class="form-control"
                   value="{{ old('cost_price', $item->cost_price) }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity"
                   class="form-control"
                   value="{{ old('quantity', $item->quantity) }}"
                   min="0" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Image</label><br>
            <img src="{{ $item->img_path === 'default.jpg'
                            ? asset('images/default.jpg')
                            : asset('storage/' . $item->img_path) }}"
                 alt="item image"
                 style="width: 100px; height: 100px; object-fit: cover;" class="mb-2">
        </div>

        <div class="mb-3">
            <label class="form-label">Replace Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Leave blank to keep the current image.</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-success">Update Item</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection