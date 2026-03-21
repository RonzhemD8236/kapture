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

  .checkout-layout { display:grid; grid-template-columns:1fr 380px; gap:2px; padding:60px 80px; align-items:start; }

  .section-label { font-family:'Cinzel',serif; font-size:9px; letter-spacing:4px; color:var(--gold); margin-bottom:20px; padding-bottom:12px; border-bottom:1px solid rgba(91,26,138,.2); display:flex; align-items:center; gap:14px; }
  .section-label::before { content:''; width:28px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }

  .form-grid-2 { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .form-group { margin-bottom:16px; }
  .form-label { font-size:9px; letter-spacing:3px; color:var(--muted); display:block; margin-bottom:8px; font-family:'Cinzel',serif; }

  /* Read-only display fields */
  .form-display { width:100%; background:rgba(18,8,32,.5); border:1px solid rgba(91,26,138,.15); color:var(--silver); padding:14px 16px; font-family:'Montserrat',sans-serif; font-size:12px; letter-spacing:.5px; }

  /* Hidden inputs to submit the data */
  .form-input { width:100%; background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); color:var(--white); padding:14px 16px; font-family:'Montserrat',sans-serif; font-size:12px; letter-spacing:.5px; outline:none; transition:border-color .3s; display:none; }

  .edit-profile-link { font-size:9px; letter-spacing:2px; color:var(--muted); text-decoration:none; display:inline-block; margin-bottom:24px; transition:color .3s; }
  .edit-profile-link:hover { color:var(--gold); }

  .place-order-btn { width:100%; font-family:'Cinzel',serif; font-size:11px; letter-spacing:5px; color:var(--white); padding:20px; border:1px solid rgba(147,51,234,.5); background:linear-gradient(135deg,rgba(91,26,138,.5),rgba(42,14,80,.9)); cursor:pointer; transition:all .4s; margin-top:8px; }
  .place-order-btn:hover { border-color:var(--purple-glow); letter-spacing:7px; }
  .back-link { font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--muted); text-decoration:none; display:inline-block; margin-top:16px; transition:color .3s; }
  .back-link:hover { color:var(--silver); }

  /* ORDER SUMMARY */
  .order-summary { background:linear-gradient(135deg,rgba(18,8,32,.95),rgba(4,3,10,1)); border:1px solid rgba(91,26,138,.2); padding:40px 36px; position:sticky; top:100px; align-self:start; }
  .summary-title { font-family:'Cinzel',serif; font-size:14px; letter-spacing:4px; color:var(--white); margin-bottom:24px; padding-bottom:16px; border-bottom:1px solid rgba(91,26,138,.2); }
  .summary-item { display:flex; gap:14px; align-items:center; margin-bottom:16px; }
  .summary-img { width:52px; height:42px; border:1px solid rgba(91,26,138,.2); background:rgba(42,14,80,.3); flex-shrink:0; overflow:hidden; display:flex; align-items:center; justify-content:center; }
  .summary-img img { width:100%; height:100%; object-fit:cover; }
  .summary-item-info { flex:1; }
  .summary-item-name { font-family:'Cinzel',serif; font-size:11px; color:var(--white); margin-bottom:2px; letter-spacing:.5px; }
  .summary-item-qty { font-size:10px; color:var(--muted); }
  .summary-item-price { font-family:'Cinzel',serif; font-size:12px; color:var(--gold); flex-shrink:0; }
  .summary-row { display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
  .summary-label { font-size:10px; letter-spacing:2px; color:var(--muted); font-weight:200; }
  .summary-val { font-size:12px; color:var(--silver); font-weight:300; }
  .summary-val.free { color:var(--purple-glow); }
  .summary-divider { height:1px; background:linear-gradient(90deg,transparent,rgba(91,26,138,.4),transparent); margin:16px 0; }
  .summary-total-row { display:flex; justify-content:space-between; align-items:center; margin-top:4px; }
  .summary-total-label { font-family:'Cinzel',serif; font-size:12px; letter-spacing:3px; color:var(--gold); }
  .summary-total-val { font-family:'Cinzel',serif; font-size:24px; color:var(--gold); }
  .summary-guarantee { display:flex; gap:12px; align-items:flex-start; margin-top:24px; padding:16px; border:1px solid rgba(91,26,138,.15); background:rgba(18,8,32,.4); }
  .guarantee-icon { font-size:20px; flex-shrink:0; }
  .guarantee-text { font-size:9px; color:var(--muted); line-height:1.8; letter-spacing:.5px; }
  .guarantee-text strong { color:var(--silver); display:block; font-size:9px; letter-spacing:2px; font-family:'Cinzel',serif; margin-bottom:4px; }
</style>

<div class="page-wrap">

  <div class="breadcrumb">
    <a href="{{ url('/') }}">HOME</a><span>›</span>
    <a href="{{ route('getCart') }}">CART</a><span>›</span>
    <span style="color:var(--silver)">CHECKOUT</span>
  </div>

  <div class="page-banner">
    <div class="page-banner-label">ALMOST THERE</div>
    <div class="page-banner-title">Checkout</div>
    <p class="page-banner-sub">Confirm your delivery details below.</p>
  </div>

  <div class="checkout-layout">

    {{-- FORM --}}
    <div class="checkout-form-panel">

      <form action="{{ route('checkout.place') }}" method="POST">
        @csrf

        {{-- Hidden inputs — actual data submitted --}}
        <input type="hidden" name="title"       value="{{ $customer->title }}">
        <input type="hidden" name="fname"       value="{{ $customer->fname }}">
        <input type="hidden" name="lname"       value="{{ $customer->lname }}">
        <input type="hidden" name="addressline" value="{{ $customer->addressline }}">
        <input type="hidden" name="town"        value="{{ $customer->town }}">
        <input type="hidden" name="zipcode"     value="{{ $customer->zipcode }}">
        <input type="hidden" name="phone"       value="{{ $customer->phone }}">

        <div class="section-label">DELIVERY INFORMATION</div>

        <a href="{{ route('customer.profile.edit') }}" class="edit-profile-link">✎ EDIT PROFILE TO UPDATE DETAILS</a>

        <div class="form-group">
          <div class="form-label">SALUTATION</div>
          <div class="form-display">{{ $customer->title }}</div>
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <div class="form-label">FIRST NAME</div>
            <div class="form-display">{{ $customer->fname }}</div>
          </div>
          <div class="form-group">
            <div class="form-label">LAST NAME</div>
            <div class="form-display">{{ $customer->lname }}</div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-label">ADDRESS</div>
          <div class="form-display">{{ $customer->addressline }}</div>
        </div>

        <div class="form-grid-2">
          <div class="form-group">
            <div class="form-label">TOWN / CITY</div>
            <div class="form-display">{{ $customer->town }}</div>
          </div>
          <div class="form-group">
            <div class="form-label">ZIP CODE</div>
            <div class="form-display">{{ $customer->zipcode }}</div>
          </div>
        </div>

        <div class="form-group">
          <div class="form-label">PHONE NUMBER</div>
          <div class="form-display">{{ $customer->phone }}</div>
        </div>

        <button type="submit" class="place-order-btn">PLACE ORDER</button>
        <br>
        <a href="{{ route('getCart') }}" class="back-link">← BACK TO CART</a>

      </form>
    </div>

    {{-- ORDER SUMMARY --}}
    <div class="order-summary">
      <div class="summary-title">YOUR ORDER</div>

      @foreach($cart as $item)
        <div class="summary-item">
          <div class="summary-img">
            @if($item['img_path'] && $item['img_path'] !== 'default.jpg')
              <img src="{{ Storage::url($item['img_path']) }}" alt="{{ $item['title'] }}">
            @else
              <span style="font-size:18px;">📷</span>
            @endif
          </div>
          <div class="summary-item-info">
            <div class="summary-item-name">{{ Str::limit($item['title'], 20) }}</div>
            <div class="summary-item-qty">Qty: {{ $item['quantity'] }}</div>
          </div>
          <div class="summary-item-price">₱ {{ number_format($item['sell_price'] * $item['quantity'], 2) }}</div>
        </div>
      @endforeach

      <div class="summary-divider"></div>

      <div class="summary-row">
        <span class="summary-label">SUBTOTAL</span>
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

      <div class="summary-guarantee">
        <span class="guarantee-icon">🛡</span>
        <div class="guarantee-text">
          <strong>KAPTURE BUYER PROTECTION</strong>
          Every order is insured in transit, covered by our 14-day return and 2-year warranty policy.
        </div>
      </div>
    </div>

  </div>
</div>
@endsection