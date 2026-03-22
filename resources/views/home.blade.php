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

  /* COLLECTION */
  #collection { padding:120px 80px; }
  .sec-label { font-family:'Cinzel',serif; font-size:10px; letter-spacing:6px; color:var(--gold); display:flex; align-items:center; gap:16px; margin-bottom:24px; }
  .sec-label::before { content:''; width:40px; height:1px; background:linear-gradient(90deg,transparent,var(--gold)); }
  .sec-title { font-family:'Cinzel',serif; font-size:clamp(36px,4vw,58px); font-weight:600; line-height:1.1; margin-bottom:20px; background:linear-gradient(135deg,var(--white),var(--silver)); -webkit-background-clip:text; -webkit-text-fill-color:transparent; background-clip:text; }
  .sec-intro { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:18px; color:var(--silver); line-height:1.8; max-width:520px; margin-bottom:40px; font-weight:300; }

  /* SEARCH */
  .search-form { display:flex; gap:0; max-width:600px; margin-bottom:48px; }
  .search-input { flex:1; background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); border-right:none; color:var(--white); padding:14px 20px; font-family:'Montserrat',sans-serif; font-size:11px; letter-spacing:1px; outline:none; }
  .search-input::placeholder { color:var(--muted); }
  .search-input:focus { border-color:rgba(147,51,234,.6); }
  .search-btn { background:linear-gradient(135deg,rgba(91,26,138,.7),rgba(42,14,80,.9)); border:1px solid rgba(91,26,138,.3); color:var(--gold); padding:14px 24px; cursor:pointer; font-family:'Cinzel',serif; font-size:10px; letter-spacing:3px; white-space:nowrap; }
  .search-btn:hover { background:rgba(91,26,138,.9); }

  /* PRODUCT GRID */
  .cam-grid { display:grid; grid-template-columns:repeat(3,1fr); gap:2px; }
  .cam-card { background:linear-gradient(135deg,rgba(18,8,32,.9),rgba(4,3,10,.95)); border:1px solid rgba(91,26,138,.2); position:relative; overflow:hidden; transition:border-color .4s, transform .4s; display:block; text-decoration:none; }
  .cam-card:hover { border-color:rgba(147,51,234,.5); transform:translateY(-4px); }
  .cam-card::before { content:''; position:absolute; top:0; left:0; right:0; height:1px; background:linear-gradient(90deg,transparent,rgba(201,168,76,.4),transparent); transform:scaleX(0); transition:transform .5s; }
  .cam-card:hover::before { transform:scaleX(1); }
  .card-img { height:200px; overflow:hidden; }
  .card-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s ease; }
  .cam-card:hover .card-img img { transform:scale(1.05); }
  .card-img-placeholder { width:100%; height:100%; background:linear-gradient(135deg,rgba(42,14,80,.4),rgba(4,3,10,.8)); display:flex; align-items:center; justify-content:center; }
  .card-body { padding:28px 28px 24px; }
  .cam-card-badge { font-family:'Cinzel',serif; font-size:9px; letter-spacing:4px; color:var(--gold); margin-bottom:10px; display:block; }
  .cam-card-title { font-family:'Cinzel',serif; font-size:16px; letter-spacing:2px; color:var(--white); margin-bottom:8px; }
  .cam-card-sub { font-family:'Cormorant Garamond',serif; font-style:italic; font-size:13px; color:var(--silver); margin-bottom:18px; line-height:1.5; }
  .card-footer { display:flex; align-items:center; justify-content:space-between; }
  .cam-card-price { font-family:'Cinzel',serif; font-size:14px; color:var(--gold); letter-spacing:2px; }
  .card-cta { font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; color:var(--purple-glow); border:1px solid rgba(147,51,234,.3); padding:8px 14px; }

  .mini-cam { width:70px; height:52px; position:relative; }
  .mc-body { position:absolute; bottom:0; left:0; right:0; height:38px; border:1px solid rgba(147,51,234,.6); border-radius:6px; }
  .mc-hump { position:absolute; top:0; left:12px; width:22px; height:12px; border:1px solid rgba(147,51,234,.6); border-bottom:none; border-radius:4px 4px 0 0; }
  .mc-lens { position:absolute; width:22px; height:22px; border-radius:50%; border:1px solid rgba(147,51,234,.6); bottom:8px; left:24px; display:flex; align-items:center; justify-content:center; }
  .mc-lens::after { content:''; width:10px; height:10px; border-radius:50%; background:radial-gradient(circle,rgba(91,26,138,.8),rgba(4,3,10,1)); }

  /* NO RESULTS */
  .no-results { text-align:center; padding:80px 20px; }
  .no-results-title { font-family:'Cinzel',serif; font-size:20px; color:var(--silver); margin-bottom:12px; }
  .no-results-clear { display:inline-block; margin-top:20px; font-family:'Cinzel',serif; font-size:9px; letter-spacing:3px; color:var(--gold); border:1px solid rgba(201,168,76,.3); padding:12px 28px; text-decoration:none; }

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
            <div class="cam-lens-mid"><div class="cam-lens-inner"></div></div>
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

    <a href="#" class="btn-enter" onclick="openExpanded(); return false;">
      <span>EXPLORE THE ATELIER</span>
    </a>

    <div class="hero-stats">
      <div class="stat"><span class="stat-n">600+</span><span class="stat-l">RARE INSTRUMENTS</span></div>
      <div class="stat"><span class="stat-n">28</span><span class="stat-l">YEARS CURATING</span></div>
      <div class="stat"><span class="stat-n">12</span><span class="stat-l">GLOBAL AWARDS</span></div>
      <div class="stat"><span class="stat-n">∞</span><span class="stat-l">POSSIBILITIES</span></div>
    </div>
  </div>
