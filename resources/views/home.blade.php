@extends('layouts.customer')

@section('content')

<style>
  :root {
    --black:        #04030a;
    --deep:         #080612;
    --purple-dark:  #120820;
    --purple-mid:   #2a0e50;
    --purple:       #5b1a8a;
    --purple-light: #9333ea;
    --purple-glow:  #c084fc;
    --gold:         #c9a84c;
    --gold-light:   #e6c87a;
    --white:        #ede8f5;
    --silver:       #b8aece;
    --muted:        #6b5f7c;
  }

  /* grain overlay */
  body::after {
    content:''; position:fixed; inset:0; z-index:1000; pointer-events:none; opacity:.035;
    background-image:url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='.85' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)'/%3E%3C/svg%3E");
  }

  /* HERO */
  #hero {
    min-height:100vh; display:flex; flex-direction:column; align-items:center; justify-content:center;
    position:relative; overflow:hidden; padding:120px 64px 80px;
  }
  .hero-bg {
    position:absolute; inset:0; z-index:0;
    background:
      radial-gradient(ellipse 70% 55% at 20% 15%, rgba(42,14,80,.65) 0%, transparent 65%),
      radial-gradient(ellipse 60% 70% at 80% 85%, rgba(18,8,32,.9) 0%, transparent 60%),
      radial-gradient(ellipse 100% 100% at 50% 50%, rgba(8,6,18,1) 45%, transparent 100%);
  }
  .hero-bg::before {
    content:''; position:absolute; inset:0;
    background:repeating-linear-gradient(-45deg, transparent, transparent 80px, rgba(91,26,138,.03) 80px, rgba(91,26,138,.03) 81px);
  }
  .hero-orb { position:absolute; border-radius:50%; filter:blur(100px); pointer-events:none; }
  .orb1 { width:600px; height:600px; background:radial-gradient(circle, rgba(91,26,138,.12), transparent); top:-200px; left:-100px; animation:orbdrift 10s ease-in-out infinite; }
  .orb2 { width:450px; height:450px; background:radial-gradient(circle, rgba(42,14,80,.18), transparent); bottom:-100px; right:-80px; animation:orbdrift 13s ease-in-out -5s infinite; }
  .orb3 { width:200px; height:200px; background:radial-gradient(circle, rgba(201,168,76,.06), transparent); top:40%; left:60%; animation:orbdrift 7s ease-in-out -2s infinite; }
  @keyframes orbdrift { 0%,100%{transform:translate(0,0)} 50%{transform:translate(25px,-35px)} }

  .frame-t,.frame-b { position:absolute; left:40px; right:40px; height:1px; background:linear-gradient(90deg,transparent,rgba(91,26,138,.5),rgba(201,168,76,.25),rgba(91,26,138,.5),transparent); }
  .frame-t{top:24px;} .frame-b{bottom:24px;}
  .frame-l,.frame-r { position:absolute; top:40px; bottom:40px; width:1px; background:linear-gradient(180deg,transparent,rgba(91,26,138,.5),rgba(201,168,76,.25),rgba(91,26,138,.5),transparent); }
  .frame-l{left:24px;} .frame-r{right:24px;}
  .c { position:absolute; width:5px; height:5px; background:var(--gold); border-radius:50%; box-shadow:0 0 8px var(--gold); }
  .c-tl{top:22px;left:22px;} .c-tr{top:22px;right:22px;} .c-bl{bottom:22px;left:22px;} .c-br{bottom:22px;right:22px;}

  .hero-content { position:relative; z-index:10; text-align:center; }

  .hero-eyebrow {
    font-family:'Cinzel',serif; font-size:10px; letter-spacing:7px; color:var(--gold);
    animation:fadeUp .9s ease .3s both;
    display:flex; align-items:center; justify-content:center; gap:18px; margin-bottom:36px;
  }
  .hero-eyebrow span { width:50px; height:1px; display:block; }
  .hero-eyebrow span:first-child { background:linear-gradient(90deg,transparent,var(--gold)); }
  .hero-eyebrow span:last-child  { background:linear-gradient(270deg,transparent,var(--gold)); }

  /* CSS Camera */
  .cam-wrap { display:flex; justify-content:center; margin-bottom:44px; animation:fadeUp 1s ease .5s both; }
  .cam { position:relative; width:120px; height:90px; }
  .cam-body { position:absolute; bottom:0; left:0; right:0; height:75px; border:1.5px solid rgba(147,51,234,.7); border-radius:12px; background:linear-gradient(135deg,rgba(42,14,80,.4),rgba(4,3,10,.7)); box-shadow:0 0 40px rgba(91,26,138,.25), inset 0 0 30px rgba(91,26,138,.08); }
  .cam-hump { position:absolute; top:0; left:22px; width:34px; height:18px; border:1.5px solid rgba(147,51,234,.7); border-bottom:none; border-radius:6px 6px 0 0; background:rgba(42,14,80,.3); }
  .cam-lens-outer { position:absolute; width:44px; height:44px; border-radius:50%; border:1.5px solid rgba(147,51,234,.7); bottom:16px; left:38px; display:flex; align-items:center; justify-content:center; animation:lensGlow 3s ease-in-out infinite; }
  .cam-lens-mid { width:30px; height:30px; border-radius:50%; border:1px solid rgba(147,51,234,.5); display:flex; align-items:center; justify-content:center; }
  .cam-lens-inner { width:16px; height:16px; border-radius:50%; background:radial-gradient(circle,var(--purple-mid),var(--black)); border:1px solid rgba(147,51,234,.6); box-shadow:0 0 12px rgba(147,51,234,.8); }
  .cam-btn { position:absolute; width:12px; height:12px; border-radius:50%; background:var(--gold); bottom:54px; right:18px; box-shadow:0 0 10px var(--gold); }
  .cam-flash { position:absolute; width:20px; height:10px; border-radius:3px; border:1px solid rgba(147,51,234,.5); bottom:54px; left:14px; background:rgba(42,14,80,.4); }
  @keyframes lensGlow { 0%,100%{box-shadow:0 0 30px rgba(147,51,234,.4)} 50%{box-shadow:0 0 60px rgba(147,51,234,.8),0 0 90px rgba(91,26,138,.3)} }

  .hero-title {
    font-family:'Cinzel',serif; font-size:clamp(72px,10vw,140px); font-weight:700; letter-spacing:24px; line-height:.9;
    background:linear-gradient(135deg,var(--white) 0%,var(--purple-glow) 35%,var(--gold-light) 65%,var(--white) 100%);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text;
    filter:drop-shadow(0 0 50px rgba(147,51,234,.25));
    animation:fadeUp 1.2s ease .7s both; margin-bottom:6px;
  }
  .hero-sub {
    font-family:'Cormorant Garamond',serif; font-style:italic; font-size:clamp(15px,1.6vw,22px);
    font-weight:300; letter-spacing:5px; color:var(--silver);
    animation:fadeUp 1s ease .95s both; margin-bottom:52px;
  }

  .divider { display:flex; align-items:center; justify-content:center; gap:18px; margin-bottom:44px; animation:fadeUp 1s ease 1.1s both; }
  .div-line { width:90px; height:1px; }
  .div-line-l { background:linear-gradient(90deg,transparent,var(--purple-light)); }
  .div-line-r { background:linear-gradient(270deg,transparent,var(--purple-light)); }
  .diamond    { width:8px; height:8px; background:var(--gold); transform:rotate(45deg); box-shadow:0 0 10px var(--gold); }
  .diamond-sm { width:5px; height:5px; background:var(--purple-glow); transform:rotate(45deg); box-shadow:0 0 8px var(--purple-glow); }

  .hero-desc { font-size:11px; letter-spacing:3px; color:var(--silver); line-height:2.2; max-width:480px; margin:0 auto 56px; font-weight:200; animation:fadeUp 1s ease 1.25s both; }

  /* BUTTON */
  .btn-enter {
    font-family:'Cinzel',serif; font-size:11px; letter-spacing:6px;
    color:var(--white); padding:20px 64px;
    border:1px solid rgba(147,51,234,.5);
    background:linear-gradient(135deg,rgba(42,14,80,.5),rgba(4,3,10,.9));
    cursor:pointer; position:relative; overflow:hidden; display:inline-block;
    transition:all .4s ease; animation:fadeUp 1s ease 1.4s both;
    text-decoration:none;
  }
  .btn-enter::before { content:''; position:absolute; inset:0; background:linear-gradient(135deg,rgba(91,26,138,.35),rgba(147,51,234,.2)); opacity:0; transition:opacity .4s; }
  .btn-enter::after  { content:''; position:absolute; bottom:0; left:0; right:0; height:1.5px; background:linear-gradient(90deg,transparent,var(--gold),transparent); transform:scaleX(0); transition:transform .5s ease; }
  .btn-enter:hover { border-color:var(--purple-glow); letter-spacing:8px; color:var(--white); }
  .btn-enter:hover::before { opacity:1; }
  .btn-enter:hover::after  { transform:scaleX(1); }
  .btn-enter span { position:relative; z-index:1; }

  .hero-stats { display:flex; gap:80px; margin-top:80px; justify-content:center; animation:fadeUp 1s ease 1.6s both; }
  .stat { text-align:center; position:relative; }
  .stat+.stat::before { content:''; position:absolute; left:-40px; top:15%; bottom:15%; width:1px; background:linear-gradient(180deg,transparent,rgba(91,26,138,.6),transparent); }
  .stat-n { font-family:'Cinzel',serif; font-size:36px; color:var(--purple-glow); display:block; filter:drop-shadow(0 0 12px rgba(192,132,252,.5)); }
  .stat-l { font-size:9px; letter-spacing:3px; color:var(--muted); margin-top:6px; display:block; font-weight:300; }

  /* EXPANDED */
  #expanded { display:none; background:var(--deep); }
  #expanded.open { display:block; animation:fadeUp .8s ease both; }

  .sec-divider { height:1px; margin:0 60px; background:linear-gradient(90deg,transparent,rgba(91,26,138,.6),rgba(201,168,76,.3),rgba(91,26,138,.6),transparent); }

  /* CAMERAS */
  #cameras { padding:120px 80px; position:relative; }
  #cameras::before { content:''; position:absolute; inset:0; background:radial-gradient(ellipse 80% 60% at 50% 50%, rgba(18,8,32,.8) 0%, transparent 70%); pointer-events:none; }

  .sec-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:16px; margin-bottom:24px; }
  .sec-label::before { content:''; width:40px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .sec-title { font-family:'Cinzel',serif; font-size:clamp(36px,4vw,58px); font-weight:600; line-height:1.1; margin-bottom:20px; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .sec-intro { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:18px; color:var(--silver); line-height:1.8; max-width:520px; margin-bottom:64px; font-weight:300; }

  .cam-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:2px; position:relative; z-index:2; }
  .cam-card { background:linear-gradient(135deg,rgba(18,8,32,.9),rgba(4,3,10,.95)); border:1px solid rgba(91,26,138,.2); padding:44px 36px; position:relative; overflow:hidden; transition:border-color .4s, transform .4s; }
  .cam-card:hover { border-color:rgba(147,51,234,.5); transform:translateY(-4px); }
  .cam-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,.4),transparent); transform:scaleX(0); transition:transform .5s; }
  .cam-card:hover::before { transform:scaleX(1); }

  .cam-card-badge { font-family:'Cinzel',serif; font-size:9px; letter-spacing:4px; color:var(--gold); margin-bottom:28px; display:block; }
  .mini-cam { width:70px; height:52px; position:relative; margin-bottom:28px; }
  .mc-body { position:absolute; bottom:0; left:0; right:0; height:38px; border:1px solid; border-radius:6px; }
  .mc-hump { position:absolute; top:0; left:12px; width:22px; height:12px; border:1px solid; border-bottom:none; border-radius:4px 4px 0 0; }
  .mc-lens { position:absolute; width:22px; height:22px; border-radius:50%; border:1px solid; bottom:8px; left:24px; display:flex; align-items:center; justify-content:center; }
  .mc-lens::after { content:''; width:10px; height:10px; border-radius:50%; }

  .card-type-1 .mc-body,.card-type-1 .mc-hump,.card-type-1 .mc-lens { border-color:rgba(147,51,234,.6); }
  .card-type-1 .mc-lens::after { background:radial-gradient(circle,rgba(91,26,138,.8),rgba(4,3,10,1)); box-shadow:0 0 8px rgba(147,51,234,.6); }
  .card-type-2 .mc-body,.card-type-2 .mc-hump,.card-type-2 .mc-lens { border-color:rgba(201,168,76,.5); }
  .card-type-2 .mc-lens::after { background:radial-gradient(circle,rgba(42,14,80,.8),rgba(4,3,10,1)); box-shadow:0 0 8px rgba(201,168,76,.4); }
  .card-type-3 .mc-body,.card-type-3 .mc-hump,.card-type-3 .mc-lens { border-color:rgba(192,132,252,.5); }
  .card-type-3 .mc-lens::after { background:radial-gradient(circle,rgba(91,26,138,.8),rgba(4,3,10,1)); box-shadow:0 0 8px rgba(192,132,252,.5); }

  .cam-card-tag { position:absolute; top:20px; right:20px; font-size:8px; letter-spacing:2px; color:var(--purple-glow); border:1px solid rgba(147,51,234,.3); padding:4px 10px; font-weight:300; }
  .cam-card-title { font-family:'Cinzel',serif; font-size:20px; letter-spacing:3px; color:var(--white); margin-bottom:12px; }
  .cam-card-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:15px; color:var(--silver); margin-bottom:20px; line-height:1.6; }
  .cam-card-desc { font-size:11px; line-height:2; color:var(--muted); font-weight:200; }
  .cam-card-price { margin-top:28px; font-family:'Cinzel',serif; font-size:14px; color:var(--gold); letter-spacing:2px; }

  /* HISTORY */
  #history { padding:120px 80px; position:relative; background:linear-gradient(180deg,var(--deep),var(--purple-dark) 50%,var(--deep)); }
  #history::before { content:''; position:absolute; inset:0; pointer-events:none; background:repeating-linear-gradient(-45deg,transparent,transparent 120px,rgba(91,26,138,.025) 120px,rgba(91,26,138,.025) 121px); }

  .history-layout { display:grid; grid-template-columns:1fr 1fr; gap:100px; align-items:start; margin-top:64px; }

  .timeline { position:relative; padding-top:20px; }
  .tl-line { position:absolute; left:11px; top:20px; bottom:0; width:1px; background:linear-gradient(180deg,rgba(91,26,138,.8),rgba(201,168,76,.4),rgba(91,26,138,.2),transparent); }
  .tl-item { display:flex; gap:28px; margin-bottom:52px; }
  .tl-dot { width:24px; height:24px; border-radius:50%; flex-shrink:0; border:1px solid var(--purple-light); background:var(--black); display:flex; align-items:center; justify-content:center; box-shadow:0 0 12px rgba(147,51,234,.4); margin-top:2px; }
  .tl-dot::after { content:''; width:8px; height:8px; border-radius:50%; background:var(--purple-glow); box-shadow:0 0 8px var(--purple-glow); }
  .tl-dot.gold { border-color:var(--gold); box-shadow:0 0 12px rgba(201,168,76,.4); }
  .tl-dot.gold::after { background:var(--gold); box-shadow:0 0 8px var(--gold); }
  .tl-year { font-family:'Cinzel',serif; font-size:12px; color:var(--gold); letter-spacing:2px; margin-bottom:8px; }
  .tl-head { font-family:'Cinzel',serif; font-size:17px; color:var(--white); letter-spacing:1px; margin-bottom:10px; }
  .tl-text { font-size:12px; line-height:2; color:var(--muted); font-weight:200; }

  .quote-block { border-left:2px solid var(--gold); padding:28px 32px; background:linear-gradient(135deg,rgba(42,14,80,.3),rgba(4,3,10,.5)); margin-bottom:48px; }
  .quote-text { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:22px; color:var(--white); line-height:1.7; margin-bottom:16px; }
  .quote-attr { font-size:10px; letter-spacing:3px; color:var(--gold); font-weight:300; }

  .founder-block { display:flex; align-items:center; gap:24px; margin-bottom:40px; padding:28px; border:1px solid rgba(91,26,138,.2); background:linear-gradient(135deg,rgba(18,8,32,.8),rgba(4,3,10,.9)); }
  .founder-avatar { width:72px; height:72px; border-radius:50%; flex-shrink:0; background:linear-gradient(135deg,rgba(91,26,138,.6),rgba(42,14,80,.8)); border:1px solid rgba(147,51,234,.5); display:flex; align-items:center; justify-content:center; font-family:'Cinzel',serif; font-size:22px; color:var(--purple-glow); box-shadow:0 0 20px rgba(91,26,138,.3); }
  .founder-name { font-family:'Cinzel',serif; font-size:16px; letter-spacing:2px; color:var(--white); margin-bottom:6px; }
  .founder-role { font-size:10px; letter-spacing:3px; color:var(--gold); margin-bottom:10px; font-weight:300; }
  .founder-bio { font-size:11px; line-height:2; color:var(--muted); font-weight:200; }

  .values-row { display:grid; grid-template-columns:1fr 1fr; gap:16px; }
  .value-item { padding:20px 22px; border:1px solid rgba(91,26,138,.15); background:rgba(18,8,32,.5); transition:border-color .3s; }
  .value-item:hover { border-color:rgba(91,26,138,.45); }
  .value-icon { font-size:18px; margin-bottom:10px; }
  .value-name { font-family:'Cinzel',serif; font-size:12px; letter-spacing:2px; color:var(--white); margin-bottom:6px; }
  .value-desc { font-size:10px; letter-spacing:.5px; color:var(--muted); line-height:1.9; font-weight:200; }

  /* FOOTER */
  #footer-band { padding:60px 80px; background:var(--black); display:flex; align-items:center; justify-content:space-between; border-top:1px solid rgba(91,26,138,.25); }
  .footer-logo { font-family:'Cinzel',serif; font-size:24px; letter-spacing:10px; color:var(--white); }
  .footer-tagline { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:14px; color:var(--muted); letter-spacing:2px; }
  .footer-right { text-align:right; }
  .footer-copy { font-size:10px; letter-spacing:2px; color:var(--muted); font-weight:200; }
  .footer-links { display:flex; gap:32px; justify-content:flex-end; margin-bottom:12px; }
  .footer-links a { font-size:10px; letter-spacing:2px; color:var(--silver); text-decoration:none; font-weight:300; transition:color .3s; }
  .footer-links a:hover { color:var(--gold); }

  @keyframes fadeUp { from{opacity:0;transform:translateY(24px)} to{opacity:1;transform:translateY(0)} }
