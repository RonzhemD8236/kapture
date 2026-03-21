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
  .breadcrumb { padding:20px 80px; font-size:10px; letter-spacing:2px; color:var(--muted); display:flex; gap:12px; align-items:center; border-bottom:1px solid rgba(91,26,138,.1); }
  .breadcrumb a { color:var(--muted); text-decoration:none; }
  .breadcrumb a:hover { color:var(--silver); }
  .breadcrumb span { color:rgba(91,26,138,.5); }
  .page-banner { padding:50px 80px 30px; border-bottom:1px solid rgba(91,26,138,.2); position:relative; overflow:hidden; }
  .page-banner::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 80% 100% at 20% 50%,rgba(42,14,80,.4) 0%,transparent 70%); }
  .page-banner-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:14px; margin-bottom:14px; position:relative; }
  .page-banner-label::before { content:''; width:36px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .page-banner-title { font-family:'Cinzel',serif; font-size:clamp(28px,4vw,48px); font-weight:600; position:relative; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .page-banner-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:15px; color:var(--silver); margin-top:8px; font-weight:300; position:relative; }

  /* LAYOUT */
  .cart-layout { display:grid; grid-template-columns:1fr 380px; gap:2px; padding:60px 80px; }

  /* TABLE HEADER */
  .cart-header { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 40px; gap:20px; padding:0 0 16px; border-bottom:1px solid rgba(91,26,138,.2); margin-bottom:4px; }
  .cart-col-label { font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--muted); }

  /* CART ITEM ROW */
  .cart-item { display:grid; grid-template-columns:2fr 1fr 1fr 1fr 40px; gap:20px; align-items:center; padding:28px 0; border-bottom:1px solid rgba(91,26,138,.1); }
  .cart-item-info { display:flex; gap:20px; align-items:center; }
  .cart-item-img { width:80px; height:64px; border:1px solid rgba(91,26,138,.2); background:linear-gradient(135deg,rgba(42,14,80,.3),rgba(4,3,10,.8)); display:flex; align-items:center; justify-content:center; flex-shrink:0; overflow:hidden; }
  .cart-item-img img { width:100%; height:100%; object-fit:cover; }
  .cart-item-name { font-family:'Cinzel',serif; font-size:14px; color:var(--white); letter-spacing:1px; margin-bottom:4px; }
  .cart-item-remove { font-size:9px; letter-spacing:2px; color:var(--muted); text-decoration:none; transition:color .3s; display:inline-block; }
  .cart-item-remove:hover { color:var(--purple-glow); }
  .item-qty { display:flex; align-items:center; border:1px solid rgba(91,26,138,.3); width:fit-content; }
  .iq-btn { width:34px; height:36px; background:transparent; border:none; color:var(--silver); font-size:16px; cursor:pointer; transition:background .3s; text-decoration:none; display:flex; align-items:center; justify-content:center; }
  .iq-btn:hover { background:rgba(91,26,138,.2); color:var(--white); }
  .iq-num { width:40px; text-align:center; background:transparent; border:none; color:var(--white); font-family:'Cinzel',serif; font-size:12px; }
  .item-price { font-family:'Cinzel',serif; font-size:15px; color:var(--silver); }
  .item-total { font-family:'Cinzel',serif; font-size:15px; color:var(--gold); }
  .item-del { font-size:18px; color:var(--muted); cursor:pointer; transition:color .3s; text-decoration:none; display:flex; align-items:center; justify-content:center; }
  .item-del:hover { color:var(--purple-glow); }

  /* CART ACTIONS */
  .cart-actions { display:flex; justify-content:flex-end; padding-top:28px; }
  .continue-link { font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--white); padding:12px 24px; border:1px solid rgba(147,51,234,.3); background:transparent; text-decoration:none; transition:all .3s; }
  .continue-link:hover { border-color:var(--purple-glow); color:var(--purple-glow); }

  /* EMPTY CART */
  .cart-empty { text-align:center; padding:100px 40px; grid-column:1/-1; }
  .cart-empty-icon { font-size:48px; margin-bottom:20px; opacity:.3; }
  .cart-empty-text { font-family:'Cinzel',serif; font-size:18px; color:var(--muted); letter-spacing:3px; margin-bottom:8px; }
  .cart-empty-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:15px; color:var(--muted); margin-bottom:32px; }
  .btn-shop { font-family:'Cinzel',serif; font-size:10px; letter-spacing:4px; color:var(--white); padding:16px 40px; border:1px solid rgba(147,51,234,.4); background:linear-gradient(135deg,rgba(42,14,80,.5),rgba(4,3,10,.9)); text-decoration:none; display:inline-block; transition:all .3s; }
  .btn-shop:hover { border-color:var(--purple-glow); color:var(--white); }

  /* ORDER SUMMARY */
  .order-summary { background:linear-gradient(135deg,rgba(18,8,32,.95),rgba(4,3,10,1)); border:1px solid rgba(91,26,138,.2); padding:40px 36px; position:sticky; top:100px; align-self:start; }
  .summary-title { font-family:'Cinzel',serif; font-size:14px; letter-spacing:4px; color:var(--white); margin-bottom:32px; padding-bottom:16px; border-bottom:1px solid rgba(91,26,138,.2); }
  .summary-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:16px; }
  .summary-label { font-size:10px; letter-spacing:2px; color:var(--muted); font-weight:200; }
  .summary-val { font-size:12px; color:var(--silver); font-weight:300; }
  .summary-val.free { color:var(--purple-glow); }
  .summary-divider { height:1px; background:linear-gradient(90deg,transparent,rgba(91,26,138,.4),transparent); margin:20px 0; }
  .summary-total-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:32px; }
  .summary-total-label { font-family:'Cinzel',serif; font-size:12px; letter-spacing:3px; color:var(--gold); }
  .summary-total-val { font-family:'Cinzel',serif; font-size:24px; color:var(--gold); }
  .checkout-btn { width:100%; font-family:'Cinzel',serif; font-size:11px; letter-spacing:5px; color:var(--white); padding:20px; border:1px solid rgba(147,51,234,.5); background:linear-gradient(135deg,rgba(91,26,138,.5),rgba(42,14,80,.9)); cursor:pointer; transition:all .4s; margin-bottom:14px; text-decoration:none; display:block; text-align:center; }
  .checkout-btn:hover { border-color:var(--purple-glow); letter-spacing:7px; color:var(--white); }
  .summary-note { font-size:9px; letter-spacing:1px; color:var(--muted); text-align:center; line-height:1.8; margin-bottom:24px; }
  .payment-icons { display:flex; gap:8px; justify-content:center; flex-wrap:wrap; margin-bottom:20px; }
  .pay-icon { font-size:9px; letter-spacing:1px; color:var(--muted); border:1px solid rgba(91,26,138,.2); padding:6px 10px; }
  .summary-guarantee { display:flex; gap:12px; align-items:flex-start; padding:16px; border:1px solid rgba(91,26,138,.15); background:rgba(18,8,32,.4); }
  .guarantee-icon { font-size:20px; flex-shrink:0; }
  .guarantee-text { font-size:9px; color:var(--muted); line-height:1.8; letter-spacing:.5px; }
  .guarantee-text strong { color:var(--silver); display:block; font-size:9px; letter-spacing:2px; font-family:'Cinzel',serif; margin-bottom:4px; }

  /* FLASH */
  .alert { padding:14px 20px; margin-bottom:20px; font-size:11px; letter-spacing:1px; border:1px solid; }
  .alert-success { border-color:rgba(52,211,153,.3); color:#34d399; background:rgba(52,211,153,.08); }
  .alert-error { border-color:rgba(239,68,68,.3); color:#ef4444; background:rgba(239,68,68,.08); }
</style>

<div class="page-wrap">

  <div class="breadcrumb">
    <a href="{{ url('/') }}">HOME</a><span>›</span>
    <span style="color:var(--silver)">YOUR CART</span>
  </div>

  <div class="page-banner">
    <div class="page-banner-label">REVIEW YOUR ORDER</div>
    <div class="page-banner-title">Your Cart</div>
    @if(!empty($cart))
      <p class="page-banner-sub">
        {{ collect($cart)->sum('quantity') }} {{ collect($cart)->sum('quantity') == 1 ? 'item' : 'items' }} — curated with precision.
      </p>
    @endif
  </div>

  @if(session('success'))
    <div style="padding:0 80px;margin-top:20px;">
      <div class="alert alert-success">{{ session('success') }}</div>
    </div>
  @endif

  <div class="cart-layout">

    @if(!empty($cart))

      {{-- ITEMS --}}
      <div class="cart-items-panel">
        <div class="cart-header">
          <span class="cart-col-label">PRODUCT</span>
          <span class="cart-col-label">PRICE</span>
          <span class="cart-col-label">QTY</span>
          <span class="cart-col-label">TOTAL</span>
          <span></span>
        </div>

        @foreach($cart as $id => $item)
          <div class="cart-item">
            <div class="cart-item-info">
              <div class="cart-item-img">
                @if($item['img_path'] && $item['img_path'] !== 'default.jpg')
                  <img src="{{ Storage::url($item['img_path']) }}" alt="{{ $item['title'] }}">
                @else
                  <span style="font-size:22px;">📷</span>
                @endif
              </div>
              <div>
                <div class="cart-item-name">{{ $item['title'] }}</div>
                <a href="{{ route('removeItem', $id) }}" class="cart-item-remove">REMOVE</a>
              </div>
            </div>

            <div class="item-price">₱ {{ number_format($item['sell_price'], 2) }}</div>

            <div>
              <div class="item-qty">
                <a href="{{ route('reduceByOne', $id) }}" class="iq-btn">−</a>
                <span class="iq-num">{{ $item['quantity'] }}</span>
                <a href="{{ route('addToCart', $id) }}" class="iq-btn">+</a>
              </div>
            </div>

            <div class="item-total">₱ {{ number_format($item['sell_price'] * $item['quantity'], 2) }}</div>

            <a href="{{ route('removeItem', $id) }}" class="item-del">×</a>
          </div>
        @endforeach

        <div class="cart-actions">
          <a href="{{ url('/') }}" class="continue-link">← CONTINUE SHOPPING</a>
        </div>
      </div>

      {{-- ORDER SUMMARY --}}
      <div class="order-summary">
        <div class="summary-title">ORDER SUMMARY</div>

        <div class="summary-row">
          <span class="summary-label">SUBTOTAL ({{ collect($cart)->sum('quantity') }} ITEMS)</span>
          <span class="summary-val">₱ {{ number_format($total, 2) }}</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">SHIPPING</span>
          <span class="summary-val free">FREE</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">INSURANCE</span>
          <span class="summary-val free">INCLUDED</span>
        </div>
        <div class="summary-row">
          <span class="summary-label">VAT (12%)</span>
          <span class="summary-val">INCLUSIVE</span>
        </div>

        <div class="summary-divider"></div>

        <div class="summary-total-row">
          <span class="summary-total-label">TOTAL</span>
          <span class="summary-total-val">₱ {{ number_format($total, 2) }}</span>
        </div>

        <a href="{{ route('checkout') }}" class="checkout-btn">PROCEED TO CHECKOUT</a>

        <p class="summary-note">
          SECURE CHECKOUT · SSL ENCRYPTED<br>
          PAYMENT PROCESSED SAFELY
        </p>

        <div class="payment-icons">
          <span class="pay-icon">VISA</span>
          <span class="pay-icon">MASTERCARD</span>
          <span class="pay-icon">GCASH</span>
          <span class="pay-icon">MAYA</span>
          <span class="pay-icon">BANK TRANSFER</span>
        </div>

        <div class="summary-guarantee">
          <span class="guarantee-icon">🛡</span>
          <div class="guarantee-text">
            <strong>KAPTURE BUYER PROTECTION</strong>
            Every order is insured in transit, and covered by our 14-day return and 2-year warranty policy. Your investment is protected.
          </div>
        </div>
      </div>

    @else

      <div class="cart-empty">
        <div class="cart-empty-icon">📷</div>
        <div class="cart-empty-text">YOUR CART IS EMPTY</div>
        <p class="cart-empty-sub">Discover our curated collection of fine photographic instruments.</p>
        <a href="{{ url('/') }}" class="btn-shop">EXPLORE THE COLLECTION</a>
      </div>

    @endif

  </div>
</div>
@endsection