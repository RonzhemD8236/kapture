@extends('layouts.admin-base')

@section('body')

<style>
    .kapture-page { background: var(--kapture-black); min-height: 100vh; font-family: 'Montserrat', sans-serif; color: var(--kapture-text); padding: 3rem 2.5rem; }

    .page-header { margin-bottom: 3rem; border-bottom: 1px solid var(--kapture-border); padding-bottom: 2rem; }
    .page-eyebrow { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .page-eyebrow::before, .page-eyebrow::after { content: ''; flex: 0 0 40px; height: 1px; background: var(--kapture-gold); }
    .page-eyebrow span { font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 300; color: #fff; line-height: 1.1; margin: 0; }
    .page-subtitle { font-size: 0.85rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--kapture-muted); margin-top: 0.5rem; font-style: italic; }

    .kap-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: stretch; }
    .kap-panel { border: 1px solid var(--kapture-border-subtle); padding: 2rem; background: rgba(255,255,255,0.01); display: flex; flex-direction: column; }
    .kap-panel-right { justify-content: space-between; }
    .kap-panel-title { font-size: 0.6rem; font-weight: 500; letter-spacing: 0.25em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 1.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--kapture-border-subtle); }

    .kap-field { margin-bottom: 1.6rem; }
    .kap-label { display: block; font-size: 0.62rem; font-weight: 500; letter-spacing: 0.22em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 0.55rem; }

    .kap-input, .kap-textarea, .kap-select {
        width: 100%; background: transparent; border: none;
        border-bottom: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-text); font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem; padding: 0.45rem 0; outline: none; transition: border-color 0.3s;
    }
    .kap-textarea { resize: none; min-height: 80px; }
    .kap-select { appearance: none; cursor: pointer; }
    .kap-select option { background: var(--kapture-deep); color: var(--kapture-text); }
    .kap-input:focus, .kap-textarea:focus, .kap-select:focus { border-bottom-color: var(--kapture-gold); color: #fff; }
    .kap-input::placeholder, .kap-textarea::placeholder { color: var(--kapture-muted); font-style: italic; }
    .kap-input[type=number]::-webkit-inner-spin-button, .kap-input[type=number]::-webkit-outer-spin-button { -webkit-appearance: none; }
    .kap-input[type=number] { -moz-appearance: textfield; }

    .kap-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1.5rem; }

    .kap-file-input { width: 100%; background: transparent; border: 1px dashed var(--kapture-border-subtle); color: var(--kapture-muted); font-size: 0.75rem; padding: 0.75rem 1rem; cursor: pointer; }
    .kap-file-input:hover { border-color: var(--kapture-gold); }
    .kap-hint { font-size: 0.68rem; color: var(--kapture-muted); margin-top: 0.4rem; font-style: italic; }

    /* ── Image preview grid ── */
    .kap-images-label { font-size: 0.58rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 0.75rem; display: block; }
    .kap-images-grid { display: flex; flex-wrap: wrap; gap: 0.75rem; margin-bottom: 1.6rem; }

    .kap-preview-card { position: relative; width: 80px; }
    .kap-preview-card img { width: 80px; height: 80px; object-fit: cover; border: 1px dashed rgba(180,150,80,0.5); display: block; }

    .kap-new-tag { position: absolute; bottom: 0; left: 0; right: 0; background: rgba(180,150,80,0.25); border-top: 1px solid rgba(180,150,80,0.4); color: var(--kapture-gold); font-size: 0.42rem; font-weight: 700; letter-spacing: 0.14em; text-transform: uppercase; text-align: center; padding: 2px 0; pointer-events: none; }

    /* First preview gets a gold PRIMARY ribbon */
    .kap-preview-card.is-primary .kap-new-tag { background: var(--kapture-gold); color: var(--kapture-black); border-top: none; }

    .kap-preview-remove { position: absolute; top: 4px; right: 4px; width: 18px; height: 18px; background: rgba(192,60,60,0.75); border: none; color: #fff; font-size: 0.55rem; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: background 0.2s; padding: 0; }
    .kap-preview-remove:hover { background: #c03c3c; }

    .kap-img-remove-label { display: block; font-size: 0.48rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--kapture-muted); text-align: center; margin-top: 0.3rem; }

    .kap-btn-row { display: flex; gap: 0.75rem; margin-top: auto; padding-top: 1.75rem; }
    .btn-kap-submit { flex: 1; background: var(--kapture-gold); border: 1px solid var(--kapture-gold); color: var(--kapture-black); font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em; text-transform: uppercase; padding: 0.8rem; cursor: pointer; transition: all 0.3s; }
    .btn-kap-submit:hover { background: var(--kapture-gold-light); }
    .btn-kap-cancel { flex: 1; background: transparent; border: 1px solid var(--kapture-border-subtle); color: var(--kapture-muted); font-family: 'Montserrat', sans-serif; font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase; padding: 0.8rem; text-decoration: none; text-align: center; transition: all 0.3s; display: block; }
    .btn-kap-cancel:hover { border-color: var(--kapture-muted); color: var(--kapture-text); text-decoration: none; }

    .kap-errors { border: 1px solid rgba(192,96,96,0.4); background: rgba(192,96,96,0.06); padding: 1rem 1.25rem; margin-bottom: 2rem; }
    .kap-errors ul { margin: 0; padding-left: 1.2rem; font-size: 0.8rem; color: #e08080; }

    @media (max-width: 768px) { .kap-two-col { grid-template-columns: 1fr; } .kap-row { grid-template-columns: 1fr; } }
</style>

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow"><span>Inventory Management</span></div>
        <h1 class="page-title">Add New Item</h1>
        <p class="page-subtitle">Fine Photographic Instruments — New Entry</p>
    </div>

    @if($errors->any())
        <div class="kap-errors">
            <ul>
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    <form id="createForm" action="{{ route('items.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="kap-two-col">

            {{-- LEFT: Item Details --}}
            <div class="kap-panel">
                <p class="kap-panel-title">Item Details</p>

                <div class="kap-field">
                    <label class="kap-label">Title</label>
                    <input type="text" name="title" class="kap-input"
                           value="{{ old('title') }}" placeholder="e.g. Sony Alpha A7 III" required>
                </div>

                <div class="kap-field">
                    <label class="kap-label">Description</label>
                    <textarea name="description" class="kap-textarea"
                              placeholder="Item details..." required>{{ old('description') }}</textarea>
                </div>

                <div class="kap-row">
                    <div class="kap-field">
                        <label class="kap-label">Category</label>
                        <select name="category" class="kap-select" required>
                            <option value="" disabled {{ old('category') ? '' : 'selected' }}>Select...</option>
                            @foreach(['Mirrorless', 'DSLR', 'Point & Shoot', 'Action Camera', 'Film Camera', 'Accessories'] as $cat)
                                <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="kap-field">
                        <label class="kap-label">Quantity</label>
                        <input type="number" name="quantity" class="kap-input"
                               placeholder="0" value="{{ old('quantity', 0) }}" min="0" required>
                    </div>
                </div>

                <div class="kap-row">
                    <div class="kap-field">
                        <label class="kap-label">Sell Price (₱)</label>
                        <input type="number" step="0.01" name="sell_price"
                               class="kap-input" placeholder="0.00" value="{{ old('sell_price') }}" required>
                    </div>
                    <div class="kap-field">
                        <label class="kap-label">Cost Price (₱)</label>
                        <input type="number" step="0.01" name="cost_price"
                               class="kap-input" placeholder="0.00" value="{{ old('cost_price') }}" required>
                    </div>
                </div>
            </div>

            {{-- RIGHT: Images & Actions --}}
            <div class="kap-panel kap-panel-right">
                <p class="kap-panel-title">Images & Actions</p>

                {{-- Preview grid — shown once files are picked --}}
                <div id="imagesGrid" class="kap-images-grid" style="display:none;"></div>

                <div class="kap-field">
                    <label class="kap-label">Item Images</label>
                    <input type="file" id="imageUpload" name="images[]"
                           class="kap-file-input" accept="image/*" multiple>
                    <p class="kap-hint">First image becomes primary. Max 2MB each. Leave blank for default.</p>
                </div>

                <div class="kap-btn-row">
                    <button type="submit" class="btn-kap-submit">
                        <i class="bi bi-plus-lg"></i> Save Item
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
    var selectedFiles = [];

    document.getElementById('imageUpload').onchange = function () {
        for (var i = 0; i < this.files.length; i++) {
            selectedFiles.push(this.files[i]);
        }
        renderPreviews();
    };

    function renderPreviews() {
        var grid = document.getElementById('imagesGrid');
        grid.innerHTML = '';
        grid.style.display = selectedFiles.length ? 'flex' : 'none';

        selectedFiles.forEach(function (file, index) {
            var reader = new FileReader();
            reader.onload = function (e) {
                var card = document.createElement('div');
                card.className = 'kap-preview-card' + (index === 0 ? ' is-primary' : '');

                card.innerHTML =
                    '<img src="' + e.target.result + '" alt="' + file.name + '">' +
                    '<button type="button" class="kap-preview-remove" data-index="' + index + '">✕</button>' +
                    '<span class="kap-new-tag">' + (index === 0 ? 'Primary' : 'New') + '</span>' +
                    '<span class="kap-img-remove-label">Remove</span>';

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

    function rebuildFileInput() {
        var dt = new DataTransfer();
        selectedFiles.forEach(function (f) { dt.items.add(f); });
        document.getElementById('imageUpload').files = dt.files;
    }
</script>

@endsection