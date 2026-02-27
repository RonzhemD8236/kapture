@extends('layouts.base')

@section('body')
    <div class="container">
        <form action="{{ route('items.update', $item->item_id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="desc" class="form-label">item name</label>
                <input type="text" name="description" id="desc" class="form-control"
                    value="{{ old('description', $item->description) }}">
            </div>

            <div class="mb-3">
                <label for="cost" class="form-label">cost price</label>
                <input type="number" name="cost_price" id="cost" class="form-control"
                    min="0" step="0.01"
                    value="{{ old('cost_price', $item->cost_price) }}">
            </div>

            <div class="mb-3">
                <label for="sell" class="form-label">sell price</label>
                <input type="number" name="sell_price" id="sell" class="form-control"
                    min="0" step="0.01"
                    value="{{ old('sell_price', $item->sell_price) }}">
            </div>

            <div class="mb-3">
                <label for="qty" class="form-label">quantity</label>
                <input type="number" name="quantity" id="qty" class="form-control"
                    value="{{ old('quantity', $stock->quantity ?? 0) }}">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">upload image</label>
                @if ($item->img_path && $item->img_path !== 'default.jpg')
                    <div class="mb-2">
                        <img src="{{ Storage::url($item->img_path) }}" width="80" height="80" alt="current image">
                        <small class="text-muted d-block">Current image — upload a new one to replace it</small>
                    </div>
                @endif
                <input type="file" name="image" id="image" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Update item</button>
        </form>
    </div>
@endsection