@extends('layouts.customer')

@section('content')
<style>
  :root {
    --black:#04030a; --deep:#080612; --purple-mid:#2a0e50;
    --purple:#5b1a8a; --purple-light:#9333ea; --purple-glow:#c084fc;
    --gold:#c9a84c; --gold-light:#e6c87a; --white:#ede8f5;
    --silver:#b8aece; --muted:#6b5f7c;
  }

  .page-wrap { padding-top:80px; min-height:100vh; }

  /* BREADCRUMB */
  .breadcrumb { padding:20px 80px; font-size:10px; letter-spacing:2px; color:var(--muted); display:flex; gap:12px; align-items:center; border-bottom:1px solid rgba(91,26,138,.1); }
  .breadcrumb a { color:var(--muted); text-decoration:none; }
  .breadcrumb a:hover { color:var(--silver); }
  .breadcrumb span { color:rgba(91,26,138,.5); }

  /* PAGE BANNER */
  .page-banner { padding:60px 80px 40px; position:relative; overflow:hidden; border-bottom:1px solid rgba(91,26,138,.2); }
  .page-banner::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 80% 100% at 20% 50%,rgba(42,14,80,.5) 0%,transparent 70%); }
  .page-banner-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:14px; margin-bottom:16px; position:relative; }
  .page-banner-label::before { content:''; width:36px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .page-banner-title { font-family:'Cinzel',serif; font-size:clamp(32px,4vw,56px); font-weight:600; position:relative; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .page-banner-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:16px; color:var(--silver); margin-top:10px; font-weight:300; position:relative; }

  /* SEARCH BAR */
  .search-wrap { padding:24px 80px; border-bottom:1px solid rgba(91,26,138,.1); }
  .search-form { display:flex; gap:0; max-width:600px; }
  .search-input { flex:1; background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); border-right:none; color:var(--white); padding:14px 20px; font-family:'Montserrat',sans-serif; font-size:11px; letter-spacing:1px; outline:none; }
  .search-input::placeholder { color:var(--muted); }
  .search-input:focus { border-color:rgba(147,51,234,.6); }
  .search-btn { background:linear-gradient(135deg,rgba(91,26,138,.7),rgba(42,14,80,.9)); border:1px solid rgba(91,26,138,.3); color:var(--gold); padding:14px 24px; cursor:pointer; font-family:'Cinzel',serif; font-size:10px; letter-spacing:3px; transition:background .3s; white-space:nowrap; }
  .search-btn:hover { background:rgba(91,26,138,.9); }

  /* SHOP LAYOUT */
  .shop-layout { display:grid; grid-template-columns:260px 1fr; gap:0; }

  /* SIDEBAR */
  .sidebar { padding:36px 28px; border-right:1px solid rgba(91,26,138,.15); background:rgba(8,6,18,.6); position:sticky; top:80px; height:calc(100vh - 80px); overflow-y:auto; }
  .sidebar::-webkit-scrollbar { width:4px; }
  .sidebar::-webkit-scrollbar-thumb { background:rgba(91,26,138,.4); border-radius:2px; }
  .filter-group { margin-bottom:32px; }
  .filter-title { font-family:'Cinzel',serif; font-size:10px; letter-spacing:4px; color:var(--gold); margin-bottom:14px; padding-bottom:10px; border-bottom:1px solid rgba(91,26,138,.2); }
  .filter-option { display:flex; align-items:center; gap:10px; margin-bottom:10px; cursor:pointer; }
  .filter-option input[type=checkbox] { appearance:none; width:14px; height:14px; border:1px solid rgba(147,51,234,.4); background:transparent; cursor:pointer; position:relative; flex-shrink:0; }
  .filter-option input[type=checkbox]:checked { background:rgba(91,26,138,.6); border-color:var(--purple-light); }
  .filter-option input[type=checkbox]:checked::after { content:'✓'; position:absolute; top:-1px; left:2px; font-size:10px; color:var(--purple-glow); }
  .filter-option label { font-size:11px; color:var(--silver); font-weight:200; cursor:pointer; letter-spacing:.5px; display:flex; justify-content:space-between; width:100%; }
  .price-range { display:flex; gap:8px; align-items:center; }
  .price-input { background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); color:var(--white); padding:10px 12px; font-size:10px; font-family:'Montserrat',sans-serif; width:100%; outline:none; }
  .price-input::placeholder { color:var(--muted); }
  .price-sep { color:var(--muted); font-size:10px; }
  .apply-btn { font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--white); padding:12px; border:1px solid rgba(147,51,234,.4); background:linear-gradient(135deg,rgba(42,14,80,.5),rgba(4,3,10,.9)); cursor:pointer; width:100%; margin-top:8px; transition:all .3s; }
  .apply-btn:hover { border-color:var(--purple-glow); }

  /* PRODUCTS AREA */
  .products-area { padding:32px 48px; }
  .products-toolbar { display:flex; align-items:center; justify-content:space-between; margin-bottom:28px; padding-bottom:16px; border-bottom:1px solid rgba(91,26,138,.15); }
  .products-count { font-size:11px; color:var(--muted); font-weight:200; letter-spacing:1px; }
  .products-count strong { color:var(--silver); }
  .sort-select { background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); color:var(--silver); padding:10px 16px; font-size:10px; font-family:'Cinzel',serif; letter-spacing:2px; outline:none; cursor:pointer; }
  .sort-select option { background:var(--deep); }

  /* ACTIVE FILTERS */
  .active-filters { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:20px; }
  .filter-tag { font-size:9px; letter-spacing:2px; color:var(--silver); border:1px solid rgba(91,26,138,.3); padding:6px 12px; display:flex; align-items:center; gap:8px; }
  .filter-tag a { color:var(--muted); text-decoration:none; font-size:12px; }
  .filter-tag a:hover { color:var(--purple-glow); }

  /* PRODUCT GRID */
  .product-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:2px; }
  .product-card { background:linear-gradient(135deg,rgba(18,8,32,.9),rgba(4,3,10,.95)); border:1px solid rgba(91,26,138,.15); position:relative; overflow:hidden; transition:border-color .4s,transform .3s; }
  .product-card:hover { border-color:rgba(147,51,234,.45); transform:translateY(-3px); }
  .product-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,.4),transparent); transform:scaleX(0); transition:transform .5s; }
  .product-card:hover::before { transform:scaleX(1); }

  .product-img { height:200px; background:linear-gradient(135deg,rgba(42,14,80,.3),rgba(8,6,18,.8)); display:flex; align-items:center; justify-content:center; position:relative; overflow:hidden; }
  .product-img img { width:100%; height:100%; object-fit:cover; }
  .product-img-placeholder { text-align:center; }
  .product-img-icon { width:70px; height:52px; position:relative; margin:0 auto 10px; }
  .pic-body { position:absolute; bottom:0; left:0; right:0; height:38px; border:1px solid rgba(147,51,234,.5); border-radius:6px; }
  .pic-hump { position:absolute; top:0; left:12px; width:22px; height:12px; border:1px solid rgba(147,51,234,.5); border-bottom:none; border-radius:4px 4px 0 0; }
  .pic-lens { position:absolute; width:22px; height:22px; border-radius:50%; border:1px solid rgba(147,51,234,.5); bottom:8px; left:24px; display:flex; align-items:center; justify-content:center; }
  .pic-lens::after { content:''; width:10px; height:10px; border-radius:50%; background:radial-gradient(circle,rgba(91,26,138,.8),rgba(4,3,10,1)); }

  .product-info { padding:20px 18px; }
  .product-cat { font-size:8px; letter-spacing:3px; color:var(--muted); margin-bottom:6px; font-weight:300; }
  .product-name { font-family:'Cinzel',serif; font-size:14px; letter-spacing:1px; color:var(--white); margin-bottom:4px; }
  .product-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:12px; color:var(--silver); margin-bottom:14px; }
  .product-footer { display:flex; align-items:center; justify-content:space-between; }
  .product-price { font-family:'Cinzel',serif; font-size:15px; color:var(--gold); letter-spacing:1px; }
  .product-add { font-size:9px; letter-spacing:2px; color:var(--purple-glow); border:1px solid rgba(147,51,234,.3); padding:8px 14px; background:transparent; cursor:pointer; font-family:'Cinzel',serif; transition:all .3s; text-decoration:none; display:inline-block; }
  .product-add:hover { border-color:var(--purple-glow); background:rgba(91,26,138,.2); color:var(--purple-glow); }

  /* NO RESULTS */
  .no-results { text-align:center; padding:80px 20px; color:var(--muted); }
  .no-results-title { font-family:'Cinzel',serif; font-size:20px; color:var(--silver); margin-bottom:12px; }
