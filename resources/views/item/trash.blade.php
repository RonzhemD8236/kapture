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
        font-size: 3.2rem;
        font-weight: 300;
        color: #fff;
        letter-spacing: 0.02em;
        line-height: 1.1;
        margin: 0;
    }

    .page-subtitle {
        font-size: 0.9rem;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        color: var(--kapture-muted);
        margin-top: 0.5rem;
        font-style: italic;
    }

    /* ── Toolbar ── */
    .kapture-toolbar {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }

    .btn-kapture-primary {
        background: transparent;
        border: 1px solid var(--kapture-gold);
        color: var(--kapture-gold);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        font-weight: 500;
        letter-spacing: 0.15em;
        text-transform: uppercase;
        padding: 0.7rem 1.6rem;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-kapture-primary:hover {
        background: var(--kapture-gold);
        color: var(--kapture-black);
        text-decoration: none;
    }

    .toolbar-divider {
        width: 1px;
        height: 36px;
        background: var(--kapture-border-subtle);
    }

    /* ── Search ── */
    .kapture-search-wrap {
        position: relative;
        margin-left: auto;
    }

    .kapture-search {
        background: transparent;
        border: none;
        border-bottom: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-text);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.85rem;
        letter-spacing: 0.08em;
        padding: 0.5rem 2rem 0.5rem 0;
        width: 240px;
        transition: border-color 0.3s;
    }

    .kapture-search::placeholder {
        color: var(--kapture-muted);
        font-style: italic;
    }

    .kapture-search:focus {
        outline: none;
        border-bottom-color: var(--kapture-gold);
        box-shadow: none;
        background: transparent;
        color: var(--kapture-text);
    }

    .search-icon {
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
        color: var(--kapture-muted);
        font-size: 0.95rem;
        pointer-events: none;
    }

    /* ── Table ── */
    .kapture-table-wrap {
        border: 1px solid var(--kapture-border-subtle);
        overflow: hidden;
    }

    .kapture-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 0.9rem;
        letter-spacing: 0.03em;
        margin: 0;
    }

    .kapture-table thead tr {
        border-bottom: 1px solid var(--kapture-border);
        background: rgba(201, 168, 76, 0.04);
    }

    .kapture-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-weight: 500;
        font-size: 0.75rem;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--kapture-gold);
        padding: 1.1rem 1.4rem;
        border: none;
        white-space: nowrap;
    }

    .kapture-table tbody tr {
        border-bottom: 1px solid var(--kapture-border-subtle);
        transition: background 0.2s ease;
    }

    .kapture-table tbody tr:last-child {
        border-bottom: none;
    }

    .kapture-table tbody tr:hover {
        background: rgba(168, 155, 194, 0.05);
    }

    .kapture-table tbody td {
        padding: 1.1rem 1.4rem;
        border: none;
        vertical-align: middle;
        color: var(--kapture-text);
    }

    .item-id {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.1rem;
        color: var(--kapture-muted);
        font-style: italic;
    }

    .item-img {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 1px solid var(--kapture-border-subtle);
        display: block;
    }

    .item-description {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.25rem;
        font-weight: 400;
        color: #fff;
        letter-spacing: 0.02em;
    }

    .item-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.9rem;
        color: var(--kapture-gold-light);
        letter-spacing: 0.04em;
    }

    .item-cost {
        color: var(--kapture-text);
    }

    .item-qty {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.5rem;
        color: var(--kapture-text);
    }

    .deleted-date {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem;
        color: #c06060;
        letter-spacing: 0.05em;
        white-space: nowrap;
    }

    /* ── Action Buttons ── */
    .action-wrap {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-action-restore {
        background: transparent;
        border: 1px solid rgba(100, 180, 100, 0.35);
        color: #80c080;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-action-restore:hover {
        border-color: #80c080;
        background: rgba(100, 180, 100, 0.1);
        color: #a0e0a0;
    }

    .btn-action-delete {
        background: transparent;
        border: 1px solid rgba(192, 96, 96, 0.3);
        color: #c06060;
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.85rem;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-action-delete:hover {
        border-color: #c06060;
        background: rgba(192, 96, 96, 0.1);
        color: #e08080;
    }

    /* ── Empty State ── */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
    }

    .empty-state-icon {
        font-size: 2.5rem;
        color: var(--kapture-muted);
        margin-bottom: 1rem;
        opacity: 0.4;
    }

    .empty-state-text {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.3rem;
        font-style: italic;
        color: var(--kapture-muted);
        letter-spacing: 0.05em;
    }

    /* ── Pagination ── */
    .kapture-pagination {
        margin-top: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .kap-page-btn {
        background: transparent;
        border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-muted);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        letter-spacing: 0.08em;
        padding: 0.45rem 0.85rem;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-block;
    }

    .kap-page-btn:hover {
        border-color: var(--kapture-gold);
        color: var(--kapture-gold);
        text-decoration: none;
    }

    .kap-page-active {
        background: var(--kapture-gold);
        border: 1px solid var(--kapture-gold);
        color: var(--kapture-black);
        font-weight: 600;
        padding: 0.45rem 0.85rem;
        font-size: 0.8rem;
        font-family: 'Montserrat', sans-serif;
        display: inline-block;
    }

    .kap-nav-btn {
        background: transparent;
        border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-muted);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        padding: 0.45rem 1.1rem;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-block;
    }

    .kap-nav-btn:hover {
        border-color: var(--kapture-gold);
        color: var(--kapture-gold);
        text-decoration: none;
    }

    .kap-nav-disabled {
        opacity: 0.3;
        pointer-events: none;
    }
