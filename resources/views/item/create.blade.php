@extends('layouts.base')

@section('body')
<div class="container py-4" style="max-width: 600px;">
    <h4 class="mb-4">Add New Item</h4>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Sell Price</label>
            <input type="number" step="0.01" name="sell_price"
                   class="form-control" value="{{ old('sell_price') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Cost Price</label>
            <input type="number" step="0.01" name="cost_price"
                   class="form-control" value="{{ old('cost_price') }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Quantity</label>
            <input type="number" name="quantity"
                   class="form-control" value="{{ old('quantity', 0) }}"
                   min="0" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Item Image</label>
            <input type="file" name="image" class="form-control" accept="image/*">
            <small class="text-muted">Leave blank to use the default image.</small>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Save Item</button>
            <a href="{{ route('items.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection