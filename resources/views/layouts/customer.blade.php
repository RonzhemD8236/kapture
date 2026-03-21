<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KAPTURE') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Cormorant+Garamond:ital,wght@0,300;1,300&family=Montserrat:wght@100;200;300;400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        :root {
            --black:        #04030a;
            --gold:         #c9a84c;
            --gold-light:   #e6c87a;
            --white:        #ede8f5;
            --silver:       #b8aece;
            --purple-light: #9333ea;
            --deep:         #0f0d1a;
            --border-subtle: rgba(168,155,194,0.12);
            --border:       rgba(201,168,76,0.2);
            --muted:        #6b6480;
        }

        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body { background: var(--black); color: var(--white); font-family: 'Montserrat', sans-serif; overflow-x: hidden; }

        nav.kapture-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 1030;
            padding: 22px 64px;
            display: flex; align-items: center; justify-content: space-between;
            background: linear-gradient(180deg, rgba(4,3,10,.95) 0%, transparent 100%);
            backdrop-filter: blur(2px);
        }

        .nav-logo {
            font-family: 'Cinzel', serif; font-size: 20px; letter-spacing: 8px;
            text-decoration: none;
            background: linear-gradient(90deg, var(--white), var(--gold-light));
            -webkit-background-clip: text; -webkit-text-fill-color: transparent; background-clip: text;
        }

        .nav-links { display: flex; gap: 40px; list-style: none; margin: 0; padding: 0; align-items: center; }
        .nav-links a {
            font-size: 10px; letter-spacing: 3px; color: var(--silver);
            text-decoration: none; font-weight: 300; transition: color .3s;
            position: relative; padding-bottom: 4px;
        }
        .nav-links a::after {
            content: ''; position: absolute; bottom: 0; left: 0; right: 0;
            height: 1px; background: var(--gold);
            transform: scaleX(0); transition: transform .3s;
        }
        .nav-links a:hover { color: var(--white); }
        .nav-links a:hover::after { transform: scaleX(1); }

        .nav-icons { display: flex; gap: 20px; align-items: center; }
        .nav-icons > a {
            color: var(--silver); text-decoration: none;
            transition: color .3s; position: relative; display: flex; align-items: center;
        }
        .nav-icons > a:hover { color: var(--white); }

        .cart-badge {
            position: absolute; top: -6px; right: -8px;
            background: var(--purple-light); color: white;
            font-size: 9px; width: 16px; height: 16px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }

        /* Profile button */
        .kapture-profile-btn {
            background: transparent;
            border: 1px solid var(--border-subtle);
            color: var(--white);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.6rem; font-weight: 300;
            letter-spacing: 0.15em; text-transform: uppercase;
            padding: 0.35rem 0.8rem;
            display: flex; align-items: center; gap: 0.6rem;
            cursor: pointer; transition: all 0.25s;
            text-decoration: none;
        }
        .kapture-profile-btn:hover,
        .kapture-profile-btn.show {
            border-color: var(--gold); color: var(--gold); text-decoration: none;
        }

        .profile-avatar {
            width: 20px; height: 20px; border-radius: 50%;
            background: linear-gradient(135deg, var(--silver), var(--gold));
            display: flex; align-items: center; justify-content: center;
            font-size: 0.55rem; color: var(--black); font-weight: 700;
            flex-shrink: 0; overflow: hidden;
        }
        .profile-avatar img { width:100%; height:100%; object-fit:cover; }

        /* Dropdown */
        .kapture-dropdown {
            background: var(--deep) !important;
            border: 1px solid var(--border-subtle) !important;
            border-radius: 0 !important;
            padding: 0.5rem 0 !important;
            min-width: 180px !important;
            margin-top: 6px !important;
            box-shadow: 0 8px 32px rgba(0,0,0,0.6) !important;
        }
        .kapture-dropdown .dropdown-header {
            font-size: 0.52rem; letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--gold); padding: 0.5rem 1rem 0.3rem;
            font-family: 'Montserrat', sans-serif;
        }
        .kapture-dropdown .dropdown-item {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.6rem; letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--muted); padding: 0.55rem 1rem;
            display: flex; align-items: center; gap: 0.6rem;
            transition: all 0.2s; background: transparent;
            border: none; width: 100%; text-align: left; cursor: pointer;
            text-decoration: none;
        }
        .kapture-dropdown .dropdown-item:hover { background: rgba(201,168,76,0.06) !important; color: var(--gold) !important; }
        .kapture-dropdown .dropdown-item i { width: 14px; text-align: center; }
        .kapture-dropdown .dropdown-divider { border-color: var(--border-subtle); margin: 0.25rem 0; }
        .item-danger { color: #c06060 !important; }
        .item-danger:hover { color: #e08080 !important; background: rgba(192,96,96,0.06) !important; }

        .page-body { padding-top: 80px; }
    </style>

    @stack('styles')
</head>
<body>

<nav class="kapture-nav">
    <a href="{{ route('home') }}" class="nav-logo">KAPTURE</a>

    <ul class="nav-links">
        <li><a href="{{ route('getItems') }}">SHOP</a></li>
        <li><a href="{{ route('about') }}">ABOUT</a></li>
        <li><a href="{{ route('contact') }}">CONTACT</a></li>
    </ul>

    <div class="nav-icons">
        {{-- Cart --}}
        <a href="{{ route('getCart') }}" title="Cart">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/>
            </svg>
            @if(session('cart') && count(session('cart')) > 0)
                <span class="cart-badge">{{ count(session('cart')) }}</span>
            @endif
        </a>

        @auth
            <div class="dropdown">
                <a href="#" class="kapture-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-avatar">
                        @if(Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default.jpg')
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="">
                        @else
                            {{ strtoupper(substr(Auth::user()->name ?? 'U', 0, 1)) }}
                        @endif
                    </div>
                    <span>{{ Auth::user()->name ?? 'Account' }}</span>
                    <i class="bi bi-chevron-down" style="font-size:0.5rem;"></i>
                </a>
                <ul class="dropdown-menu kapture-dropdown dropdown-menu-end">
                    <li><h6 class="dropdown-header">My Account</h6></li>
                    <li>
                        <a class="dropdown-item" href="{{ route('customer.profile') }}">
                            <i class="bi bi-person"></i> Profile
                        </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item item-danger">
                                <i class="bi bi-box-arrow-right"></i> Sign Out
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <a href="{{ route('login') }}" title="Login">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </a>
        @endauth
    </div>
</nav>

<div class="page-body">
    @yield('content')
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>