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
    .kapture-toolbar {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-bottom: 2rem;
    }
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
    .kapture-search::placeholder { color: var(--kapture-muted); font-style: italic; }
    .kapture-search:focus { outline: none; border-bottom-color: var(--kapture-gold); background: transparent; color: var(--kapture-text); }
    .search-icon { position: absolute; right: 0; top: 50%; transform: translateY(-50%); color: var(--kapture-muted); font-size: 0.95rem; pointer-events: none; }
    .kapture-table-wrap { border: 1px solid var(--kapture-border-subtle); overflow: hidden; }

    #reviews-table_wrapper .dataTables_length,
    #reviews-table_wrapper .dataTables_filter,
    #reviews-table_wrapper .dataTables_info { display: none !important; }

    table#reviews-table { width: 100% !important; border-collapse: collapse; margin: 0 !important; }
    table#reviews-table thead tr { background: rgba(201,168,76,.04); border-bottom: 1px solid var(--kapture-border); }
    table#reviews-table thead th {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem; font-weight: 500;
        letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--kapture-gold) !important;
        padding: 1.1rem 1.4rem;
        border: none !important; background: transparent !important;
        white-space: nowrap;
    }
    table#reviews-table tbody tr { border-bottom: 1px solid var(--kapture-border-subtle); transition: background .2s; }
    table#reviews-table tbody tr:last-child { border-bottom: none; }
    table#reviews-table tbody tr:hover { background: rgba(168,155,194,.05) !important; }
    table#reviews-table tbody td { padding: 1rem 1.4rem; border: none !important; vertical-align: middle; color: var(--kapture-text); font-size: 0.85rem; background: transparent !important; }

    .stars { color: var(--kapture-gold); letter-spacing: 2px; }

    .btn-delete {
        background: transparent;
        border: 1px solid #c06060;
        color: #c06060;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.72rem; font-weight: 500;
        letter-spacing: 0.12em; text-transform: uppercase;
        padding: 0.4rem 1rem;
        cursor: pointer; transition: all 0.3s;
    }
    .btn-delete:hover { background: #c06060; color: var(--kapture-black); }

    #reviews-table_wrapper .dataTables_paginate {
        display: flex !important; align-items: center !important;
        justify-content: space-between !important;
        padding: 1.25rem 1.4rem;
        border-top: 1px solid var(--kapture-border-subtle);
    }
    #reviews-table_wrapper .dataTables_paginate ul.pagination { margin: 0; display: flex; gap: 0.25rem; }
    #reviews-table_wrapper .dataTables_paginate .paginate_button {
        background: transparent !important;
        border: 1px solid var(--kapture-border-subtle) !important;
        color: var(--kapture-muted) !important;
        font-family: 'Montserrat', sans-serif !important;
        font-size: 0.8rem !important;
        letter-spacing: 0.08em;
        padding: 0.55rem 1.1rem !important;
        border-radius: 0 !important;
        transition: all 0.2s;
    }
    #reviews-table_wrapper .dataTables_paginate .paginate_button:hover {
        background: transparent !important;
        border-color: var(--kapture-gold) !important;
        color: var(--kapture-gold) !important;
    }
    #reviews-table_wrapper .dataTables_paginate .paginate_button.current,
    #reviews-table_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: var(--kapture-gold) !important;
        border-color: var(--kapture-gold) !important;
        color: var(--kapture-black) !important;
        font-weight: 600 !important;
    }
    #reviews-table_wrapper .dataTables_paginate .kap-prev-next { display: flex; gap: 0.5rem; }
</style>

@include('layouts.flash-messages')

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow">
            <span>Review Management</span>
        </div>
        <h1 class="page-title">Reviews</h1>
        <p class="page-subtitle">Customer Reviews — Administration</p>
    </div>

    <div class="kapture-toolbar">
        <div class="kapture-search-wrap">
            <input type="text" id="reviewSearch" class="kapture-search" placeholder="Search reviews...">
            <i class="bi bi-search search-icon"></i>
        </div>
    </div>

    <div class="kapture-table-wrap">
        <table id="reviews-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>CUSTOMER</th>
                    <th>PRODUCT</th>
                    <th>RATING</th>
                    <th>COMMENT</th>
                    <th>DATE</th>
                    <th>ACTION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reviews as $review)
                <tr>
                    <td>{{ $review->review_id }}</td>
                    <td>{{ strtoupper($review->fname . ' ' . $review->lname) }}</td>
                    <td>{{ $review->item_title }}</td>
                    <td>
                        <span class="stars">
                            @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                        </span>
                    </td>
                    <td>{{ Str::limit($review->comment, 60) }}</td>
                    <td>{{ \Carbon\Carbon::parse($review->created_at)->format('M d, Y') }}</td>
                    <td>
                        <form action="{{ route('admin.reviews.destroy', $review->review_id) }}"
                              method="POST"
                              onsubmit="return confirm('Delete this review?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">DELETE</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@push('scripts')
<script>
    $(document).ready(function () {
        var table = $('#reviews-table').DataTable({
            pageLength: 10,
            order: [[5, 'desc']],
            columnDefs: [{ orderable: false, targets: 6 }]
        });

        $('#reviewSearch').on('keyup', function () {
            table.search(this.value).draw();
        });

        $('#reviews-table').on('draw.dt', function () {
            var $pag  = $('#reviews-table_wrapper .dataTables_paginate');
            var $ul   = $pag.find('ul.pagination');
            var $prev = $ul.find('.previous').detach();
            var $next = $ul.find('.next').detach();
            $pag.find('.kap-prev-next').remove();
            var $navWrap = $('<span class="kap-prev-next"></span>');
            $navWrap.append($prev).append($next);
            $pag.append($navWrap);
        });

        table.draw();
    });
</script>
@endpush

@endsection