</section>

<div class="sec-divider"></div>

<!-- EXPANDED -->
<div id="expanded">

  <section id="collection">
    <div class="sec-label">THE ATELIER</div>
    <div class="sec-title">
      @if(request('search'))
        Results for "{{ request('search') }}"
      @else
        The Collection
      @endif
    </div>
    <p class="sec-intro">Each instrument handpicked for optical excellence, mechanical artistry, and enduring legacy.</p>

    {{-- SEARCH --}}
     <form action="{{ route('customer.home') }}" method="GET" class="search-form"
      onsubmit="if(!this.search.value.trim()){window.location='{{ route('customer.home') }}?expanded=1';return false;}">

      <input type="hidden" name="expanded" value="1">

      {{-- Search method selector --}}
      <select name="method" style="background:rgba(18,8,32,.8); border:1px solid rgba(91,26,138,.3); border-right:none; color:var(--gold); padding:14px 14px; font-family:'Cinzel',serif; font-size:9px; letter-spacing:2px; outline:none; cursor:pointer;">
      <option value="like"  {{ request('method') === 'like'  || !request('method') ? 'selected' : '' }}>LIKE</option>
      <option value="scope" {{ request('method') === 'scope' ? 'selected' : '' }}>SCOPE</option>
      <option value="scout" {{ request('method') === 'scout' ? 'selected' : '' }}>SCOUT</option>
    </select>

      <input
          class="search-input"
          type="text"
          name="search"
          placeholder="SEARCH INSTRUMENTS..."
          value="{{ request('search') }}"
      >
      <button type="submit" class="search-btn">SEARCH</button>
  </form>

    {{-- NO RESULTS --}}
    @if($items->count() === 0)
      <div class="no-results">
        <div class="no-results-title">NO PRODUCTS FOUND</div>
        <p style="font-size:11px; letter-spacing:1px; color:var(--muted);">Try a different search term.</p>
        <a href="{{ url('/') }}" class="no-results-clear">CLEAR SEARCH</a>
      </div>

    {{-- PRODUCTS --}}
    @else
      <div class="cam-grid">
        @foreach($items as $item)
          <a href="{{ route('product.show', $item->item_id) }}" class="cam-card">
            <div class="card-img">
              @if($item->img_path && $item->img_path !== 'default.jpg')
                <img src="{{ Storage::url($item->img_path) }}" alt="{{ $item->title }}">
              @else
                <div class="card-img-placeholder">
                  <div class="mini-cam">
                    <div class="mc-hump"></div>
                    <div class="mc-body"><div class="mc-lens"></div></div>
                  </div>
                </div>
              @endif
            </div>
            <div class="card-body">
              <span class="cam-card-badge">{{ strtoupper($item->category) }}</span>
              <div class="cam-card-title">{{ $item->title }}</div>
              <div class="cam-card-sub">{{ Str::limit($item->description, 60) }}</div>
              <div class="card-footer">
                <span class="cam-card-price">₱ {{ number_format($item->sell_price, 2) }}</span>
                <span class="card-cta">VIEW</span>
              </div>
            </div>
          </a>
        @endforeach
      </div>

    {{-- PAGINATION --}}
          <div style="margin-top:48px; display:flex; justify-content:center;">
            {{ $items->withQueryString()->links('pagination.default') }}
          </div>

        @endif

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
        <a href="{{ route('getItems') }}">Shop</a>
        <a href="{{ url('/about') }}">About</a>
        <a href="{{ url('/contact') }}">Contact</a>
      </div>
      <div class="footer-copy">© {{ date('Y') }} KAPTURE ATELIER — BGC, MANILA — ALL RIGHTS RESERVED</div>
    </div>
  </div>

</div><!-- /expanded -->

<script>
  function openExpanded() {
    document.getElementById('expanded').classList.add('open');
    document.getElementById('expanded').scrollIntoView({ behavior:'smooth', block:'start' });
  }

  document.addEventListener('DOMContentLoaded', function () {
    @if(request()->anyFilled(['search', 'page', 'expanded']))
      document.getElementById('expanded').classList.add('open');
      setTimeout(function() {
        document.getElementById('collection').scrollIntoView({ behavior:'smooth', block:'start' });
      }, 100);
    @endif
  });
</script>

@endsection