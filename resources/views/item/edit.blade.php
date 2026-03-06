@extends('layouts.admin-base')

@section('body')

<style>
    @import url('https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Montserrat:wght@300;400;500&display=swap');

    :root {
        --kapture-black: #0a0a0f;
        --kapture-deep: #0f0d1a;
        --kapture-gold: #c9a84c;
        --kapture-gold-light: #e8c97a;
        --kapture-lilac: #a89bc2;
        --kapture-text: #d4cfe0;
        --kapture-muted: #6b6480;
        --kapture-border: rgba(201, 168, 76, 0.2);
        --kapture-border-subtle: rgba(168, 155, 194, 0.12);
    }

    .kapture-page {
        background: var(--kapture-black);
        min-height: 100vh;
        font-family: 'Montserrat', sans-serif;
        color: var(--kapture-text);
        padding: 3rem 2.5rem;
    }

    /* ── Page Header ── */
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
        letter-spacing: 0.02em;
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

    /* ── Two-panel layout ── */
    .kap-two-col {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 2rem;
    align-items: stretch;  /* ← was start */
    }

    .kap-panel {
    border: 1px solid var(--kapture-border-subtle);
    padding: 2rem;
    background: rgba(255,255,255,0.01);
    display: flex;           /* ← add */
    flex-direction: column;  /* ← add */
    }

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

    .kap-panel-right {
    justify-content: space-between;
    }

    /* ── Field Group ── */
    .kap-field {
        margin-bottom: 1.6rem;
    }

    .kap-field:last-child { margin-bottom: 0; }

    .kap-label {
        display: block;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.62rem;
        font-weight: 500;
        letter-spacing: 0.22em;
        text-transform: uppercase;
        color: var(--kapture-gold);
        margin-bottom: 0.55rem;
    }

    .kap-input,
    .kap-textarea {
        width: 100%;
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-text);
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        letter-spacing: 0.03em;
        padding: 0.45rem 0;
        transition: border-color 0.3s;
        outline: none;
    }

    .kap-textarea {
        resize: none;
        min-height: 52px;
    }

    .kap-input:focus,
    .kap-textarea:focus {
        border-bottom-color: var(--kapture-gold);
        color: #fff;
    }

    .kap-input::placeholder,
    .kap-textarea::placeholder { color: var(--kapture-muted); }

    /* Remove number spinners */
    .kap-input[type=number]::-webkit-inner-spin-button,
    .kap-input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }
    .kap-input[type=number] { -moz-appearance: textfield; }

    /* ── Price row ── */
    .kap-price-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 1.5rem;
    }

    /* ── Image preview ── */
    .kap-image-preview {
        display: flex;
        align-items: flex-start;
        gap: 1.25rem;
        padding: 1rem;
        border: 1px solid var(--kapture-border-subtle);
        background: rgba(201, 168, 76, 0.02);
        margin-bottom: 1.6rem;
    }

    .kap-image-preview img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid var(--kapture-border-subtle);
        flex-shrink: 0;
    }

    .kap-image-meta {
        display: flex;
        flex-direction: column;
        gap: 0.25rem;
        justify-content: center;
    }

    .kap-image-label-sm {
        font-size: 0.58rem;
        font-weight: 500;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--kapture-gold);
    }

    .kap-image-name {
        font-family: 'Cormorant Garamond', serif;
        font-size: 0.9rem;
        color: var(--kapture-muted);
        font-style: italic;
        word-break: break-all;
    }

    /* ── File input ── */
    .kap-file-input {
        width: 100%;
        background: transparent;
        border: 1px dashed var(--kapture-border-subtle);
        color: var(--kapture-muted);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        letter-spacing: 0.05em;
        padding: 0.75rem 1rem;
        cursor: pointer;
        transition: border-color 0.3s;
        outline: none;
    }

    .kap-file-input:hover { border-color: var(--kapture-gold); color: var(--kapture-text); }

    .kap-hint {
        font-size: 0.68rem;
        color: var(--kapture-muted);
        letter-spacing: 0.04em;
        margin-top: 0.4rem;
        font-style: italic;
    }

    /* ── Divider ── */
    .kap-divider {
        border: none;
        border-top: 1px solid var(--kapture-border-subtle);
        margin: 1.75rem 0;
    }

    /* ── Buttons ── */
    .kap-btn-row {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: 1.75rem;
    }

    .btn-kap-submit {
    flex: 1;        /* ← change from width: auto */
    background: var(--kapture-gold);
    border: 1px solid var(--kapture-gold);
    color: var(--kapture-black);
    font-family: 'Montserrat', sans-serif;
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    padding: 0.8rem 1.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    }

    .btn-kap-submit:hover {
        background: var(--kapture-gold-light);
        border-color: var(--kapture-gold-light);
    }

    .btn-kap-cancel {
    flex: 1;        /* ← change from width: auto */
    background: transparent;
    border: 1px solid var(--kapture-border-subtle);
    color: var(--kapture-muted);
    font-family: 'Montserrat', sans-serif;
    font-size: 0.75rem;
    font-weight: 500;
    letter-spacing: 0.2em;
    text-transform: uppercase;
    padding: 0.8rem 1.5rem;
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    }

    .btn-kap-cancel:hover {
        border-color: var(--kapture-muted);
        color: var(--kapture-text);
        text-decoration: none;
    }

    /* ── Error alert ── */
    .kap-errors {
        border: 1px solid rgba(192, 96, 96, 0.4);
        background: rgba(192, 96, 96, 0.06);
        padding: 1rem 1.25rem;
        margin-bottom: 2rem;
    }

    .kap-errors ul {
        margin: 0;
        padding-left: 1.2rem;
        font-size: 0.8rem;
        color: #e08080;
        letter-spacing: 0.04em;
    }

    @media (max-width: 768px) {
        .kap-two-col { grid-template-columns: 1fr; }
        .kap-price-row { grid-template-columns: 1fr; }
    }
