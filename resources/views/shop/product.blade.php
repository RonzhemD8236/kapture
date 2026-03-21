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
  .breadcrumb { padding:20px 80px; font-size:9px; letter-spacing:2px; color:var(--muted); display:flex; gap:10px; align-items:center; border-bottom:1px solid rgba(91,26,138,.1); }
  .breadcrumb a { color:var(--muted); text-decoration:none; }
  .breadcrumb a:hover { color:var(--silver); }
  .breadcrumb span { color:rgba(91,26,138,.5); }
  .product-layout { display:grid; grid-template-columns:1fr 1fr; gap:0; min-height:calc(100vh - 80px); }
  .product-images { padding:60px; background:linear-gradient(135deg,rgba(18,8,32,.8),rgba(4,3,10,.95)); border-right:1px solid rgba(91,26,138,.15); position:sticky; top:80px; height:calc(100vh - 80px); display:flex; flex-direction:column; }
  .main-image { flex:1; display:flex; align-items:center; justify-content:center; border:1px solid rgba(91,26,138,.2); background:linear-gradient(135deg,rgba(42,14,80,.2),rgba(4,3,10,.8)); margin-bottom:16px; position:relative; overflow:hidden; }
  .main-image::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 60% 60% at 50% 50%,rgba(91,26,138,.1),transparent); }
  .main-image img { width:100%; height:100%; object-fit:contain; position:relative; z-index:1; }
  .main-img-cam { width:160px; height:120px; position:relative; }
  .mc-body-lg { position:absolute; bottom:0; left:0; right:0; height:90px; border:2px solid rgba(147,51,234,.6); border-radius:14px; background:linear-gradient(135deg,rgba(42,14,80,.4),rgba(4,3,10,.7)); box-shadow:0 0 60px rgba(91,26,138,.25); }
  .mc-hump-lg { position:absolute; top:0; left:26px; width:46px; height:22px; border:2px solid rgba(147,51,234,.6); border-bottom:none; border-radius:8px 8px 0 0; background:rgba(42,14,80,.3); }
  .mc-lens-lg { position:absolute; width:54px; height:54px; border-radius:50%; border:2px solid rgba(147,51,234,.6); bottom:18px; left:53px; display:flex; align-items:center; justify-content:center; animation:lensGlow 3s ease-in-out infinite; }
  .mc-lens-lg-mid { width:36px; height:36px; border-radius:50%; border:1px solid rgba(147,51,234,.4); display:flex; align-items:center; justify-content:center; }
  .mc-lens-lg-inner { width:18px; height:18px; border-radius:50%; background:radial-gradient(circle,var(--purple-mid),var(--black)); border:1px solid rgba(147,51,234,.5); box-shadow:0 0 14px rgba(147,51,234,.8); }
  .mc-btn-lg { position:absolute; width:16px; height:16px; border-radius:50%; background:var(--gold); bottom:66px; right:20px; box-shadow:0 0 12px var(--gold); }
  @keyframes lensGlow { 0%,100%{box-shadow:0 0 40px rgba(147,51,234,.5)} 50%{box-shadow:0 0 80px rgba(147,51,234,.9),0 0 120px rgba(91,26,138,.4)} }
  .thumb-row { display:flex; gap:10px; flex-wrap:wrap; }
  .thumb { width:70px; height:60px; border:1px solid rgba(91,26,138,.2); background:linear-gradient(135deg,rgba(42,14,80,.3),rgba(4,3,10,.8)); cursor:pointer; display:flex; align-items:center; justify-content:center; transition:border-color .3s; overflow:hidden; }
  .thumb img { width:100%; height:100%; object-fit:cover; }
  .thumb.active,.thumb:hover { border-color:rgba(147,51,234,.5); }
  .product-info-panel { padding:60px; overflow-y:auto; }
  .product-brand { font-family:'Cinzel',serif; font-size:10px; letter-spacing:5px; color:var(--gold); margin-bottom:12px; }
  .product-title { font-family:'Cinzel',serif; font-size:clamp(28px,3.5vw,48px); font-weight:600; letter-spacing:3px; line-height:1.1; margin-bottom:10px; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .product-subtitle { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:18px; color:var(--silver); margin-bottom:28px; font-weight:300; }
  .stock-badge { display:inline-block; font-size:9px; letter-spacing:2px; padding:6px 14px; margin-bottom:20px; font-family:'Cinzel',serif; }
  .in-stock { border:1px solid rgba(52,211,153,.3); color:#34d399; background:rgba(52,211,153,.08); }
  .out-of-stock { border:1px solid rgba(239,68,68,.3); color:#ef4444; background:rgba(239,68,68,.08); }
  .product-price-main { font-family:'Cinzel',serif; font-size:36px; color:var(--gold); letter-spacing:2px; margin-bottom:8px; }
  .product-price-note { font-size:10px; color:var(--muted); letter-spacing:1px; margin-bottom:32px; }
  .cart-row { display:flex; gap:12px; align-items:stretch; margin-bottom:20px; }
  .qty-selector { display:flex; align-items:center; border:1px solid rgba(91,26,138,.3); }
  .qty-btn { width:42px; height:52px; background:transparent; border:none; color:var(--silver); font-size:18px; cursor:pointer; transition:all .3s; }
  .qty-btn:hover { background:rgba(91,26,138,.2); color:var(--white); }
  .qty-num { width:50px; text-align:center; background:transparent; border:none; color:var(--white); font-family:'Cinzel',serif; font-size:14px; }
  .add-to-cart { flex:1; font-family:'Cinzel',serif; font-size:11px; letter-spacing:5px; color:var(--white); border:1px solid rgba(147,51,234,.5); background:linear-gradient(135deg,rgba(91,26,138,.4),rgba(42,14,80,.8)); cursor:pointer; transition:all .4s; text-decoration:none; display:flex; align-items:center; justify-content:center; }
  .add-to-cart:hover { border-color:var(--purple-glow); letter-spacing:7px; color:var(--white); }
  .trust-badges { display:grid; grid-template-columns:1fr 1fr; gap:12px; margin-bottom:36px; }
  .trust-item { display:flex; align-items:center; gap:10px; padding:14px 16px; border:1px solid rgba(91,26,138,.15); background:rgba(18,8,32,.4); }
  .trust-icon { font-size:16px; }
  .trust-text { font-size:9px; letter-spacing:1px; color:var(--muted); line-height:1.6; font-weight:200; }
  .trust-text strong { color:var(--silver); display:block; letter-spacing:2px; font-weight:400; font-size:9px; font-family:'Cinzel',serif; }
  .tabs { border-top:1px solid rgba(91,26,138,.2); padding-top:36px; }
  .tab-nav { display:flex; gap:0; margin-bottom:32px; border-bottom:1px solid rgba(91,26,138,.2); flex-wrap:wrap; }
  .tab-btn { font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--muted); padding:14px 20px; background:transparent; border:none; border-bottom:2px solid transparent; cursor:pointer; transition:all .3s; margin-bottom:-1px; }
  .tab-btn.active { color:var(--gold); border-bottom-color:var(--gold); }
  .tab-btn:hover { color:var(--silver); }
  .tab-content { display:none; }
  .tab-content.active { display:block; }
  .specs-table { width:100%; border-collapse:collapse; }
  .specs-table tr { border-bottom:1px solid rgba(91,26,138,.1); }
  .specs-table td { padding:14px 0; font-size:11px; font-weight:200; }
  .specs-table td:first-child { color:var(--muted); letter-spacing:2px; font-size:10px; width:40%; }
  .specs-table td:last-child { color:var(--silver); }
  .desc-text { font-size:13px; color:var(--silver); line-height:2; font-weight:200; border-left:2px solid rgba(91,26,138,.4); padding-left:20px; }
  .review-item { padding:24px 0; border-bottom:1px solid rgba(91,26,138,.1); }
  .review-header { display:flex; justify-content:space-between; margin-bottom:8px; }
  .reviewer { font-family:'Cinzel',serif; font-size:11px; color:var(--white); }
  .review-date { font-size:10px; color:var(--muted); }
  .review-stars { color:var(--gold); font-size:12px; margin-bottom:8px; }
  .review-text { font-size:12px; color:var(--silver); line-height:2; font-weight:200; }
  .no-reviews { font-size:12px; color:var(--muted); letter-spacing:1px; padding:20px 0; }
  /* FOOTER */
  #kapture-footer { background:var(--deep); border-top:1px solid rgba(91,26,138,.25); }
  .footer-top { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 1.5fr; gap:60px; padding:80px; }
  .footer-logo { font-family:'Cinzel',serif; font-size:22px; letter-spacing:8px; color:var(--white); margin-bottom:12px; }
  .footer-tagline { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:14px; color:var(--silver); margin-bottom:20px; }
  .footer-address { font-size:11px; color:var(--muted); line-height:2; font-weight:200; }
  .footer-col { display:flex; flex-direction:column; gap:12px; }
  .footer-col-title { font-family:'Cinzel',serif; font-size:10px; letter-spacing:4px; color:var(--gold); margin-bottom:8px; }
  .footer-col a { font-size:11px; color:var(--muted); text-decoration:none; font-weight:200; transition:color .3s; }
  .footer-col a:hover { color:var(--silver); }
  .footer-newsletter-text { font-size:11px; color:var(--muted); line-height:1.8; margin-bottom:16px; font-weight:200; }
  .footer-newsletter { display:flex; }
  .footer-newsletter input { flex:1; background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); border-right:none; color:var(--white); padding:12px 16px; font-size:11px; font-family:'Montserrat',sans-serif; outline:none; }
  .footer-newsletter input::placeholder { color:var(--muted); }
  .footer-newsletter button { background:linear-gradient(135deg,rgba(91,26,138,.7),rgba(42,14,80,.9)); border:1px solid rgba(91,26,138,.3); color:var(--gold); padding:12px 18px; cursor:pointer; font-size:16px; transition:background .3s; }
  .footer-newsletter button:hover { background:rgba(91,26,138,.9); }
  .footer-bottom { padding:24px 80px; border-top:1px solid rgba(91,26,138,.15); display:flex; justify-content:space-between; align-items:center; }
  .footer-bottom span,.footer-bottom a { font-size:9px; letter-spacing:2px; color:var(--muted); text-decoration:none; font-weight:200; }
  .footer-bottom-links { display:flex; gap:32px; }
  .footer-bottom a:hover { color:var(--silver); }
</style>

<div class="page-wrap">

  <div class="breadcrumb">
    <a href="{{ url('/') }}">HOME</a>
    <span>›</span>
    <a href="{{ url('/') }}">SHOP</a>
    <span>›</span>
    <span style="color:var(--silver)">{{ strtoupper($item->title) }}</span>
  </div>

  <div class="product-layout">

    {{-- IMAGE PANEL --}}
    <div class="product-images">
      <div class="main-image">
        @if($item->img_path && $item->img_path !== 'default.jpg')
          <img src="{{ Storage::url($item->img_path) }}" alt="{{ $item->title }}" id="main-img">
        @else
          <div class="main-img-cam">
            <div class="mc-hump-lg"></div>
            <div class="mc-body-lg">
              <div class="mc-lens-lg">
                <div class="mc-lens-lg-mid"><div class="mc-lens-lg-inner"></div></div>
              </div>
              <div class="mc-btn-lg"></div>
            </div>
          </div>
        @endif
      </div>
      @if($item->images)
        <div class="thumb-row">
          @foreach(explode(',', $item->images) as $index => $img)
            <div class="thumb {{ $index === 0 ? 'active' : '' }}"
                 onclick="switchImage(this, '{{ Storage::url(trim($img)) }}')">
              <img src="{{ Storage::url(trim($img)) }}" alt="Image {{ $index + 1 }}">
            </div>
          @endforeach
        </div>
      @endif
    </div>

    {{-- INFO PANEL --}}
    <div class="product-info-panel">
      <div class="product-brand">{{ strtoupper($item->category) }}</div>
      <h1 class="product-title">{{ $item->title }}</h1>
      <p class="product-subtitle">{{ Str::limit($item->description, 80) }}</p>

      @if(isset($item->quantity))
        @if($item->quantity > 0)
          <span class="stock-badge in-stock">IN STOCK — {{ $item->quantity }} AVAILABLE</span>
        @else
          <span class="stock-badge out-of-stock">OUT OF STOCK</span>
        @endif
      @endif

      <div class="product-price-main">₱ {{ number_format($item->sell_price, 2) }}</div>
      <p class="product-price-note">INCLUSIVE OF VAT · FREE SHIPPING NATIONWIDE</p>

      <div class="cart-row">
        <div class="qty-selector">
          <button class="qty-btn" onclick="changeQty(-1)">−</button>
          <input class="qty-num" type="text" value="1" id="qty" readonly>
          <button class="qty-btn" onclick="changeQty(1)">+</button>
        </div>
        <a href="{{ route('addToCart', $item->item_id) }}" class="add-to-cart">ADD TO CART</a>
      </div>

      <div class="trust-badges">
        <div class="trust-item"><span class="trust-icon">🛡</span><div class="trust-text"><strong>2-YEAR WARRANTY</strong>Full Kapture coverage.</div></div>
        <div class="trust-item"><span class="trust-icon">✈</span><div class="trust-text"><strong>FREE SHIPPING</strong>Nationwide, fully insured.</div></div>
        <div class="trust-item"><span class="trust-icon">↩</span><div class="trust-text"><strong>14-DAY RETURNS</strong>No questions asked.</div></div>
        <div class="trust-item"><span class="trust-icon">⚙</span><div class="trust-text"><strong>FREE CLA</strong>Lifetime sensor cleaning.</div></div>
      </div>

      <div class="tabs">
        <div class="tab-nav">
          <button class="tab-btn active" onclick="switchTab(this,'specs')">SPECIFICATIONS</button>
          <button class="tab-btn" onclick="switchTab(this,'description')">DESCRIPTION</button>
          <button class="tab-btn" onclick="switchTab(this,'reviews')">REVIEWS</button>
          <button class="tab-btn" onclick="switchTab(this,'shipping')">SHIPPING & RETURNS</button>
        </div>

        {{-- SPECIFICATIONS --}}
        <div class="tab-content active" id="tab-specs">
          <table class="specs-table">
            <tr><td>TITLE</td><td>{{ $item->title }}</td></tr>
            <tr><td>CATEGORY</td><td>{{ $item->category }}</td></tr>
            <tr><td>SELL PRICE</td><td>₱ {{ number_format($item->sell_price, 2) }}</td></tr>
            @if(isset($item->quantity))
            <tr><td>STOCK</td><td>{{ $item->quantity }} units</td></tr>
            @endif
            <tr><td>ADDED</td><td>{{ \Carbon\Carbon::parse($item->created_at)->format('F d, Y') }}</td></tr>
          </table>
        </div>

        {{-- DESCRIPTION --}}
        <div class="tab-content" id="tab-description">
          <p class="desc-text">{{ $item->description }}</p>
        </div>

        {{-- REVIEWS --}}
        <div class="tab-content" id="tab-reviews">
          @if(isset($reviews) && count($reviews) > 0)
            @foreach($reviews as $review)
              <div class="review-item">
                <div class="review-header">
                  <span class="reviewer">{{ strtoupper($review->user_name ?? 'ANONYMOUS') }}</span>
                  <span class="review-date">{{ \Carbon\Carbon::parse($review->created_at)->format('F Y') }}</span>
                </div>
                <div class="review-stars">
                  @for($i = 1; $i <= 5; $i++){{ $i <= $review->rating ? '★' : '☆' }}@endfor
                </div>
                <p class="review-text">{{ $review->comment }}</p>
              </div>
            @endforeach
          @else
            <p class="no-reviews">NO REVIEWS YET — BE THE FIRST TO REVIEW THIS PRODUCT.</p>
          @endif
        </div>

        {{-- SHIPPING --}}
        <div class="tab-content" id="tab-shipping">
          <table class="specs-table">
            <tr><td>METRO MANILA</td><td>Free — 1 to 2 business days, fully insured</td></tr>
            <tr><td>NATIONWIDE</td><td>Free — 3 to 5 business days, fully insured</td></tr>
            <tr><td>INTERNATIONAL</td><td>Available on request — contact our atelier</td></tr>
            <tr><td>RETURN WINDOW</td><td>14 days from delivery</td></tr>
            <tr><td>RETURN CONDITION</td><td>Unused, in original packaging</td></tr>
            <tr><td>EXCHANGE</td><td>In-store exchange available same-day</td></tr>
          </table>
        </div>

      </div>
    </div>
  </div>
</div>

{{-- FOOTER --}}
<footer id="kapture-footer">
  <div class="footer-top">
    <div class="footer-brand">
      <div class="footer-logo">KAPTURE</div>
      <p class="footer-tagline">Where Vision Meets Precision</p>
      <p class="footer-address">The Kapture Atelier<br>Ground Floor, One McKinley Place<br>Bonifacio Global City, Manila<br>Open Mon–Sat, 10am–8pm</p>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">SHOP</div>
      <a href="{{ url('/') }}">All Products</a>
      <a href="{{ url('/?category[]=Mirrorless') }}">Mirrorless</a>
      <a href="{{ url('/?category[]=Lenses') }}">Lenses</a>
      <a href="{{ url('/?category[]=Accessories') }}">Accessories</a>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">SERVICES</div>
      <a href="#">Repair & CLA</a>
      <a href="#">Sensor Cleaning</a>
      <a href="#">Rentals</a>
      <a href="#">Trade-In</a>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">COMPANY</div>
      <a href="#">Our Story</a>
      <a href="#">Contact</a>
      <a href="#">Membership</a>
      <a href="#">Workshops</a>
      <a href="#">Careers</a>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">JOIN THE ATELIER</div>
      <p class="footer-newsletter-text">Get early access to new arrivals and exclusive member events.</p>
      <div class="footer-newsletter">
        <input type="email" placeholder="your@email.com">
        <button>→</button>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} KAPTURE ATELIER — ALL RIGHTS RESERVED</span>
    <div class="footer-bottom-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Shipping & Returns</a>
    </div>
  </div>
</footer>

<script>
  function switchTab(btn, id) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    document.querySelectorAll('.tab-content').forEach(t => t.classList.remove('active'));
    btn.classList.add('active');
    document.getElementById('tab-' + id).classList.add('active');
  }
  function changeQty(delta) {
    const input = document.getElementById('qty');
    input.value = Math.max(1, parseInt(input.value) + delta);
  }
  function switchImage(thumb, url) {
    document.querySelectorAll('.thumb').forEach(t => t.classList.remove('active'));
    thumb.classList.add('active');
    const img = document.getElementById('main-img');
    if (img) img.src = url;
  }
</script>
@endsection