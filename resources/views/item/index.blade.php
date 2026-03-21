@extends('layouts.admin-base')

@section('body')

<style>
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

    .kapture-page { background: var(--kapture-black); min-height: 100vh; font-family: 'Montserrat', sans-serif; color: var(--kapture-text); padding: 3rem 2.5rem; }

    .page-header { margin-bottom: 3rem; border-bottom: 1px solid var(--kapture-border); padding-bottom: 2rem; }
    .page-eyebrow { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .page-eyebrow::before, .page-eyebrow::after { content: ''; flex: 0 0 40px; height: 1px; background: var(--kapture-gold); }
    .page-eyebrow span { font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 3.2rem; font-weight: 300; color: #fff; letter-spacing: 0.02em; line-height: 1.1; margin: 0; }
    .page-subtitle { font-size: 0.9rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--kapture-muted); margin-top: 0.5rem; font-style: italic; }

    .kapture-toolbar { display: flex; align-items: center; gap: 1rem; flex-wrap: wrap; margin-bottom: 2rem; }

    .btn-kapture-primary { background: transparent; border: 1px solid var(--kapture-gold); color: var(--kapture-gold); font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; padding: 0.7rem 1.6rem; text-decoration: none; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; }
    .btn-kapture-primary:hover { background: var(--kapture-gold); color: var(--kapture-black); text-decoration: none; }

    .btn-kapture-secondary { background: transparent; border: 1px solid var(--kapture-border-subtle); color: var(--kapture-lilac); font-family: 'Montserrat', sans-serif; font-size: 0.8rem; font-weight: 500; letter-spacing: 0.15em; text-transform: uppercase; padding: 0.7rem 1.6rem; cursor: pointer; transition: all 0.3s; display: inline-flex; align-items: center; gap: 0.5rem; text-decoration: none; }
    .btn-kapture-secondary:hover { border-color: var(--kapture-lilac); color: #fff; text-decoration: none; }

    .kapture-file-input { background: transparent; border: 1px solid var(--kapture-border-subtle); color: var(--kapture-text); font-family: 'Montserrat', sans-serif; font-size: 0.85rem; padding: 0.65rem 0.75rem; width: auto; }
    .kapture-file-input:focus { outline: none; border-color: var(--kapture-gold); box-shadow: none; background: transparent; }

    .toolbar-divider { width: 1px; height: 36px; background: var(--kapture-border-subtle); }

    .kapture-search-wrap { position: relative; margin-left: auto; }
    .kapture-search { background: transparent; border: none; border-bottom: 1px solid var(--kapture-border-subtle); color: var(--kapture-text); font-family: 'Montserrat', sans-serif; font-size: 0.85rem; letter-spacing: 0.08em; padding: 0.5rem 2rem 0.5rem 0; width: 240px; transition: border-color 0.3s; }
    .kapture-search::placeholder { color: var(--kapture-muted); font-style: italic; }
    .kapture-search:focus { outline: none; border-bottom-color: var(--kapture-gold); box-shadow: none; background: transparent; }
    .search-icon { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: var(--kapture-muted); font-size: 0.95rem; pointer-events: none; }

    .kapture-table-wrap { border: 1px solid var(--kapture-border-subtle); overflow: hidden; }

    /* DataTable overrides */
    #items-table_wrapper .dataTables_length,
    #items-table_wrapper .dataTables_filter,
    #items-table_wrapper .dataTables_info { display: none !important; }

    table#items-table { width: 100% !important; border-collapse: collapse; margin: 0 !important; }
    table#items-table thead tr { background: rgba(201,168,76,0.04); border-bottom: 1px solid var(--kapture-border); }
    table#items-table thead th { font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 500; letter-spacing: 0.18em; text-transform: uppercase; color: var(--kapture-gold) !important; padding: 1.1rem 1.4rem; border: none !important; background: transparent !important; white-space: nowrap; }
    table#items-table tbody tr { border-bottom: 1px solid var(--kapture-border-subtle); transition: background 0.2s; }
    table#items-table tbody tr:last-child { border-bottom: none; }
    table#items-table tbody tr:hover { background: rgba(168,155,194,0.05) !important; }
    table#items-table tbody td { padding: 1.1rem 1.4rem; border: none !important; vertical-align: middle; color: var(--kapture-text); font-size: 0.9rem; background: transparent !important; }

    /* Pagination */
    #items-table_wrapper .dataTables_paginate { display: flex !important; align-items: center !important; justify-content: space-between !important; padding: 1.25rem 1.4rem; border-top: 1px solid var(--kapture-border-subtle); }
    #items-table_wrapper .dataTables_paginate ul.pagination { margin: 0; display: flex; gap: 0.25rem; }
    #items-table_wrapper .dataTables_paginate .paginate_button { background: transparent !important; border: 1px solid var(--kapture-border-subtle) !important; color: var(--kapture-muted) !important; font-family: 'Montserrat', sans-serif !important; font-size: 0.8rem !important; padding: 0.55rem 1.1rem !important; border-radius: 0 !important; transition: all 0.2s; box-shadow: none !important; }
    #items-table_wrapper .dataTables_paginate .paginate_button:hover { background: transparent !important; border-color: var(--kapture-gold) !important; color: var(--kapture-gold) !important; }
    #items-table_wrapper .dataTables_paginate .paginate_button.current,
    #items-table_wrapper .dataTables_paginate .paginate_button.current:hover { background: var(--kapture-gold) !important; border-color: var(--kapture-gold) !important; color: var(--kapture-black) !important; font-weight: 600 !important; }
    #items-table_wrapper .dataTables_paginate .paginate_button.disabled,
    #items-table_wrapper .dataTables_paginate .paginate_button.disabled:hover { opacity: 0.3 !important; background: transparent !important; }
    #items-table_wrapper .dataTables_paginate .kap-prev-next { display: flex; gap: 0.5rem; }

    /* Override Bootstrap pagination to Kapture gold */
    #items-table_wrapper .dataTables_paginate .pagination .page-item .page-link {
        background: transparent !important;
        border: 1px solid var(--kapture-border-subtle) !important;
        color: var(--kapture-muted) !important;
        font-family: 'Montserrat', sans-serif !important;
        font-size: 0.7rem !important;
        padding: 0.35rem 0.7rem !important;
        border-radius: 0 !important;
        box-shadow: none !important;
        transition: all 0.2s;
    }
    #items-table_wrapper .dataTables_paginate .pagination .page-item .page-link:hover {
        background: transparent !important;
        border-color: var(--kapture-gold) !important;
        color: var(--kapture-gold) !important;
    }
    #items-table_wrapper .dataTables_paginate .pagination .page-item.active .page-link {
        background: var(--kapture-gold) !important;
        border-color: var(--kapture-gold) !important;
        color: var(--kapture-black) !important;
        font-weight: 600 !important;
        font-size: 0.7rem !important;
        padding: 0.35rem 0.7rem !important;
    }
    #items-table_wrapper .dataTables_paginate .pagination .page-item.disabled .page-link {
        opacity: 0.3 !important;
        background: transparent !important;
        border-color: var(--kapture-border-subtle) !important;
        color: var(--kapture-muted) !important;
    }

    .action-wrap { display: flex; align-items: center; gap: 0.5rem; }
    .btn-action-edit { background: transparent; border: 1px solid var(--kapture-border-subtle); color: var(--kapture-lilac); width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; transition: all 0.2s; text-decoration: none; }
    .btn-action-edit:hover { border-color: var(--kapture-lilac); color: #fff; background: rgba(168,155,194,0.1); text-decoration: none; }
    .btn-action-delete { background: transparent; border: 1px solid rgba(192,96,96,0.3); color: #c06060; width: 36px; height: 36px; display: inline-flex; align-items: center; justify-content: center; font-size: 0.85rem; transition: all 0.2s; cursor: pointer; }
    .btn-action-delete:hover { border-color: #c06060; background: rgba(192,96,96,0.1); color: #e08080; }
</style>

@include('layouts.flash-messages')

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow"><span>Inventory Management</span></div>
        <h1 class="page-title">Collection Items</h1>
        <p class="page-subtitle">Fine Photographic Instruments — Catalogue</p>
    </div>

    <div class="kapture-toolbar">
        <a href="{{ route('items.create') }}" class="btn-kapture-primary">
            <i class="bi bi-plus"></i> Add Item
        </a>
        <a href="{{ route('items.trash') }}" class="btn-kapture-secondary">
            <i class="bi bi-trash"></i> Trash
        </a>
        <div class="toolbar-divider"></div>
        <form action="{{ route('item.import') }}" method="POST" enctype="multipart/form-data"
              class="d-inline-flex align-items-center gap-2">
            @csrf
            <input type="file" name="file" class="kapture-file-input form-control">
            <button type="submit" class="btn-kapture-secondary">
                <i class="bi bi-file-earmark-spreadsheet"></i> Import
            </button>
        </form>
        <div class="kapture-search-wrap">
            <input type="text" id="itemSearch" placeholder="Search items..." class="kapture-search">
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>

    <div class="kapture-table-wrap">
        {{ $dataTable->table(['id' => 'items-table', 'class' => '']) }}
    </div>

</div>

@push('scripts')
{{ $dataTable->scripts() }}
<script>
    $(document).ready(function () {
        var table = $('#items-table').DataTable();

        $('#itemSearch').on('keyup', function () {
            table.search(this.value).draw();
        });

        $('#items-table').on('draw.dt', function () {
            var $pag  = $('#items-table_wrapper .dataTables_paginate');
            var $ul   = $pag.find('ul.pagination');
            var $prev = $ul.find('.previous').detach();
            var $next = $ul.find('.next').detach();
            $pag.find('.kap-prev-next').remove();
            $('<span class="kap-prev-next"></span>').append($prev).append($next).appendTo($pag);
        });

        table.draw();
    });
</script>
@endpush

@endsection