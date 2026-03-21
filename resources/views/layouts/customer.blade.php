<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'KAPTURE') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;600&family=Cormorant+Garamond:ital,wght@0,300;1,300&family=Montserrat:wght@100;200;300;400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --black:        #04030a;
            --gold:         #c9a84c;
            --gold-light:   #e6c87a;
            --white:        #ede8f5;
            --silver:       #b8aece;
            --purple-light: #9333ea;
        }
        *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }
        html { scroll-behavior: smooth; }
        body {
            background: var(--black);
            color: var(--white);
            font-family: 'Montserrat', sans-serif;
            overflow-x: hidden;
        }
        nav.kapture-nav {
            position: fixed; top: 0; left: 0; right: 0; z-index: 500;
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
        .nav-links { display: flex; gap: 40px; list-style: none; margin: 0; padding: 0; }
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
        .nav-icons a {
            color: var(--silver); text-decoration: none;
            transition: color .3s; position: relative; display: flex; align-items: center;
        }
        .nav-icons a:hover { color: var(--white); }
        .cart-badge {
            position: absolute; top: -6px; right: -8px;
            background: var(--purple-light); color: white;
            font-size: 9px; width: 16px; height: 16px;
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
        }
        .page-body { padding-top: 80px; }
    </style>

    @stack('styles')
</head>
<body>

<nav class="kapture-nav">
    <a href="{{ route('home') }}">KAPTURE</a>

    <ul class="nav-links">
        <a href="{{ route('getItems') }}">SHOP</a>
        <li><a href="{{ route('about') }}">ABOUT</a></li>
        <li><a href="{{ route('contact') }}">CONTACT</a></li>
    </ul>

    <div class="nav-icons">

        {{-- User icon: profile if logged in, login if guest --}}
        @auth
            <a href="{{ route('customer.profile') }}" title="{{ Auth::user()->name }}">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </a>
        @else
            <a href="{{ route('login') }}" title="Login">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z"/>
                </svg>
            </a>
        @endauth

        {{-- Cart --}}
        <a href="{{ route('getCart') }}" title="Cart">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007Z"/>
            </svg>
            @if(session('cart') && count(session('cart')) > 0)
                <span class="cart-badge">{{ count(session('cart')) }}</span>
            @endif
        </a>

        {{-- Logout: only when logged in --}}
        @auth
            <a href="#" title="Logout"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75"/>
                </svg>
            </a>
            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display:none;">

                @csrf
            </form>
        @endauth

    </div>
</nav>

<div class="page-body">
    @yield('content')
</div>

@stack('scripts')
</body>
</html>