</style>

@include('layouts.flash-messages')

<div class="kapture-page">

    {{-- Page Header --}}
    <div class="page-header">
        <div class="page-eyebrow">
            <span>Inventory Management</span>
        </div>
        <h1 class="page-title">Trash</h1>
        <p class="page-subtitle">Deleted Items — Catalogue</p>
    </div>

    {{-- Toolbar --}}
    <div class="kapture-toolbar">

        <a href="{{ route('items.index') }}" class="btn-kapture-primary">
            <i class="bi bi-arrow-left"></i> Back to Items
        </a>

        <form method="GET" action="{{ route('items.trash') }}" class="kapture-search-wrap">
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Search trash..."
                   class="kapture-search">
            <i class="bi bi-search search-icon"></i>
        </form>

    </div>

    {{-- Table --}}
    <div class="kapture-table-wrap">
        <table class="kapture-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Item Name</th>
                    <th>Sell Price</th>
                    <th>Cost Price</th>
                    <th>Deleted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td><span class="item-id">#{{ $item->item_id }}</span></td>
                    <td>
                        <img class="item-img"
                             src="{{ $item->img_path === 'default.jpg' ? asset('images/default.jpg') : asset('storage/' . $item->img_path) }}"
                             alt="{{ $item->title }}">
                    </td>
                    <td><span class="item-description">{{ $item->title }}</span></td>
                    <td><span class="item-price">₱ {{ number_format($item->sell_price, 2) }}</span></td>
                    <td><span class="item-price item-cost">₱ {{ number_format($item->cost_price, 2) }}</span></td>
                    <td>
                        <span class="deleted-date">
                            {{ \Carbon\Carbon::parse($item->deleted_at)->format('M d, Y') }}
                        </span>
                    </td>
                    <td>
                        <div class="action-wrap">

                            {{-- Restore --}}
                            <form method="POST" action="{{ route('items.restore', $item->item_id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-action-restore" title="Restore">
                                    <i class="bi bi-arrow-counterclockwise"></i>
                                </button>
                            </form>

                            {{-- Permanently Delete --}}
                            <form method="POST" action="{{ route('items.forceDelete', $item->item_id) }}"
                                  onsubmit="return confirm('Permanently delete \'{{ addslashes($item->title) }}\'? This cannot be undone.')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-delete" title="Delete Permanently">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7">
                        <div class="empty-state">
                            <div class="empty-state-icon"><i class="bi bi-trash"></i></div>
                            <p class="empty-state-text">Trash is empty.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($items->hasPages())
    <div class="kapture-pagination">

        <div class="d-flex align-items-center gap-1">
            @foreach($items->getUrlRange(1, $items->lastPage()) as $page => $url)
                @if($page == $items->currentPage())
                    <span class="kap-page-active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}" class="kap-page-btn">{{ $page }}</a>
                @endif
            @endforeach
        </div>

        <div class="d-flex align-items-center gap-2 ms-auto">
            @if($items->onFirstPage())
                <span class="kap-nav-btn kap-nav-disabled">← Prev</span>
            @else
                <a href="{{ $items->previousPageUrl() }}" class="kap-nav-btn">← Prev</a>
            @endif

            @if($items->hasMorePages())
                <a href="{{ $items->nextPageUrl() }}" class="kap-nav-btn">Next →</a>
            @else
                <span class="kap-nav-btn kap-nav-disabled">Next →</span>
            @endif
        </div>

    </div>
    @endif

</div>

@endsection