</style>

<!-- HERO -->
<section id="hero">
  <div class="hero-bg"></div>
  <div class="hero-orb orb1"></div>
  <div class="hero-orb orb2"></div>
  <div class="hero-orb orb3"></div>
  <div class="frame-t"></div><div class="frame-b"></div>
  <div class="frame-l"></div><div class="frame-r"></div>
  <div class="c c-tl"></div><div class="c c-tr"></div>
  <div class="c c-bl"></div><div class="c c-br"></div>

  <div class="hero-content">
    <div class="hero-eyebrow"><span></span>MAISON DE PHOTOGRAPHIE<span></span></div>

    <div class="cam-wrap">
      <div class="cam">
        <div class="cam-hump"></div>
        <div class="cam-body">
          <div class="cam-flash"></div>
          <div class="cam-lens-outer">
            <div class="cam-lens-mid">
              <div class="cam-lens-inner"></div>
            </div>
          </div>
          <div class="cam-btn"></div>
        </div>
      </div>
    </div>

    <h1 class="hero-title">KAPTURE</h1>
    <p class="hero-sub">Where Vision Meets Precision</p>

    <div class="divider">
      <div class="div-line div-line-l"></div>
      <div class="diamond"></div>
      <div class="diamond-sm"></div>
      <div class="diamond"></div>
      <div class="div-line div-line-r"></div>
    </div>

    <p class="hero-desc">
      EXCLUSIVE PURVEYORS OF FINE PHOTOGRAPHIC INSTRUMENTS<br>
      FOR THE DISCERNING COLLECTOR &amp; THE SEASONED PROFESSIONAL
    </p>

    <a href="#" class="btn-enter" onclick="openExpanded(); return false;"><span>EXPLORE THE ATELIER</span></a>

    <div class="hero-stats">
      <div class="stat"><span class="stat-n">600+</span><span class="stat-l">RARE INSTRUMENTS</span></div>
      <div class="stat"><span class="stat-n">28</span><span class="stat-l">YEARS CURATING</span></div>
      <div class="stat"><span class="stat-n">12</span><span class="stat-l">GLOBAL AWARDS</span></div>
      <div class="stat"><span class="stat-n">∞</span><span class="stat-l">POSSIBILITIES</span></div>
    </div>
  </div>
