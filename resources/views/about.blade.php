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

  /* BREADCRUMB */
  .breadcrumb { padding:20px 80px; font-size:10px; letter-spacing:2px; color:var(--muted); display:flex; gap:12px; align-items:center; border-bottom:1px solid rgba(91,26,138,.1); }
  .breadcrumb a { color:var(--muted); text-decoration:none; }
  .breadcrumb a:hover { color:var(--silver); }
  .breadcrumb span { color:rgba(91,26,138,.5); }

  /* PAGE BANNER */
  .page-banner { padding:60px 80px 40px; border-bottom:1px solid rgba(91,26,138,.2); position:relative; overflow:hidden; }
  .page-banner::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 80% 100% at 20% 50%,rgba(42,14,80,.5) 0%,transparent 70%); }
  .page-banner-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:14px; margin-bottom:16px; position:relative; }
  .page-banner-label::before { content:''; width:36px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .page-banner-title { font-family:'Cinzel',serif; font-size:clamp(40px,5vw,72px); font-weight:600; position:relative; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .page-banner-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:18px; color:var(--silver); margin-top:14px; font-weight:300; position:relative; }

  /* SECTION HELPERS */
  .sec-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:16px; margin-bottom:24px; }
  .sec-label::before { content:''; width:40px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .sec-title { font-family:'Cinzel',serif; font-size:clamp(32px,4vw,52px); font-weight:600; line-height:1.1; margin-bottom:20px; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .sec-intro { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:18px; color:var(--silver); line-height:1.8; max-width:520px; margin-bottom:64px; font-weight:300; }
  .sec-divider { height:1px; margin:0 60px; background:linear-gradient(90deg,transparent,rgba(91,26,138,.6),rgba(201,168,76,.3),rgba(91,26,138,.6),transparent); }

  /* MISSION */
  .mission-section { padding:100px 80px; display:grid; grid-template-columns:1fr 1fr; gap:100px; align-items:center; }
  .mission-text h2 { font-family:'Cinzel',serif; font-size:clamp(28px,3.5vw,48px); color:var(--white); letter-spacing:3px; line-height:1.2; margin-bottom:24px; }
  .mission-text h2 em { font-family:'Cormorant Garamond',serif; font-style:italic; -webkit-text-fill-color:transparent; background:linear-gradient(135deg,var(--purple-glow),var(--gold)); -webkit-background-clip:text; background-clip:text; }
  .mission-body { font-size:13px; color:var(--silver); line-height:2.2; font-weight:200; margin-bottom:24px; }
  .mission-stats { display:grid; grid-template-columns:1fr 1fr; gap:16px; margin-top:8px; }
  .ms { padding:24px; border:1px solid rgba(91,26,138,.2); background:rgba(18,8,32,.5); }
  .ms-num { font-family:'Cinzel',serif; font-size:28px; color:var(--purple-glow); display:block; filter:drop-shadow(0 0 10px rgba(192,132,252,.4)); }
  .ms-lbl { font-size:9px; letter-spacing:3px; color:var(--muted); margin-top:4px; display:block; }

  .mission-visual { position:relative; }
  .mission-quote { border-left:2px solid var(--gold); padding:36px 40px; background:linear-gradient(135deg,rgba(42,14,80,.3),rgba(4,3,10,.6)); }
  .mq-text { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:clamp(18px,2.2vw,26px); color:var(--white); line-height:1.7; margin-bottom:20px; }
  .mq-attr { font-family:'Cinzel',serif; font-size:10px; letter-spacing:3px; color:var(--gold); }
  .mission-visual-deco { position:absolute; top:-20px; right:-20px; width:100px; height:100px; border:1px solid rgba(91,26,138,.3); pointer-events:none; }
  .mission-visual-deco::after { content:''; position:absolute; inset:10px; border:1px solid rgba(201,168,76,.2); }

  /* TIMELINE */
  .timeline-section { padding:100px 80px; background:linear-gradient(180deg,var(--deep),rgba(18,8,32,.5)); }
  .tl-full { position:relative; margin-top:64px; }
  .tl-spine { position:absolute; left:50%; top:0; bottom:0; width:1px; background:linear-gradient(180deg,rgba(91,26,138,.8),rgba(201,168,76,.4),rgba(91,26,138,.2),transparent); transform:translateX(-50%); }
  .tl-entry { display:grid; grid-template-columns:1fr 60px 1fr; gap:0; align-items:center; margin-bottom:60px; }
  .tl-entry:nth-child(odd) .tl-left { text-align:right; padding-right:48px; }
  .tl-entry:nth-child(odd) .tl-right { padding-left:48px; }
  .tl-entry:nth-child(even) .tl-left { order:3; padding-left:48px; }
  .tl-entry:nth-child(even) .tl-center { order:2; }
  .tl-entry:nth-child(even) .tl-right { order:1; text-align:right; padding-right:48px; }
  .tl-center { display:flex; flex-direction:column; align-items:center; gap:6px; }
  .tl-node { width:24px; height:24px; border-radius:50%; border:1px solid var(--purple-light); background:var(--black); display:flex; align-items:center; justify-content:center; box-shadow:0 0 15px rgba(147,51,234,.4); }
  .tl-node::after { content:''; width:8px; height:8px; border-radius:50%; background:var(--purple-glow); }
  .tl-node.gold { border-color:var(--gold); box-shadow:0 0 15px rgba(201,168,76,.4); }
  .tl-node.gold::after { background:var(--gold); }
  .tl-year-tag { font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:var(--gold); white-space:nowrap; }
  .tl-left,.tl-right { padding-top:4px; }
  .tl-head { font-family:'Cinzel',serif; font-size:15px; color:var(--white); letter-spacing:2px; margin-bottom:10px; }
  .tl-body { font-size:12px; color:var(--muted); line-height:2; font-weight:200; }

  /* TEAM */
  .team-section { padding:100px 80px; }
  .team-grid { display:grid; grid-template-columns:repeat(2,1fr); gap:2px; margin-top:64px; max-width:800px; }
  .team-card { padding:44px 36px; border:1px solid rgba(91,26,138,.15); background:linear-gradient(135deg,rgba(18,8,32,.9),rgba(4,3,10,.95)); text-align:center; transition:border-color .4s,transform .3s; }
  .team-card:hover { border-color:rgba(91,26,138,.4); transform:translateY(-4px); }
  .team-avatar { width:80px; height:80px; border-radius:50%; background:linear-gradient(135deg,rgba(91,26,138,.5),rgba(42,14,80,.8)); border:1px solid rgba(147,51,234,.4); display:flex; align-items:center; justify-content:center; margin:0 auto 20px; font-family:'Cinzel',serif; font-size:26px; color:var(--purple-glow); box-shadow:0 0 20px rgba(91,26,138,.3); }
  .team-name { font-family:'Cinzel',serif; font-size:15px; letter-spacing:2px; color:var(--white); margin-bottom:6px; }
  .team-role { font-size:9px; letter-spacing:3px; color:var(--gold); margin-bottom:16px; }
  .team-bio { font-size:11px; color:var(--muted); line-height:2; font-weight:200; }

  /* VALUES */
  .values-section { padding:100px 80px; background:linear-gradient(180deg,var(--deep),var(--purple-dark) 60%,var(--deep)); }
  .values-grid { display:grid; grid-template-columns:repeat(4,1fr); gap:2px; margin-top:64px; }
  .value-card { padding:48px 36px; border:1px solid rgba(91,26,138,.15); background:rgba(8,6,18,.7); transition:border-color .4s; }
  .value-card:hover { border-color:rgba(91,26,138,.4); }
  .value-glyph { font-size:28px; margin-bottom:20px; display:block; }
  .value-name { font-family:'Cinzel',serif; font-size:14px; letter-spacing:3px; color:var(--white); margin-bottom:14px; }
  .value-body { font-size:11px; color:var(--muted); line-height:2; font-weight:200; }

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
    <span style="color:var(--silver)">OUR STORY</span>
  </div>

  <div class="page-banner">
    <div class="page-banner-label">WHO WE ARE</div>
    <div class="page-banner-title">Our Story</div>
    <p class="page-banner-sub">Born in 2025, built by photographers, for photographers.</p>
  </div>

  {{-- MISSION --}}
  <div class="mission-section">
    <div class="mission-text">
      <div class="sec-label">OUR MISSION</div>
      <h2>We believe every great image deserves a great <em>instrument.</em></h2>
      <p class="mission-body">Kapture was born from a simple conviction: photographers in the Philippines deserve access to quality camera equipment without compromise. Founded in January 2025 by Kyla Karen Baguis and Dioso Ronzhem Ein, we set out to build a curated online destination for serious photographers and collectors alike.</p>
      <p class="mission-body">In just a short time, we have grown to over 100 handpicked instruments — each selected for its optical excellence, mechanical quality, and lasting value. We are young, passionate, and just getting started.</p>
      <div class="mission-stats">
        <div class="ms"><span class="ms-num">2025</span><span class="ms-lbl">YEAR FOUNDED</span></div>
        <div class="ms"><span class="ms-num">100+</span><span class="ms-lbl">INSTRUMENTS IN STOCK</span></div>
        <div class="ms"><span class="ms-num">2</span><span class="ms-lbl">PASSIONATE FOUNDERS</span></div>
        <div class="ms"><span class="ms-num">∞</span><span class="ms-lbl">POSSIBILITIES AHEAD</span></div>
      </div>
    </div>
    <div class="mission-visual">
      <div class="mission-visual-deco"></div>
      <div class="mission-quote">
        <p class="mq-text">"We didn't build Kapture to be the biggest camera store. We built it to be the most thoughtful one — a place where every product earns its place."</p>
        <div class="mq-attr">— KYLA KAREN BAGUIS & RONZHEM EIN DIOSO, FOUNDERS</div>
      </div>
    </div>
  </div>

  <div class="sec-divider"></div>

  {{-- TIMELINE --}}
  <div class="timeline-section">
    <div class="sec-label">OUR JOURNEY</div>
    <div class="sec-title">How It All Began</div>

    <div class="tl-full">
      <div class="tl-spine"></div>

      <div class="tl-entry">
        <div class="tl-left">
          <div class="tl-head">The Idea</div>
          <p class="tl-body">Kyla and Ronzhem, both photography enthusiasts, notice how difficult it is to find quality camera equipment online in the Philippines. The idea for Kapture takes shape over late-night conversations and shared frustration with the existing market.</p>
        </div>
        <div class="tl-center"><div class="tl-node gold"></div><span class="tl-year-tag">JAN 2025</span></div>
        <div class="tl-right"></div>
      </div>

      <div class="tl-entry">
        <div class="tl-left"></div>
        <div class="tl-center"><div class="tl-node"></div><span class="tl-year-tag">FEB 2025</span></div>
        <div class="tl-right">
          <div class="tl-head">Building the Foundation</div>
          <p class="tl-body">The Kapture platform begins development. The founders spend weeks curating the first batch of products, establishing supplier relationships, and designing the shopping experience from the ground up.</p>
        </div>
      </div>

      <div class="tl-entry">
        <div class="tl-left">
          <div class="tl-head">First 50 Products</div>
          <p class="tl-body">Kapture launches its first curated collection — 50 handpicked camera bodies, lenses, and accessories. Every item is personally vetted by the founders before listing. The standard is set from day one.</p>
        </div>
        <div class="tl-center"><div class="tl-node"></div><span class="tl-year-tag">MAR 2025</span></div>
        <div class="tl-right"></div>
      </div>

      <div class="tl-entry">
        <div class="tl-left"></div>
        <div class="tl-center"><div class="tl-node"></div><span class="tl-year-tag">JUN 2025</span></div>
        <div class="tl-right">
          <div class="tl-head">Growing the Collection</div>
          <p class="tl-body">Kapture expands to over 100 products spanning mirrorless cameras, DSLR bodies, prime and zoom lenses, and premium accessories. Customer feedback drives every curation decision.</p>
        </div>
      </div>

      <div class="tl-entry">
        <div class="tl-left">
          <div class="tl-head">Kapture Today</div>
          <p class="tl-body">With a growing community of photographers and collectors, Kapture continues to refine its platform, expand its catalogue, and stay true to its founding belief — that every photographer deserves access to exceptional equipment.</p>
        </div>
        <div class="tl-center"><div class="tl-node gold"></div><span class="tl-year-tag">2026</span></div>
        <div class="tl-right"></div>
      </div>

    </div>
  </div>

  <div class="sec-divider"></div>

  {{-- TEAM --}}
  <div class="team-section">
    <div class="sec-label">THE PEOPLE BEHIND KAPTURE</div>
    <div class="sec-title">Our Founders</div>
    <p class="sec-intro">Two photographers who turned a shared frustration into something real.</p>

    <div class="team-grid">
      <div class="team-card">
        <div class="team-avatar">K</div>
        <div class="team-name">KYLA KAREN BAGUIS</div>
        <div class="team-role">CO-FOUNDER & CHIEF CURATOR</div>
        <p class="team-bio">Photography enthusiast and detail-oriented curator. Kyla oversees every product on the Kapture platform, ensuring that nothing reaches our customers without meeting the standard she set from day one — exceptional quality, every time.</p>
      </div>
      <div class="team-card">
        <div class="team-avatar">R</div>
        <div class="team-name">RONZHEM EIN DIOSO</div>
        <div class="team-role">CO-FOUNDER & TECHNICAL LEAD</div>
        <p class="team-bio">The architect behind the Kapture platform. Ronzhem combines a passion for photography with a sharp technical mind, building the systems that power a seamless shopping experience for photographers across the Philippines.</p>
      </div>
    </div>
  </div>

  <div class="sec-divider"></div>

  {{-- VALUES --}}
  <div class="values-section">
    <div class="sec-label">WHAT WE STAND FOR</div>
    <div class="sec-title">Our Values</div>

    <div class="values-grid">
      <div class="value-card">
        <span class="value-glyph">◈</span>
        <div class="value-name">CURATION</div>
        <p class="value-body">Every product on Kapture is personally selected. We would rather carry 100 exceptional items than 1,000 ordinary ones. If it isn't worth your time, it isn't on our platform.</p>
      </div>
      <div class="value-card">
        <span class="value-glyph">◉</span>
        <div class="value-name">HONESTY</div>
        <p class="value-body">We describe every product accurately and price it fairly. No hidden fees, no inflated markups. We want you to come back — and that means earning your trust every single time.</p>
      </div>
      <div class="value-card">
        <span class="value-glyph">◇</span>
        <div class="value-name">COMMUNITY</div>
        <p class="value-body">Kapture exists to serve photographers. We listen to our customers, take their feedback seriously, and build this platform with them — not just for them.</p>
      </div>
      <div class="value-card">
        <span class="value-glyph">◎</span>
        <div class="value-name">CONFIDENCE</div>
        <p class="value-body">Every purchase comes with our full support. We stand behind what we sell — because we chose it ourselves and we know exactly what it is worth.</p>
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
    <span>© {{ date('Y') }} KAPTURE — ALL RIGHTS RESERVED</span>
    <div class="footer-bottom-links">
      <a href="#">Privacy Policy</a>
      <a href="#">Terms of Service</a>
      <a href="#">Shipping & Returns</a>
    </div>
  </div>
</footer>

@endsection