@extends('layouts.customer')

@section('content')
<style>
  :root {
    --black:#04030a; --deep:#080612; --purple-dark:#120820; --purple-mid:#2a0e50;
    --purple:#5b1a8a; --purple-light:#9333ea; --purple-glow:#c084fc;
    --gold:#c9a84c; --gold-light:#e6c87a; --white:#ede8f5;
    --silver:#b8aece; --muted:#6b5f7c;
  }
  .page-wrap { padding-top:80px; min-height:100vh; }
  .breadcrumb { padding:20px 80px; font-size:10px; letter-spacing:2px; color:var(--muted); display:flex; gap:12px; align-items:center; border-bottom:1px solid rgba(91,26,138,.1); }
  .breadcrumb a { color:var(--muted); text-decoration:none; }
  .breadcrumb a:hover { color:var(--silver); }
  .breadcrumb span { color:rgba(91,26,138,.5); }

  .page-banner { padding:60px 80px 40px; border-bottom:1px solid rgba(91,26,138,.2); position:relative; overflow:hidden; }
  .page-banner::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 80% 100% at 20% 50%,rgba(42,14,80,.5) 0%,transparent 70%); }
  .page-banner-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:14px; margin-bottom:16px; position:relative; }
  .page-banner-label::before { content:''; width:36px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .page-banner-title { font-family:'Cinzel',serif; font-size:clamp(40px,5vw,72px); font-weight:600; position:relative; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .page-banner-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:18px; color:var(--silver); margin-top:14px; font-weight:300; position:relative; }

  .sec-divider { height:1px; margin:0 60px; background:linear-gradient(90deg,transparent,rgba(91,26,138,.6),rgba(201,168,76,.3),rgba(91,26,138,.6),transparent); }

  /* INFO PANEL — full width now */
  .contact-info { background:linear-gradient(135deg,rgba(42,14,80,.3),rgba(8,6,18,.9)); padding:80px; position:relative; overflow:hidden; }
  .contact-info::before { content:''; position:absolute; inset:0; background:repeating-linear-gradient(-45deg,transparent,transparent 80px,rgba(91,26,138,.025) 80px,rgba(91,26,138,.025) 81px); }
  .contact-info-title { font-family:'Cinzel',serif; font-size:28px; letter-spacing:3px; color:var(--white); margin-bottom:12px; position:relative; }
  .contact-info-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:16px; color:var(--silver); margin-bottom:48px; font-weight:300; position:relative; }

  .contact-details { display:grid; grid-template-columns:1fr 1fr; gap:36px; position:relative; }
  .contact-detail { display:flex; gap:20px; }
  .cd-icon { width:44px; height:44px; border:1px solid rgba(91,26,138,.3); background:rgba(18,8,32,.5); display:flex; align-items:center; justify-content:center; font-size:18px; flex-shrink:0; }
  .cd-label { font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--gold); margin-bottom:6px; }
  .cd-value { font-size:12px; color:var(--silver); line-height:1.9; font-weight:200; }
  .cd-value a { color:var(--silver); text-decoration:none; transition:color .3s; }
  .cd-value a:hover { color:var(--purple-glow); }

  /* MAP */
  .map-block { margin-top:48px; position:relative; height:220px; border:1px solid rgba(91,26,138,.2); background:linear-gradient(135deg,rgba(42,14,80,.2),rgba(4,3,10,.9)); display:flex; align-items:center; justify-content:center; overflow:hidden; }
  .map-block::before { content:''; position:absolute; inset:0; background:repeating-linear-gradient(0deg,transparent,transparent 30px,rgba(91,26,138,.05) 30px,rgba(91,26,138,.05) 31px),repeating-linear-gradient(90deg,transparent,transparent 30px,rgba(91,26,138,.05) 30px,rgba(91,26,138,.05) 31px); }
  .map-pin { position:relative; z-index:2; text-align:center; }
  .map-pin-dot { width:16px; height:16px; background:var(--gold); border-radius:50%; margin:0 auto 8px; box-shadow:0 0 20px var(--gold); animation:pinglow 2s ease-in-out infinite; }
  @keyframes pinglow { 0%,100%{box-shadow:0 0 20px var(--gold)} 50%{box-shadow:0 0 40px var(--gold),0 0 60px rgba(201,168,76,.4)} }
  .map-pin-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:2px; color:var(--gold); }
  .map-pin-addr { font-size:10px; color:var(--muted); margin-top:4px; }

  /* HOURS */
  .hours-block { margin-top:32px; border:1px solid rgba(91,26,138,.15); background:rgba(8,6,18,.5); padding:28px 32px; position:relative; }
  .hours-title { font-family:'Cinzel',serif; font-size:10px; letter-spacing:4px; color:var(--gold); margin-bottom:16px; }
  .hours-row { display:flex; justify-content:space-between; margin-bottom:10px; }
  .hours-day { font-size:10px; color:var(--muted); letter-spacing:1px; font-weight:200; }
  .hours-time { font-size:10px; color:var(--silver); letter-spacing:1px; }
  .hours-closed { color:var(--muted); }
  .hours-note { font-size:9px; color:var(--muted); margin-top:14px; padding-top:14px; border-top:1px solid rgba(91,26,138,.1); letter-spacing:1px; }

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
    <a href="{{ url('/') }}">HOME</a><span>›</span>
    <span style="color:var(--silver)">CONTACT</span>
  </div>

  <div class="page-banner">
    <div class="page-banner-label">GET IN TOUCH</div>
    <div class="page-banner-title">Contact Us</div>
    <p class="page-banner-sub">We're a small team — but we respond fast and we care about every message.</p>
  </div>

  <div class="contact-info">
    <div class="contact-info-title">Reach Us Online</div>
    <p class="contact-info-sub">Kapture is a fully online platform. No walk-ins — but always reachable.</p>

    <div class="contact-details">
      <div class="contact-detail">
        <div class="cd-icon">✉</div>
        <div>
          <div class="cd-label">EMAIL</div>
          <div class="cd-value">
            <a href="mailto:hello@kapture.ph">hello@kapture.ph</a> — General Enquiries<br>
            <a href="mailto:orders@kapture.ph">orders@kapture.ph</a> — Order Support<br>
            <a href="mailto:returns@kapture.ph">returns@kapture.ph</a> — Returns & Refunds
          </div>
        </div>
      </div>
      <div class="contact-detail">
        <div class="cd-icon">📞</div>
        <div>
          <div class="cd-label">PHONE & MESSAGING</div>
          <div class="cd-value">
            <a href="tel:+639175552025">+63 917 555 2025</a> (WhatsApp & Viber)<br>
            Available Monday – Saturday, 9am – 6pm
          </div>
        </div>
      </div>
      <div class="contact-detail">
        <div class="cd-icon">📱</div>
        <div>
          <div class="cd-label">SOCIAL MEDIA</div>
          <div class="cd-value">
            @kaptureph — Instagram<br>
            Kapture Camera Shop — Facebook<br>
            We typically reply within a few hours.
          </div>
        </div>
      </div>
      <div class="contact-detail">
        <div class="cd-icon">🚚</div>
        <div>
          <div class="cd-label">SHIPPING & DELIVERY</div>
          <div class="cd-value">
            Metro Manila — 1 to 2 business days<br>
            Nationwide — 3 to 5 business days<br>
            All orders shipped fully insured, free of charge.
          </div>
        </div>
      </div>
    </div>

    <div class="map-block">
      <div class="map-pin">
        <div class="map-pin-dot"></div>
        <div class="map-pin-label">KAPTURE — ONLINE</div>
        <div class="map-pin-addr">Serving all of the Philippines</div>
      </div>
    </div>

    <div class="hours-block">
      <div class="hours-title">RESPONSE HOURS</div>
      <div class="hours-row"><span class="hours-day">Monday – Friday</span><span class="hours-time">9:00am – 6:00pm</span></div>
      <div class="hours-row"><span class="hours-day">Saturday</span><span class="hours-time">10:00am – 4:00pm</span></div>
      <div class="hours-row"><span class="hours-day">Sunday</span><span class="hours-time hours-closed">Not Available</span></div>
      <div class="hours-row"><span class="hours-day">Public Holidays</span><span class="hours-time hours-closed">Not Available</span></div>
      <div class="hours-note">Online orders are processed Monday–Saturday. We aim to respond to all messages within one business day.</div>
    </div>
  </div>

