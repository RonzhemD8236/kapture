@extends('layouts.base')

@section('body')
    <div class="container">
        @include('layouts.flash-messages')

        <form action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label for="desc" class="form-label">item name</label>
                <input type="text" name="description" id="desc" class="form-control"
                    value="{{ old('description') }}">
                @error('description')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="cost" class="form-label">cost price</label>
                <input type="number" name="cost_price" id="cost" class="form-control"
                    min="0" step="0.01" value="{{ old('cost_price', 0) }}">
            </div>

            <div class="mb-3">
                <label for="sell" class="form-label">sell price</label>
                <input type="number" name="sell_price" id="sell" class="form-control"
                    min="0" step="0.01" value="{{ old('sell_price', 0) }}">
            </div>

            <div class="mb-3">
                <label for="qty" class="form-label">quantity</label>
                <input type="number" name="quantity" id="qty" class="form-control"
                    value="{{ old('quantity', 0) }}">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">upload image</label>
                <input type="file" name="image" id="image" class="form-control">
                @error('image')
                    <div class="alert alert-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Add item</button>
        </form>
    </div>
@endsection