</style>

@include('layouts.flash-messages')

<div class="kapture-page">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-eyebrow">
            <span>Inventory Management</span>
        </div>
        <h1 class="page-title">Edit Item</h1>
        <p class="page-subtitle">Item #{{ $item->item_id }} — Modify Details</p>
    </div>

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="kap-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Form --}}
    <form action="{{ route('items.update', $item->item_id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="kap-two-col">

            {{-- LEFT: Item Details --}}
            <div class="kap-panel">
                <p class="kap-panel-title">Item Details</p>

                {{-- Description --}}
                <div class="kap-field">
                    <label class="kap-label">Description</label>
                    <textarea name="description" class="kap-textarea" rows="2" required>{{ old('description', $item->description) }}</textarea>
                </div>

                {{-- Sell & Cost Price --}}
                <div class="kap-price-row">
                    <div class="kap-field">
                        <label class="kap-label">Sell Price (₱)</label>
                        <input type="number" step="0.01" name="sell_price"
                               class="kap-input"
                               value="{{ old('sell_price', $item->sell_price) }}" required>
                    </div>
                    <div class="kap-field">
                        <label class="kap-label">Cost Price (₱)</label>
                        <input type="number" step="0.01" name="cost_price"
                               class="kap-input"
                               value="{{ old('cost_price', $item->cost_price) }}" required>
                    </div>
                </div>

                {{-- Quantity --}}
                <div class="kap-field" style="max-width:180px;">
                    <label class="kap-label">Quantity</label>
                    <input type="number" name="quantity"
                           class="kap-input"
                           value="{{ old('quantity', $item->quantity) }}"
                           min="0" required>
                </div>
            </div>

            {{-- RIGHT: Image & Actions --}}
            <div class="kap-panel">
                <p class="kap-panel-title">Image & Actions</p>

                {{-- Current Image --}}
                <div class="kap-image-preview">
                    <img src="{{ $item->img_path === 'default.jpg'
                                    ? asset('images/default.jpg')
                                    : asset('storage/' . $item->img_path) }}"
                         alt="Current image">
                    <div class="kap-image-meta">
                        <span class="kap-image-label-sm">Current Image</span>
                        <span class="kap-image-name">{{ basename($item->img_path) }}</span>
                        <span class="kap-hint">Upload below to replace.</span>
                    </div>
                </div>

                {{-- Replace Image --}}
                <div class="kap-field">
                    <label class="kap-label">Replace Image</label>
                    <input type="file" name="image" class="kap-file-input" accept="image/*">
                    <p class="kap-hint">jpeg, png, jpg, gif — max 2MB</p>
                </div>

                {{-- Buttons --}}
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
@endsection