</div>

{{-- FOOTER --}}
<footer id="kapture-footer">
  <div class="footer-top">
    <div class="footer-brand">
      <div class="footer-logo">KAPTURE</div>
      <p class="footer-tagline">Where Vision Meets Precision</p>
      <p class="footer-address">Kapture Philippines<br>Founded January 2025<br>By Kyla Karen Baguis & Ronzhem Ein Dioso</p>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">SHOP</div>
      <a href="{{ url('/') }}">All Products</a>
      <a href="{{ url('/?category[]=Mirrorless') }}">Mirrorless</a>
      <a href="{{ url('/?category[]=Lenses') }}">Lenses</a>
      <a href="{{ url('/?category[]=Accessories') }}">Accessories</a>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">SUPPORT</div>
      <a href="{{ route('contact') }}">Contact Us</a>
      <a href="{{ route('getCart') }}">Your Cart</a>
      <a href="{{ route('customer.profile') }}">Your Profile</a>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">COMPANY</div>
      <a href="{{ route('about') }}">Our Story</a>
      <a href="{{ route('contact') }}">Contact</a>
    </div>
    <div class="footer-col">
      <div class="footer-col-title">STAY UPDATED</div>
      <p class="footer-newsletter-text">Get early access to new arrivals and exclusive offers.</p>
      <div class="footer-newsletter">
        <input type="email" placeholder="your@email.com">
        <button>→</button>
      </div>
    </div>
  </div>
  <div class="footer-bottom">
    <span>© {{ date('Y') }} KAPTURE — ALL RIGHTS RESERVED</span>
    <div class="footer-bottom-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Shipping & Returns</a>
    </div>
  </div>
</footer>

@endsection