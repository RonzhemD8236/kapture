@extends('layouts.customer')

@section('head')
    @parent
    <style>
        :root {
            --black: #07070d; --panel: #0d0b1c; --panel2: #110f20;
            --gold: #c9a84c; --gold-lt: #e8c97a;
            --text: #d4cfe0; --muted: #6b6480;
            --subtle: rgba(168,155,194,0.1);
            --border: rgba(201,168,76,0.18);
        }

        .profile-page {
            min-height: calc(100vh - 64px);
            background:
                radial-gradient(ellipse 50% 40% at 80% 20%, rgba(80,40,140,0.12) 0%, transparent 60%),
                var(--black);
            padding: 2.5rem 2rem;
            font-family: 'Montserrat', sans-serif;
        }

        .profile-wrap { max-width: 900px; margin: 0 auto; }

        .flash {
            background: rgba(201,168,76,0.07);
            border: 1px solid rgba(201,168,76,0.25);
            color: var(--gold);
            font-size: 0.62rem; letter-spacing: 0.08em;
            padding: 0.75rem 1rem; margin-bottom: 1.5rem;
        }

        /* Hero */
        .profile-hero {
            display: flex; align-items: center; gap: 1.75rem;
            padding-bottom: 2rem; margin-bottom: 2rem;
            border-bottom: 1px solid var(--border);
        }

        .profile-avatar {
            width: 88px; height: 88px; border-radius: 50%;
            border: 2px solid rgba(201,168,76,0.3);
            overflow: hidden; flex-shrink: 0;
            background: rgba(255,255,255,0.03);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: 2rem;
        }
        .profile-avatar img { width:100%; height:100%; object-fit:cover; }

        .profile-hero-info { flex: 1; }
        .profile-hero-info h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem; font-weight: 300;
            color: #fff; margin: 0 0 0.2rem; line-height: 1;
        }
        .hero-email { font-size: 0.62rem; color: var(--muted); letter-spacing: 0.06em; margin-bottom: 0.5rem; }

        .profile-badge {
            display: inline-flex; align-items: center; gap: 0.35rem;
            font-size: 0.5rem; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            color: var(--gold); border: 1px solid rgba(201,168,76,0.25);
            padding: 0.2rem 0.65rem;
        }

        .btn-edit-profile {
            display: inline-flex; align-items: center; gap: 0.4rem;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.55rem; font-weight: 600;
            letter-spacing: 0.18em; text-transform: uppercase;
            background: transparent; border: 1px solid var(--subtle);
            color: var(--muted); padding: 0.55rem 1.1rem;
            text-decoration: none; transition: all 0.2s;
        }
        .btn-edit-profile:hover { border-color: var(--gold); color: var(--gold); }

        /* Cards */
        .profile-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 1rem; margin-bottom: 1rem;
        }

        .profile-card {
            border: 1px solid var(--subtle);
            background: rgba(255,255,255,0.01);
            padding: 1.4rem 1.5rem;
        }

        .card-title {
            font-size: 0.5rem; font-weight: 600;
            letter-spacing: 0.25em; text-transform: uppercase;
            color: var(--gold); margin-bottom: 1.1rem;
            padding-bottom: 0.6rem;
            border-bottom: 1px solid var(--subtle);
        }

        .info-row {
            display: flex; justify-content: space-between; align-items: flex-start;
            padding: 0.45rem 0;
            border-bottom: 1px solid rgba(168,155,194,0.05);
        }
        .info-row:last-child { border-bottom: none; }

        .info-label {
            font-size: 0.52rem; letter-spacing: 0.12em;
            text-transform: uppercase; color: var(--muted);
            flex-shrink: 0; margin-right: 1rem;
        }

        .info-val { font-size: 0.68rem; color: var(--text); text-align: right; }
        .info-val.empty { color: var(--muted); font-style: italic; font-size: 0.62rem; }

        /* Account settings full-width */
        .profile-card-full {
            border: 1px solid var(--subtle);
            background: rgba(255,255,255,0.01);
            padding: 1.4rem 1.5rem;
            margin-bottom: 1rem;
        }

        .status-pill {
            font-size: 0.48rem; font-weight: 600;
            letter-spacing: 0.15em; text-transform: uppercase;
            padding: 0.2rem 0.55rem;
        }
        .pill-complete  { background: rgba(80,180,100,0.1);  color: #6dc87a; }
        .pill-cancelled { background: rgba(220,80,80,0.1);   color: #e07070; }

        /* Actions */
        .profile-actions {
            display: flex; gap: 0.75rem; margin-top: 1.5rem; flex-wrap: wrap;
        }

        .btn-kap {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.55rem; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            padding: 0.7rem 1.5rem; text-decoration: none;
            cursor: pointer; transition: all 0.2s; border: none;
            display: inline-flex; align-items: center; gap: 0.4rem;
        }
        .btn-kap-primary { background: #5a3d8a; color: #fff; }
        .btn-kap-primary:hover { background: #6b4aa0; color: #fff; }
        .btn-kap-gold { background: transparent; border: 1px solid var(--border); color: var(--gold); }
        .btn-kap-gold:hover { background: rgba(201,168,76,0.07); }
        .btn-kap-outline { background: transparent; border: 1px solid var(--subtle); color: var(--muted); }
        .btn-kap-outline:hover { border-color: var(--gold); color: var(--gold); }

        @media (max-width: 680px) {
            .profile-grid { grid-template-columns: 1fr; }
            .profile-hero { flex-direction: column; text-align: center; }
        }
    </style>
@endsection

@section('content')
<div class="profile-page">
    <div class="profile-wrap">

        @if(session('success'))
            <div class="flash">{{ session('success') }}</div>
        @endif

        @php $customer = DB::table('customer')->where('id', Auth::id())->first(); @endphp

        {{-- Hero --}}
        <div class="profile-hero">
            <div class="profile-avatar">
                @if(Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default.jpg')
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="">
                @else
                    <i class="fa-regular fa-user"></i>
                @endif
            </div>

            <div class="profile-hero-info">
                <h1>{{ Auth::user()->name }}</h1>
                <p class="hero-email">{{ Auth::user()->email }}</p>
                <span class="profile-badge">
                    <i class="fa-regular fa-circle-check"></i>
                    {{ ucfirst(Auth::user()->role ?? 'Customer') }} Account
                </span>
            </div>

            <a href="{{ route('customer.profile.edit') }}" class="btn-edit-profile">
                <i class="fa-regular fa-pen-to-square"></i> Edit Profile
            </a>
        </div>

        {{-- Info Cards --}}
        <div class="profile-grid">

            <div class="profile-card">
                <div class="card-title">Personal Information</div>
                <div class="info-row">
                    <span class="info-label">First Name</span>
                    <span class="info-val {{ $customer ? '' : 'empty' }}">{{ $customer->fname ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Name</span>
                    <span class="info-val {{ $customer ? '' : 'empty' }}">{{ $customer->lname ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-val {{ $customer?->phone ? '' : 'empty' }}">{{ $customer->phone ?? 'Not set' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Member Since</span>
                    <span class="info-val">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                </div>
            </div>

            <div class="profile-card">
                <div class="card-title">Shipping Address</div>
                <div class="info-row">
                    <span class="info-label">Street</span>
                    <span class="info-val {{ $customer?->addressline ? '' : 'empty' }}">{{ $customer->addressline ?? 'Not set' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">City / Town</span>
                    <span class="info-val {{ $customer?->town ? '' : 'empty' }}">{{ $customer->town ?? 'Not set' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Zip Code</span>
                    <span class="info-val {{ $customer?->zipcode ? '' : 'empty' }}">{{ $customer->zipcode ?? 'Not set' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Country</span>
                    <span class="info-val">Philippines</span>
                </div>
            </div>

        </div>

        {{-- Account Settings --}}
        <div class="profile-card-full">
            <div class="card-title">Account Settings</div>
            <div class="info-row">
                <span class="info-label">Email Address</span>
                <span class="info-val">{{ Auth::user()->email }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Account Status</span>
                <span class="info-val">
                    @if(Auth::user()->is_active)
                        <span class="status-pill pill-complete">Active</span>
                    @else
                        <span class="status-pill pill-cancelled">Inactive</span>
                    @endif
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Role</span>
                <span class="info-val">{{ ucfirst(Auth::user()->role ?? 'Customer') }}</span>
            </div>
        </div>

        {{-- Actions --}}
        <div class="profile-actions">
            <a href="{{ route('home') }}" class="btn-kap btn-kap-primary">
                <i class="fa-regular fa-shop"></i> Browse Shop
            </a>
            <a href="{{ route('customer.profile.edit') }}" class="btn-kap btn-kap-gold">
                <i class="fa-regular fa-pen-to-square"></i> Edit Profile
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-kap btn-kap-outline">
                    <i class="fa-regular fa-arrow-right-from-bracket"></i> Sign Out
                </button>
            </form>
        </div>

    </div>
</div>
@endsection