<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'KAPTURE')</title>
    @section('head')

        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/2.2.1/dataTables.bootstrap5.min.css"
            integrity="sha512-pVSTZJo4Kj/eLMUG1w+itkGx+scwF00G5dMb02FjgU9WwF7F/cpZvu1Bf1ojA3iAf8y94cltGnuPV9vwv3CgZw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
            integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

        <style>
            *, *::before, *::after { box-sizing: border-box; }
            body {
                background: #07070d;
                color: #d4cfe0;
                font-family: 'Montserrat', sans-serif;
                margin: 0;
            }

            /* ── Navbar ── */
            .kap-nav {
                position: sticky;
                top: 0;
                z-index: 999;
                background: #07070d;
                border-bottom: 1px solid rgba(168,155,194,0.08);
            }

            .kap-nav-inner {
                max-width: 1400px;
                margin: 0 auto;
                padding: 0 2.5rem;
                height: 64px;
                display: grid;
                grid-template-columns: 1fr auto 1fr;
                align-items: center;
            }

            .kap-brand {
                font-family: 'Cormorant Garamond', serif;
                font-size: 1rem;
                font-weight: 400;
                letter-spacing: 0.45em;
                text-transform: uppercase;
                color: #fff;
                text-decoration: none;
            }

            .kap-links {
                display: flex;
                align-items: center;
                gap: 2.75rem;
                list-style: none;
                margin: 0; padding: 0;
            }

            .kap-links a {
                font-size: 0.6rem;
                font-weight: 500;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: rgba(212,207,224,0.55);
                text-decoration: none;
                position: relative;
                padding-bottom: 2px;
                transition: color 0.2s;
            }

            .kap-links a::after {
                content: '';
                position: absolute;
                left: 0; bottom: -2px;
                width: 0; height: 1px;
                background: #c9a84c;
                transition: width 0.25s;
            }

            .kap-links a:hover,
            .kap-links a.active { color: rgba(212,207,224,0.9); }
            .kap-links a:hover::after,
            .kap-links a.active::after { width: 100%; }

            .kap-icons {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap: 1.5rem;
            }

            .kap-icon-btn {
                background: none;
                border: none;
                color: rgba(212,207,224,0.5);
                font-size: 1rem;
                cursor: pointer;
                text-decoration: none;
                display: flex;
                align-items: center;
                transition: color 0.2s;
                position: relative;
            }

            .kap-icon-btn:hover { color: rgba(212,207,224,0.9); }

            .kap-cart-badge {
                position: absolute;
                top: -6px; right: -7px;
                background: #7c3aed;
                color: #fff;
                font-family: 'Montserrat', sans-serif;
                font-size: 0.45rem;
                font-weight: 700;
                width: 14px; height: 14px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .kap-mobile-toggle {
                display: none;
                background: none;
                border: none;
                color: rgba(212,207,224,0.6);
                font-size: 1.1rem;
                cursor: pointer;
                padding: 0;
            }

            .kap-mobile-menu {
                display: none;
                flex-direction: column;
                background: #07070d;
                border-top: 1px solid rgba(168,155,194,0.06);
                padding: 1rem 2.5rem 1.5rem;
                gap: 0;
            }

            .kap-mobile-menu a {
                font-size: 0.62rem;
                font-weight: 500;
                letter-spacing: 0.18em;
                text-transform: uppercase;
                color: rgba(212,207,224,0.5);
                text-decoration: none;
                padding: 0.65rem 0;
                border-bottom: 1px solid rgba(168,155,194,0.06);
                transition: color 0.2s;
            }

            .kap-mobile-menu a:last-child { border-bottom: none; }
            .kap-mobile-menu a:hover { color: rgba(212,207,224,0.9); }
            .kap-mobile-menu.open { display: flex; }

            @media (max-width: 768px) {
                .kap-links { display: none; }
                .kap-mobile-toggle { display: block; }
                .kap-nav-inner { grid-template-columns: 1fr auto; }
            }
        </style>

    @show
</head>

<body>

    {{-- ── Navbar ── --}}
    <nav class="kap-nav">
        <div class="kap-nav-inner">

            <a href="{{ route('home') }}" class="kap-brand">Kapture</a>

            <ul class="kap-links">
                <li><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}">Shop</a></li>
                <li><a href="#" class="{{ request()->routeIs('brands*') ? 'active' : '' }}">Brands</a></li>
                <li><a href="#" class="{{ request()->routeIs('about*') ? 'active' : '' }}">About</a></li>
                <li><a href="#" class="{{ request()->routeIs('contact*') ? 'active' : '' }}">Contact</a></li>
            </ul>

            <div class="kap-icons">
                @auth
                    <a href="#" class="kap-icon-btn" title="{{ Auth::user()->name }}">
                        <i class="fa-regular fa-user"></i>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="kap-icon-btn" title="Sign In">
                        <i class="fa-regular fa-user"></i>
                    </a>
                @endauth

                <a href="#" class="kap-icon-btn" title="Cart">
                    <i class="fa-regular fa-bag-shopping"></i>
                    <span class="kap-cart-badge">0</span>
                </a>

                <button class="kap-mobile-toggle" id="kapMobileToggle" aria-label="Menu">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>

        </div>

        <div class="kap-mobile-menu" id="kapMobileMenu">
            <a href="{{ route('home') }}">Shop</a>
            <a href="#">Brands</a>
            <a href="#">About</a>
            <a href="#">Contact</a>
            @auth
                <a href="#">{{ Auth::user()->name }}</a>
            @else
                <a href="{{ route('login') }}">Sign In</a>
            @endauth
        </div>
    </nav>

    @yield('body')
    @stack('scripts')

    <script>
        document.getElementById('kapMobileToggle')?.addEventListener('click', function () {
            document.getElementById('kapMobileMenu').classList.toggle('open');
        });
    </script>

</body>
</html>