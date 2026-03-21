<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kapture — Admin</title>
    @section('head')

        {{-- Bootstrap --}}
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        {{-- Bootstrap Icons --}}
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

        {{-- Font Awesome --}}
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
            integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- DataTables --}}
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-bs5/2.2.1/dataTables.bootstrap5.min.css"
            integrity="sha512-pVSTZJo4Kj/eLMUG1w+itkGx+scwF00G5dMb02FjgU9WwF7F/cpZvu1Bf1ojA3iAf8y94cltGnuPV9vwv3CgZw=="
            crossorigin="anonymous" referrerpolicy="no-referrer" />

        {{-- Google Fonts --}}
        <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">

        {{-- jQuery --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>

        {{-- DataTables JS --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
            integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>

        {{-- Bootstrap JS --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
        </script>

        {{-- Chart.js --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js"></script>

        <style>
            :root {
                --kapture-black: #0a0a0f;
                --kapture-deep: #0f0d1a;
                --kapture-gold: #c9a84c;
                --kapture-gold-light: #e8c97a;
                --kapture-lilac: #a89bc2;
                --kapture-text: #d4cfe0;
                --kapture-muted: #6b6480;
                --kapture-border: rgba(201, 168, 76, 0.2);
                --kapture-border-subtle: rgba(168, 155, 194, 0.12);
            }

            *, *::before, *::after { box-sizing: border-box; }

            html, body {
                margin: 0;
                padding: 0;
                background: var(--kapture-black);
                color: var(--kapture-text);
                font-family: 'Montserrat', sans-serif;
                min-height: 100vh;
            }

            /* ── Navbar ── */
            .kapture-nav {
                background: var(--kapture-black);
                border-bottom: 1px solid var(--kapture-border-subtle);
                padding: 0 2.5rem;
                height: 64px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .kapture-brand {
                font-family: 'Montserrat', sans-serif;
                font-weight: 300;
                font-size: 0.9rem;
                letter-spacing: 0.35em;
                text-transform: uppercase;
                color: #fff;
                text-decoration: none;
                flex-shrink: 0;
            }
            .kapture-brand:hover { color: var(--kapture-gold); text-decoration: none; }

            .kapture-nav-links {
                display: flex;
                align-items: center;
                gap: 2.5rem;
                list-style: none;
                margin: 0;
                padding: 0;
            }

            .kapture-nav-links a {
                font-size: 0.62rem;
                font-weight: 500;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: var(--kapture-muted);
                text-decoration: none;
                position: relative;
                padding-bottom: 2px;
                transition: color 0.25s ease;
            }

            .kapture-nav-links a::after {
                content: '';
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 1px;
                background: var(--kapture-gold);
                transition: width 0.3s ease;
            }

            .kapture-nav-links a:hover,
            .kapture-nav-links a.active {
                color: var(--kapture-gold);
                text-decoration: none;
            }

            .kapture-nav-links a:hover::after,
            .kapture-nav-links a.active::after { width: 100%; }

            /* ── Profile button ── */
            .kapture-profile-btn {
                background: transparent;
                border: 1px solid var(--kapture-border-subtle);
                color: var(--kapture-text);
                font-family: 'Montserrat', sans-serif;
                font-size: 0.62rem;
                font-weight: 500;
                letter-spacing: 0.15em;
                text-transform: uppercase;
                padding: 0.4rem 0.9rem;
                display: flex;
                align-items: center;
                gap: 0.6rem;
                cursor: pointer;
                transition: all 0.25s ease;
                text-decoration: none;
            }

            .kapture-profile-btn:hover,
            .kapture-profile-btn.show {
                border-color: var(--kapture-gold);
                color: var(--kapture-gold);
                text-decoration: none;
            }

            .profile-avatar {
                width: 22px;
                height: 22px;
                border-radius: 50%;
                background: linear-gradient(135deg, var(--kapture-lilac), var(--kapture-gold));
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 0.58rem;
                color: var(--kapture-black);
                font-weight: 700;
                flex-shrink: 0;
            }

            /* ── Dropdown ── */
            .kapture-dropdown {
                background: var(--kapture-deep);
                border: 1px solid var(--kapture-border-subtle);
                border-radius: 0;
                padding: 0.5rem 0;
                min-width: 180px;
                margin-top: 6px !important;
                box-shadow: 0 8px 32px rgba(0,0,0,0.6);
            }

            .kapture-dropdown .dropdown-header {
                font-size: 0.55rem;
                letter-spacing: 0.2em;
                text-transform: uppercase;
                color: var(--kapture-gold);
                padding: 0.5rem 1rem 0.3rem;
                font-family: 'Montserrat', sans-serif;
            }

            .kapture-dropdown .dropdown-item {
                font-family: 'Montserrat', sans-serif;
                font-size: 0.62rem;
                letter-spacing: 0.12em;
                text-transform: uppercase;
                color: var(--kapture-muted);
                padding: 0.55rem 1rem;
                display: flex;
                align-items: center;
                gap: 0.6rem;
                transition: all 0.2s;
                background: transparent;
                border: none;
                width: 100%;
                text-align: left;
                cursor: pointer;
            }

            .kapture-dropdown .dropdown-item:hover {
                background: rgba(201, 168, 76, 0.06);
                color: var(--kapture-gold);
            }

            .kapture-dropdown .dropdown-item i { width: 14px; text-align: center; }
            .kapture-dropdown .dropdown-divider { border-color: var(--kapture-border-subtle); margin: 0.25rem 0; }

            .item-danger { color: #c06060 !important; }
            .item-danger:hover { color: #e08080 !important; background: rgba(192,96,96,0.06) !important; }

            /* ── Mobile ── */
            .kapture-toggler {
                display: none;
                background: transparent;
                border: 1px solid var(--kapture-border-subtle);
                color: var(--kapture-muted);
                padding: 0.35rem 0.6rem;
                font-size: 0.9rem;
                cursor: pointer;
                transition: all 0.2s;
            }
            .kapture-toggler:hover { border-color: var(--kapture-gold); color: var(--kapture-gold); }

            @media (max-width: 768px) {
                .kapture-nav {
                    flex-wrap: wrap;
                    height: auto;
                    padding: 0.85rem 1.25rem;
                    gap: 0.5rem;
                }
                .kapture-toggler { display: block; }
                #kaptureNavCenter {
                    display: none;
                    width: 100%;
                    order: 3;
                }
                #kaptureNavCenter.open { display: block; }
                .kapture-nav-links {
                    flex-direction: column;
                    align-items: flex-start;
                    gap: 0;
                    border-top: 1px solid var(--kapture-border-subtle);
                    padding-top: 0.5rem;
                    padding-bottom: 0.25rem;
                }
                .kapture-nav-links a { padding: 0.55rem 0; display: block; }
            }

            .kapture-body {
                background: var(--kapture-black);
                min-height: calc(100vh - 64px);
            }
        </style>

    @show
</head>

<body>

    {{-- ══ Admin Navbar ══ --}}
    <nav class="kapture-nav">

        {{-- Brand --}}
        <a href="{{ route('dashboard.index') }}" class="kapture-brand">Kapture</a>

        {{-- Mobile toggle --}}
        <button class="kapture-toggler"
                onclick="document.getElementById('kaptureNavCenter').classList.toggle('open')"
                aria-label="Toggle navigation">
            <i class="bi bi-list"></i>
        </button>

        {{-- Nav links --}}
        <div id="kaptureNavCenter">
            <ul class="kapture-nav-links">
                <li>
                    <a href="{{ route('dashboard.index') }}"
                       class="{{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                        Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users') }}"
                       class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                        Users
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.orders') }}"
                       class="{{ request()->routeIs('admin.orders*') ? 'active' : '' }}">
                        Orders
                    </a>
                </li>
                <li>
                    <a href="{{ route('items.index') }}"
                       class="{{ request()->routeIs('items.*') ? 'active' : '' }}">
                        Items
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reviews.index') }}"
                    class="{{ request()->routeIs('admin.reviews*') ? 'active' : '' }}">
                        Reviews
                    </a>
                </li>
            </ul>
        </div>

        {{-- Profile dropdown --}}
        <div class="dropdown">
            <a href="#" class="kapture-profile-btn" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="profile-avatar">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 1)) }}
                </div>
                <span>{{ Auth::user()->name ?? 'Admin' }}</span>
                <i class="bi bi-chevron-down" style="font-size:0.5rem;"></i>
            </a>
            <ul class="dropdown-menu kapture-dropdown dropdown-menu-end">
                <li><h6 class="dropdown-header">Admin Panel</h6></li>
                <li>
                    <a class="dropdown-item" href="{{ route('admin.profile') }}">
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

    </nav>

    {{-- ══ Page content ══ --}}
    <div class="kapture-body">
        @yield('body')
    </div>

    @stack('scripts')

</body>

</html>