</style>

<div class="page-wrap">

  {{-- BREADCRUMB --}}
  <div class="breadcrumb">
    <a href="{{ url('/') }}">HOME</a>
    <span>›</span>
    <span style="color:var(--silver)">SHOP</span>
  </div>

  {{-- PAGE BANNER --}}
  <div class="page-banner">
    <div class="page-banner-label">THE COLLECTION</div>
    <div class="page-banner-title">All Products</div>
    <p class="page-banner-sub">Over 600 instruments, curated for the discerning eye.</p>
  </div>

  {{-- SEARCH BAR --}}
  <div class="search-wrap">
    <form action="{{ url('/') }}" method="GET" class="search-form">
      <input
        class="search-input"
        type="text"
        name="search"
        placeholder="SEARCH PRODUCTS..."
        value="{{ request('search') }}"
      >
      <button type="submit" class="search-btn">SEARCH</button>
    </form>
  </div>

  <div class="shop-layout">

    {{-- SIDEBAR FILTERS --}}
    <aside class="sidebar">
      <form action="{{ url('/') }}" method="GET" id="filter-form">
        {{-- keep search query when filtering --}}
        @if(request('search'))
          <input type="hidden" name="search" value="{{ request('search') }}">
        @endif

        {{-- CATEGORY --}}
        <div class="filter-group">
          <div class="filter-title">CATEGORY</div>
          @foreach($categories as $cat)
            <div class="filter-option">
              <input type="checkbox" id="cat_{{ $loop->index }}" name="category[]" value="{{ $cat }}"
                {{ in_array($cat, (array) request('category', [])) ? 'checked' : '' }}>
              <label for="cat_{{ $loop->index }}">{{ $cat }}</label>
            </div>
          @endforeach
        </div>

        {{-- PRICE RANGE --}}
        <div class="filter-group">
          <div class="filter-title">PRICE RANGE (₱)</div>
          <div class="price-range">
            <input class="price-input" type="number" name="min_price" placeholder="Min" value="{{ request('min_price') }}">
            <span class="price-sep">—</span>
            <input class="price-input" type="number" name="max_price" placeholder="Max" value="{{ request('max_price') }}">
          </div>
        </div>

        <button type="submit" class="apply-btn">APPLY FILTERS</button>
      </form>
    </aside>

    {{-- PRODUCTS AREA --}}
    <div class="products-area">

      {{-- ACTIVE FILTER TAGS --}}
      @if(request()->hasAny(['search','category','min_price','max_price']))
        <div class="active-filters">
          @if(request('search'))
            <div class="filter-tag">
              "{{ request('search') }}"
              <a href="{{ url('/') }}">×</a>
            </div>
          @endif
          @foreach((array) request('category', []) as $cat)
            <div class="filter-tag">
              {{ strtoupper($cat) }}
              <a href="{{ request()->fullUrlWithoutQuery(['category']) }}">×</a>
            </div>
          @endforeach
          @if(request('min_price') || request('max_price'))
            <div class="filter-tag">
              ₱{{ request('min_price', '0') }} — ₱{{ request('max_price', '∞') }}
              <a href="{{ request()->fullUrlWithoutQuery(['min_price','max_price']) }}">×</a>
            </div>
          @endif
        </div>
      @endif

      {{-- TOOLBAR --}}
      <div class="products-toolbar">
        <p class="products-count">
          Showing <strong>{{ $items->count() }}</strong>
          @if($items instanceof \Illuminate\Pagination\LengthAwarePaginator)
            of {{ $items->total() }}
          @endif
          products
        </p>
        <select class="sort-select" onchange="this.form && this.form.submit()" form="filter-form" name="sort">
          <option value="featured" {{ request('sort') == 'featured' ? 'selected' : '' }}>SORT: FEATURED</option>
          <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>PRICE: LOW TO HIGH</option>
          <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>PRICE: HIGH TO LOW</option>
          <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>NEWEST FIRST</option>
        </select>
      </div>

        {{-- PRODUCT GRID --}}
        @if($items->count() > 0)
        <div class="product-grid">
            @foreach($items as $item)
            @php $productUrl = route('product.show', $item->item_id); @endphp
                <div class="product-card" onclick="window.location='{{ $productUrl }}'">
                <div class="product-img">
                @if($item->img_path && $item->img_path !== 'default.jpg')
                    <img src="{{ Storage::url($item->img_path) }}" alt="{{ $item->title }}">
                @else
                    <div class="product-img-placeholder">
                    <div class="product-img-icon">
                        <div class="pic-hump"></div>
                        <div class="pic-body"><div class="pic-lens"></div></div>
                    </div>
                    </div>
                @endif
                </div>
                <div class="product-info">
                <div class="product-cat">{{ strtoupper($item->category) }}</div>
                <div class="product-name">{{ $item->title }}</div>
                <div class="product-sub">{{ Str::limit($item->description, 50) }}</div>
                <div class="product-footer">
                    <span class="product-price">₱ {{ number_format($item->sell_price, 2) }}</span>
                    <a href="{{ route('product.show', $item->item_id) }}" class="product-add">VIEW</a>
                </div>
                </div>
            </div>
            @endforeach
        </div>

        {{-- PAGINATION --}}
        <div style="margin-top:40px; display:flex; justify-content:center;">
          {{ $items->withQueryString()->links() }}
        </div>

      @else
        <div class="no-results">
          <div class="no-results-title">NO PRODUCTS FOUND</div>
          <p style="font-size:11px; letter-spacing:1px;">Try adjusting your filters or search term.</p>
        </div>
      @endif

    </div>
  </div>
</div>
@endsection