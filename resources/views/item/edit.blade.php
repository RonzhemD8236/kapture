@extends('layouts.admin-base')

@section('body')

<style>
    .kapture-page {
        background: var(--kapture-black);
        min-height: 100vh;
        font-family: 'Montserrat', sans-serif;
        color: var(--kapture-text);
        padding: 3rem 2.5rem;
    }

    .page-header {
        margin-bottom: 3rem;
        border-bottom: 1px solid var(--kapture-border);
        padding-bottom: 2rem;
    }

    .page-eyebrow {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        margin-bottom: 0.75rem;
    }

    .page-eyebrow::before,
    .page-eyebrow::after {
        content: '';
        flex: 0 0 40px;
        height: 1px;
        background: var(--kapture-gold);
    }

    .page-eyebrow span {
        font-size: 0.85rem;
        font-weight: 500;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--kapture-gold);
    }

    .page-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 3rem;
        font-weight: 300;
        color: #fff;
        line-height: 1.1;
        margin: 0;
    }

    .page-subtitle {
        font-size: 0.85rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--kapture-muted);
        margin-top: 0.5rem;
        font-style: italic;
    }

    .kap-two-col {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 2rem;
        align-items: stretch;
    }

    .kap-panel {
        border: 1px solid var(--kapture-border-subtle);
        padding: 2rem;
        background: rgba(255, 255, 255, 0.01);
        display: flex;
        flex-direction: column;
    }

    .kap-panel-right { justify-content: space-between; }

    .kap-panel-title {
        font-size: 0.6rem;
        font-weight: 500;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        color: var(--kapture-gold);
        margin-bottom: 1.75rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid var(--kapture-border-subtle);
    }

    .kap-field { margin-bottom: 1.6rem; }

    .kap-label {
        display: block;
        font-size: 0.62rem;
        font-weight: 500;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--kapture-gold);
        margin-bottom: 0.55rem;
    }

    .kap-input, .kap-textarea, .kap-select {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-text);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        padding: 0.45rem 0;
        outline: none;
        transition: border-color 0.3s;
    }

    .kap-textarea { resize: none; min-height: 80px; }
    .kap-select { -webkit-appearance: none; appearance: none; cursor: pointer; }
    .kap-select option { background: var(--kapture-deep); color: var(--kapture-text); }

    .kap-input:focus, .kap-textarea:focus, .kap-select:focus {
        border-bottom-color: var(--kapture-gold);
        color: #fff;
    }

    .kap-input::placeholder, .kap-textarea::placeholder { color: var(--kapture-muted); font-style: italic; }
    .kap-input[type=number]::-webkit-inner-spin-button,
    .kap-input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }
    .kap-input[type=number] { -moz-appearance: textfield; }

    .kap-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1.5rem; }

    /* ── Shared image grid ── */
    .kap-images-label {
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--kapture-gold);
        margin-bottom: 0.75rem;
        display: block;
    }

    .kap-images-grid {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-bottom: 1.6rem;
    }

    /* ── Existing image card (checkbox delete) ── */
    .kap-img-card {
        position: relative;
        width: 80px;
        cursor: pointer;
        user-select: none;
    }

    .kap-img-card input[type="checkbox"] {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
        pointer-events: none;
    }

    .kap-img-card img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid var(--kapture-border-subtle);
        display: block;
        transition: opacity 0.25s, filter 0.25s, border-color 0.25s;
    }

    .kap-img-card img.primary { border: 2px solid var(--kapture-gold); }

    .kap-img-overlay {
        position: absolute;
        top: 0; left: 0;
        width: 80px; height: 80px;
        background: rgba(192, 60, 60, 0);
        transition: background 0.25s;
        pointer-events: none;
    }

    .kap-img-x {
        position: absolute;
        top: 4px; right: 4px;
        width: 18px; height: 18px;
        background: rgba(0,0,0,0.5);
        border: 1px solid rgba(255,255,255,0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.55rem;
        color: rgba(255,255,255,0.35);
        transition: all 0.2s;
        pointer-events: none;
    }

    .kap-img-card:hover img              { border-color: rgba(192,60,60,0.5); }
    .kap-img-card:hover .kap-img-overlay { background: rgba(192,60,60,0.1); }
    .kap-img-card:hover .kap-img-x       { background: rgba(192,60,60,0.7); border-color: transparent; color: #fff; }

    .kap-img-card input:checked ~ img              { opacity: 0.3; filter: grayscale(60%); border-color: rgba(192,60,60,0.7) !important; }
    .kap-img-card input:checked ~ .kap-img-overlay { background: rgba(192,60,60,0.4); }
    .kap-img-card input:checked ~ .kap-img-x       { background: #c03c3c; border-color: #c03c3c; color: #fff; }
    .kap-img-card input:checked ~ .kap-img-remove-label { color: #c06060; }

    .kap-img-remove-label {
        display: block;
        font-size: 0.48rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--kapture-muted);
        text-align: center;
        margin-top: 0.3rem;
        transition: color 0.2s;
    }

    .kap-primary-tag {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: var(--kapture-gold);
        color: var(--kapture-black);
        font-size: 0.42rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        text-align: center;
        padding: 2px 0;
        pointer-events: none;
    }

    /* ── New image preview card ── */
    .kap-preview-card {
        position: relative;
        width: 80px;
    }

    .kap-preview-card img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px dashed rgba(180,150,80,0.5);
        display: block;
    }

    /* Gold NEW ribbon — same style as PRIMARY */
    .kap-new-tag {
        position: absolute;
        bottom: 0; left: 0; right: 0;
        background: rgba(180,150,80,0.25);
        border-top: 1px solid rgba(180,150,80,0.4);
        color: var(--kapture-gold);
        font-size: 0.42rem;
        font-weight: 700;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        text-align: center;
        padding: 2px 0;
        pointer-events: none;
    }

    /* X button to remove pending upload */
    .kap-preview-remove {
        position: absolute;
        top: 4px; right: 4px;
        width: 18px; height: 18px;
        background: rgba(192,60,60,0.75);
        border: none;
        color: #fff;
        font-size: 0.55rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: background 0.2s;
        padding: 0;
    }

    .kap-preview-remove:hover { background: #c03c3c; }

    .kap-img-remove-label-new {
        display: block;
        font-size: 0.48rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--kapture-muted);
        text-align: center;
        margin-top: 0.3rem;
    }

    /* ── File input ── */
    .kap-file-input {
        width: 100%;
        background: transparent;
        border: 1px dashed var(--kapture-border-subtle);
        color: var(--kapture-muted);
        font-size: 0.75rem;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: border-color 0.3s;
    }

    .kap-file-input:hover { border-color: var(--kapture-gold); }

    .kap-hint {
        font-size: 0.68rem;
        color: var(--kapture-muted);
        margin-top: 0.4rem;
        font-style: italic;
    }

    .kap-btn-row {
        display: flex;
        gap: 0.75rem;
        margin-top: auto;
        padding-top: 1.75rem;
    }

    .btn-kap-submit {
        flex: 1;
        background: var(--kapture-gold);
        border: 1px solid var(--kapture-gold);
        color: var(--kapture-black);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        padding: 0.8rem;
        cursor: pointer;
        transition: all 0.3s;
    }

    .btn-kap-submit:hover { background: var(--kapture-gold-light); border-color: var(--kapture-gold-light); }

    .btn-kap-cancel {
        flex: 1;
        background: transparent;
        border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-muted);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        padding: 0.8rem;
        text-decoration: none;
        text-align: center;
        transition: all 0.3s;
        display: block;
    }

    .btn-kap-cancel:hover { border-color: var(--kapture-muted); color: var(--kapture-text); text-decoration: none; }

    .kap-errors {
        border: 1px solid rgba(192,96,96,0.4);
        background: rgba(192,96,96,0.06);
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
    }

    .kap-errors ul { margin: 0; padding-left: 1.2rem; font-size: 0.8rem; color: #e08080; }

    @media (max-width: 768px) {
        .kap-two-col { grid-template-columns: 1fr; }
        .kap-row     { grid-template-columns: 1fr; }
    }
</style>

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow"><span>Inventory Management</span></div>
        <h1 class="page-title">Edit Item</h1>
        <p class="page-subtitle">Item #{{ $item->item_id }} — Modify Details</p>
    </div>

    @if($errors->any())
        <div class="kap-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form id="editForm" action="{{ route('items.update', $item->item_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="kap-two-col">

            {{-- LEFT --}}
            <div class="kap-panel">
                <p class="kap-panel-title">Item Details</p>

                <div class="kap-field">
                    <label class="kap-label">Title</label>
                    <input type="text" name="title" class="kap-input"
                           value="{{ old('title', $item->title) }}" required>
                </div>

                <div class="kap-field">
                    <label class="kap-label">Description</label>
                    <textarea name="description" class="kap-textarea" required>{{ old('description', $item->description) }}</textarea>
                </div>

                <div class="kap-row">
                    <div class="kap-field">
                        <label class="kap-label">Category</label>
                        <select name="category" class="kap-select" required>
                            @foreach(['Mirrorless', 'DSLR', 'Point & Shoot', 'Action Camera', 'Film Camera', 'Accessories'] as $cat)
                                <option value="{{ $cat }}" {{ old('category', $item->category) === $cat ? 'selected' : '' }}>
                                    {{ $cat }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="kap-field">
                        <label class="kap-label">Quantity</label>
                        <input type="number" name="quantity" class="kap-input"
                               value="{{ old('quantity', $item->quantity) }}" min="0" required>
                    </div>
                </div>

                <div class="kap-row">
                    <div class="kap-field">
                        <label class="kap-label">Sell Price (₱)</label>
                        <input type="number" step="0.01" name="sell_price"
                               class="kap-input" value="{{ old('sell_price', $item->sell_price) }}" required>
                    </div>
                    <div class="kap-field">
                        <label class="kap-label">Cost Price (₱)</label>
                        <input type="number" step="0.01" name="cost_price"
                               class="kap-input" value="{{ old('cost_price', $item->cost_price) }}" required>
                    </div>
                </div>
            </div>

            {{-- RIGHT --}}
            <div class="kap-panel kap-panel-right">
                <p class="kap-panel-title">Images & Actions</p>

                @php
                    $allImages = $item->images
                        ? explode(',', $item->images)
                        : ($item->img_path !== 'default.jpg' ? [$item->img_path] : []);
                @endphp

                <span class="kap-images-label">Images — click saved to remove · × to drop new</span>

                {{-- One shared grid for both saved and new previews --}}
                <div class="kap-images-grid" id="imagesGrid">

                    {{-- Saved images --}}
                    @foreach($allImages as $index => $img)
                        <label class="kap-img-card">
                            <input type="checkbox" name="delete_images[]" value="{{ $img }}">
                            <img src="{{ asset('storage/' . $img) }}"
                                 alt="Image {{ $index + 1 }}"
                                 class="{{ $index === 0 ? 'primary' : '' }}">
                            <div class="kap-img-overlay"></div>
                            <div class="kap-img-x">✕</div>
                            @if($index === 0)
                                <span class="kap-primary-tag">Primary</span>
                            @endif
                            <span class="kap-img-remove-label">Remove</span>
                        </label>
                    @endforeach

                    {{-- New image previews injected here by JS --}}

                </div>

                <div class="kap-field">
                    <label class="kap-label">Add Images</label>
                    <input type="file" id="imageUpload" name="images[]"
                           class="kap-file-input" accept="image/*" multiple>
                    <p class="kap-hint">First remaining saved image becomes primary. Max 2MB each.</p>
                </div>

                <div class="kap-btn-row">
                    <button type="submit" class="btn-kap-submit">
                        <i class="bi bi-check2"></i> Update Item
                    </button>
                    <a href="{{ route('items.index') }}" class="btn-kap-cancel">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>

<script>
    // Keeps track of files the user selected, minus any they removed
    var selectedFiles = [];

    document.getElementById('imageUpload').onchange = function () {
        // Merge newly picked files into our list
        for (var i = 0; i < this.files.length; i++) {
            selectedFiles.push(this.files[i]);
        }
        renderPreviews();
    };

    function renderPreviews() {
        // Remove old preview cards from the grid
        var old = document.querySelectorAll('.kap-preview-card');
        for (var i = 0; i < old.length; i++) old[i].remove();

        var grid = document.getElementById('imagesGrid');

        selectedFiles.forEach(function (file, index) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var card = document.createElement('div');
                card.className = 'kap-preview-card';
                card.innerHTML =
                    '<img src="' + e.target.result + '" alt="' + file.name + '">' +
                    '<button type="button" class="kap-preview-remove" data-index="' + index + '">✕</button>' +
                    '<span class="kap-new-tag">New</span>' +
                    '<span class="kap-img-remove-label-new">Remove</span>';

                // Remove button drops this file from the list
                card.querySelector('.kap-preview-remove').onclick = function () {
                    selectedFiles.splice(parseInt(this.dataset.index), 1);
                    rebuildFileInput();
                    renderPreviews();
                };

                grid.appendChild(card);
            };
            reader.readAsDataURL(file);
        });

        rebuildFileInput();
    }

    // Sync selectedFiles back into a real FileList on a hidden input
    // so the form actually submits the remaining files
    function rebuildFileInput() {
        var old = document.getElementById('hiddenFiles');
        if (old) old.remove();

        var dt = new DataTransfer();
        selectedFiles.forEach(function (f) { dt.items.add(f); });
        document.getElementById('imageUpload').files = dt.files;
    }
</script>

@endsection