</section>

<!-- EXPANDED CONTENT -->
<div id="expanded">

  <div class="sec-divider"></div>

  <!-- CAMERA COLLECTION -->
  <section id="cameras" style="scroll-margin-top:80px">
    <div style="position:relative;z-index:2">
      <div class="sec-label">CURATED SELECTION</div>
      <div class="sec-title">The Collection</div>
      <p class="sec-intro">Each instrument in our atelier is handpicked for its optical excellence, mechanical artistry, and enduring legacy. These are not merely cameras — they are portals to a finer world.</p>

      <div class="cam-grid">
        <div class="cam-card card-type-1">
          <div class="cam-card-tag">BESTSELLER</div>
          <div class="mini-cam"><div class="mc-hump"></div><div class="mc-body"><div class="mc-lens"></div></div></div>
          <span class="cam-card-badge">SERIES I — FULL FRAME</span>
          <div class="cam-card-title">KAPTURE ONE</div>
          <div class="cam-card-sub">The Flagship Mirrorless</div>
          <p class="cam-card-desc">61 megapixels of resolving power wrapped in a body machined from a single billet of aerospace aluminium. The Kapture One redefines what full-frame mirrorless can achieve — in studio or in the field.</p>
          <div class="cam-card-price">₱ 340,000</div>
        </div>

        <div class="cam-card card-type-2">
          <div class="cam-card-tag">COLLECTOR'S EDITION</div>
          <div class="mini-cam"><div class="mc-hump"></div><div class="mc-body"><div class="mc-lens"></div></div></div>
          <span class="cam-card-badge">SERIES II — MEDIUM FORMAT</span>
          <div class="cam-card-title">KAPTURE LUMIÈRE</div>
          <div class="cam-card-sub">Medium Format Mastery</div>
          <p class="cam-card-desc">A collaboration with renowned optical engineers from Osaka, the Lumière houses a 102-megapixel back-illuminated sensor. Limited to 500 units worldwide, each numbered and engraved in 24-karat gold leaf.</p>
          <div class="cam-card-price">₱ 980,000</div>
        </div>

        <div class="cam-card card-type-3">
          <div class="cam-card-tag">NEW ARRIVAL</div>
          <div class="mini-cam"><div class="mc-hump"></div><div class="mc-body"><div class="mc-lens"></div></div></div>
          <span class="cam-card-badge">SERIES III — STREET</span>
          <div class="cam-card-title">KAPTURE NOIR</div>
          <div class="cam-card-sub">The Rangefinder Reborn</div>
          <p class="cam-card-desc">Inspired by the golden era of Parisian street photography, the Noir pairs a whisper-quiet shutter with a 36MP sensor in a brass-bodied chassis. Invisible in the city. Unmistakable in the darkroom.</p>
          <div class="cam-card-price">₱ 215,000</div>
        </div>

        <div class="cam-card card-type-1">
          <div class="mini-cam"><div class="mc-hump"></div><div class="mc-body"><div class="mc-lens"></div></div></div>
          <span class="cam-card-badge">OPTICS — PRIME</span>
          <div class="cam-card-title">HELIO 50mm f/1.2</div>
          <div class="cam-card-sub">Portrait Perfection</div>
          <p class="cam-card-desc">Fourteen elements in eleven groups, aspherical and anomalous-dispersion glass throughout. The Helio renders bokeh that painters envy — silky, three-dimensional, completely devoid of nervous energy.</p>
          <div class="cam-card-price">₱ 88,000</div>
        </div>

        <div class="cam-card card-type-2">
          <div class="mini-cam"><div class="mc-hump"></div><div class="mc-body"><div class="mc-lens"></div></div></div>
          <span class="cam-card-badge">OPTICS — ZOOM</span>
          <div class="cam-card-title">ZENITH 24-70mm f/2</div>
          <div class="cam-card-sub">The Professional Standard</div>
          <p class="cam-card-desc">A constant f/2 aperture across the full zoom range was once considered impossible. Kapture's optical engineers spent four years making it inevitable. Weather-sealed. Temperature-stable. Uncompromising.</p>
          <div class="cam-card-price">₱ 165,000</div>
        </div>

        <div class="cam-card card-type-3">
          <div class="mini-cam"><div class="mc-hump"></div><div class="mc-body"><div class="mc-lens"></div></div></div>
          <span class="cam-card-badge">ACCESSORIES — HERITAGE</span>
          <div class="cam-card-title">ARCANA STRAP</div>
          <div class="cam-card-sub">Hand-Stitched Italian Leather</div>
          <p class="cam-card-desc">Full-grain vegetable-tanned cowhide from a family tannery in Tuscany, brass hardware aged in a controlled patina bath. The Arcana strap ages more beautifully with every outing.</p>
          <div class="cam-card-price">₱ 12,500</div>
        </div>
      </div>
    </div>
  </section>

  <div class="sec-divider"></div>

  <!-- HISTORY -->
  <section id="history" style="scroll-margin-top:80px">
    <div class="sec-label">HERITAGE &amp; LEGACY</div>
    <div class="sec-title">Our Story</div>
    <p class="sec-intro">Founded in the streets of Ermita, Manila, Kapture has spent nearly three decades elevating photographic culture in the Philippines and beyond.</p>

    <div class="history-layout">
      <div class="timeline">
        <div class="tl-line"></div>
        <div class="tl-item">
          <div class="tl-dot gold"></div>
          <div>
            <div class="tl-year">1996 — THE FOUNDING</div>
            <div class="tl-head">A Single Glass Case in Ermita</div>
            <p class="tl-text">Ramon de Leon, a former photojournalist for the Manila Chronicle, opens a narrow shopfront on Padre Faura with eight pre-owned cameras and an unshakeable belief that Filipino photographers deserved access to world-class equipment.</p>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div>
            <div class="tl-year">2001 — FIRST IMPORT LICENSE</div>
            <div class="tl-head">Direct Partnerships with Japan</div>
            <p class="tl-text">After five years of earning trust in the community, Kapture secures exclusive import agreements with two legendary Japanese optical manufacturers — bringing premium glass to Manila at prices that finally made sense.</p>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div>
            <div class="tl-year">2008 — THE ATELIER</div>
            <div class="tl-head">Moving to BGC</div>
            <p class="tl-text">The shop relocates to a purpose-designed atelier in Bonifacio Global City — a 400 sqm space with a temperature-controlled vault for rare film cameras, a darkroom for clients, and a private consultation salon.</p>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot"></div>
          <div>
            <div class="tl-year">2014 — KAPTURE ORIGINALS</div>
            <div class="tl-head">Our First House-Brand Lens</div>
            <p class="tl-text">The Helio 50mm f/1.2 becomes Kapture's first proprietary optic, assembled by hand in partnership with Osaka craftspeople. It sells out its inaugural run of 200 units in four hours.</p>
          </div>
        </div>
        <div class="tl-item">
          <div class="tl-dot gold"></div>
          <div>
            <div class="tl-year">2024 — TODAY</div>
            <div class="tl-head">The Kapture House</div>
            <p class="tl-text">Three floors. Six hundred instruments. A rooftop photography studio open to members. Kapture remains independently owned — the only full-service luxury camera atelier in Southeast Asia.</p>
          </div>
        </div>
      </div>

      <div>
        <div class="quote-block">
          <p class="quote-text">"A great camera does not make a great photograph. But it does make the journey toward one a great deal more beautiful."</p>
          <div class="quote-attr">— RAMON DE LEON, FOUNDER &amp; CHIEF CURATOR</div>
        </div>

        <div class="founder-block">
          <div class="founder-avatar">R</div>
          <div>
            <div class="founder-name">RAMON DE LEON</div>
            <div class="founder-role">FOUNDER &amp; CHIEF CURATOR</div>
            <p class="founder-bio">Former photojournalist. Leica collector. Believer in the transformative power of a single, well-made image. Ramon personally inspects every instrument before it reaches the atelier floor.</p>
          </div>
        </div>

        <div class="values-row">
          <div class="value-item">
            <div class="value-icon">◈</div>
            <div class="value-name">CURATION</div>
            <p class="value-desc">Every piece in our atelier is personally selected. We carry fewer than 50 models at any time — each one chosen to be the finest of its kind.</p>
          </div>
          <div class="value-item">
            <div class="value-icon">◉</div>
            <div class="value-name">CRAFT</div>
            <p class="value-desc">Our in-house technicians are trained in Tokyo and Wetzlar. Camera servicing and CLA by appointment only.</p>
          </div>
          <div class="value-item">
            <div class="value-icon">◇</div>
            <div class="value-name">COMMUNITY</div>
            <p class="value-desc">Monthly portfolio reviews, quarterly workshops with visiting photographers, and a members' darkroom open seven days a week.</p>
          </div>
          <div class="value-item">
            <div class="value-icon">◎</div>
            <div class="value-name">CONFIDENCE</div>
            <p class="value-desc">Every purchase includes a two-year Kapture warranty and lifetime complimentary sensor cleaning — no asterisks.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <div id="footer-band">
    <div>
      <div class="footer-logo">KAPTURE</div>
      <div class="footer-tagline">Where Vision Meets Precision</div>
    </div>
    <div class="footer-right">
      <div class="footer-links">
        <a href="{{ url('/') }}">Collection</a>
        <a href="#">Workshops</a>
        <a href="#">Membership</a>
        <a href="#">Contact</a>
      </div>
      <div class="footer-copy">© {{ date('Y') }} KAPTURE ATELIER — BGC, MANILA — ALL RIGHTS RESERVED</div>
    </div>
  </div>

</div><!-- /expanded -->

<script>
  function openExpanded() {
    document.getElementById('expanded').classList.add('open');
    document.getElementById('expanded').scrollIntoView({ behavior: 'smooth', block: 'start' });
  }
</script>

@endsection