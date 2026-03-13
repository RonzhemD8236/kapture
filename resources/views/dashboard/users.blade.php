@extends('layouts.admin-base')

@section('body')

<style>
    .kapture-page {
        background: var(--kapture-black);
        min-height: 100vh;
        padding: 3rem 2.5rem;
        font-family: 'Montserrat', sans-serif;
        color: var(--kapture-text);
    }

    /* ── Page Header ── */
    .page-header {
        margin-bottom: 3rem;
        padding-bottom: 2rem;
        border-bottom: 1px solid var(--kapture-border);
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
        margin: 0;
        line-height: 1.1;
    }

    .page-subtitle {
        font-size: 0.85rem;
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

    .btn-kap-add {
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
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-kap-add:hover {
        background: var(--kapture-gold);
        color: var(--kapture-black);
        text-decoration: none;
    }

    /* ── Search — same as items ── */
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

    /* ── Action Buttons ── */
    .action-wrap {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }

    .btn-action-edit,
    .btn-action-delete {
        width: 34px;
        height: 34px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        background: transparent;
        text-decoration: none;
        transition: all 0.2s;
        cursor: pointer;
    }

    .btn-action-edit {
        border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-lilac);
    }

    .btn-action-edit:hover {
        border-color: var(--kapture-lilac);
        color: #fff;
        background: rgba(168, 155, 194, 0.1);
        text-decoration: none;
    }

    .btn-action-delete {
        border: 1px solid rgba(192, 96, 96, 0.3);
        color: #c06060;
    }

    .btn-action-delete:hover {
        border-color: #c06060;
        background: rgba(192, 96, 96, 0.1);
        color: #e08080;
    }

    /* ── Table wrap ── */
    .kapture-table-wrap {
        border: 1px solid var(--kapture-border-subtle);
        overflow: hidden;
    }

    /* ── Hide DataTable default controls ── */
    #users-table_wrapper .dataTables_length,
    #users-table_wrapper .dataTables_filter,
    #users-table_wrapper .dataTables_info {
        display: none !important;
    }

    /* ── DataTable table styles ── */
    table#users-table {
        width: 100% !important;
        border-collapse: collapse;
        margin: 0 !important;
    }

    table#users-table thead tr {
        background: rgba(201, 168, 76, 0.04);
        border-bottom: 1px solid var(--kapture-border);
    }

    table#users-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem;
        font-weight: 500;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        color: var(--kapture-gold) !important;
        padding: 1.1rem 1.4rem;
        border: none !important;
        background: transparent !important;
        white-space: nowrap;
    }

    table#users-table tbody tr {
        border-bottom: 1px solid var(--kapture-border-subtle);
        transition: background 0.2s;
    }

    table#users-table tbody tr:last-child {
        border-bottom: none;
    }

    table#users-table tbody tr:hover {
        background: rgba(168, 155, 194, 0.05) !important;
    }

    table#users-table tbody td {
        padding: 1rem 1.4rem;
        border: none !important;
        vertical-align: middle;
        color: var(--kapture-text);
        font-size: 0.85rem;
        background: transparent !important;
    }

    /* ── Pagination ── */
    #users-table_wrapper .dataTables_paginate {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 1.25rem 1.4rem;
        border-top: 1px solid var(--kapture-border-subtle);
    }

    #users-table_wrapper .dataTables_paginate ul.pagination {
        margin: 0;
        display: flex;
        gap: 0.25rem;
    }

    #users-table_wrapper .dataTables_paginate .pagination .page-item .page-link,
    #users-table_wrapper .dataTables_paginate .paginate_button {
        background: transparent !important;
        border: 1px solid var(--kapture-border-subtle) !important;
        color: var(--kapture-muted) !important;
        font-family: 'Montserrat', sans-serif !important;
        font-size: 0.8rem !important;
        letter-spacing: 0.08em;
        padding: 0.55rem 1.1rem !important;
        border-radius: 0 !important;
        transition: all 0.2s;
        box-shadow: none !important;
    }

    #users-table_wrapper .dataTables_paginate .pagination .page-item .page-link:hover,
    #users-table_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent !important;
        border-color: var(--kapture-gold) !important;
        color: var(--kapture-gold) !important;
    }

    #users-table_wrapper .dataTables_paginate .pagination .page-item.active .page-link,
    #users-table_wrapper .dataTables_paginate .paginate_button.current,
    #users-table_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--kapture-gold) !important;
        border-color: var(--kapture-gold) !important;
        color: var(--kapture-black) !important;
        font-weight: 600 !important;
        font-size: 0.72rem !important;
        padding: 0.35rem 0.75rem !important;
    }

    #users-table_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link,
    #users-table_wrapper .dataTables_paginate .paginate_button.disabled,
    #users-table_wrapper .dataTables_paginate .paginate_button.disabled:hover {
        opacity: 0.3 !important;
        background: transparent !important;
        border-color: var(--kapture-border-subtle) !important;
        color: var(--kapture-muted) !important;
    }

    /* Move prev/next to the right */
    #users-table_wrapper .dataTables_paginate .kap-prev-next {
        display: flex;
        gap: 0.5rem;
    }
</style>

@include('layouts.flash-messages')

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow">
            <span>User Management</span>
        </div>
        <h1 class="page-title">Users</h1>
        <p class="page-subtitle">Registered Accounts — Administration</p>
    </div>

    {{-- Toolbar — same layout as items --}}
    <div class="kapture-toolbar">
        <a href="{{ route('users.create') }}" class="btn-kap-add">
            <i class="bi bi-plus"></i> New User
        </a>

        {{-- Custom search input that feeds into DataTable --}}
        <div class="kapture-search-wrap">
            <input type="text" id="userSearch" class="kapture-search" placeholder="Search users...">
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>

    <div class="kapture-table-wrap">
        {{ $dataTable->table(['class' => '']) }}
    </div>

</div>

@push('scripts')
    {{ $dataTable->scripts() }}
    <script>
        $(document).ready(function () {
            var table = $('#users-table').DataTable();

            // Wire custom search input to DataTable search
            $('#userSearch').on('keyup', function () {
                table.search(this.value).draw();
            });

            // On every draw, move prev/next to the right
            $('#users-table').on('draw.dt', function () {
                var $pag  = $('#users-table_wrapper .dataTables_paginate');
                var $ul   = $pag.find('ul.pagination');
                var $prev = $ul.find('.previous').detach();
                var $next = $ul.find('.next').detach();

                $pag.find('.kap-prev-next').remove();
                var $navWrap = $('<span class="kap-prev-next"></span>');
                $navWrap.append($prev).append($next);
                $pag.append($navWrap);
            });

            // Trigger first draw to apply layout
            table.draw();
        });
    </script>
@endpush

@endsection