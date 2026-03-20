@extends('layouts.base')

@section('head')
    @parent
    <style>
        :root {
            --black: #07070d; --panel: #0d0b1c;
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
            padding: 3rem 2rem;
            font-family: 'Montserrat', sans-serif;
        }

        .profile-wrap {
            max-width: 860px;
            margin: 0 auto;
        }

        /* Header */
        .profile-header {
            display: flex;
            align-items: center;
            gap: 1.75rem;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
            border-bottom: 1px solid var(--border);
        }

        .profile-avatar {
            width: 90px; height: 90px;
            border-radius: 50%;
            border: 2px solid rgba(201,168,76,0.3);
            overflow: hidden;
            flex-shrink: 0;
            background: rgba(255,255,255,0.03);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: 2rem;
        }

        .profile-avatar img {
            width: 100%; height: 100%; object-fit: cover;
        }

        .profile-info h1 {
            font-family: 'Cormorant Garamond', serif;
            font-size: 2rem; font-weight: 300;
            color: #fff; margin: 0 0 0.25rem;
            line-height: 1;
        }

        .profile-info p {
            font-size: 0.62rem; color: var(--muted);
            letter-spacing: 0.08em; margin: 0;
        }

        .profile-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.35rem;
            font-size: 0.5rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            color: var(--gold);
            border: 1px solid rgba(201,168,76,0.25);
            padding: 0.2rem 0.6rem;
            margin-top: 0.5rem;
        }

        /* Cards */
        .profile-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .profile-card {
            border: 1px solid var(--subtle);
            background: rgba(255,255,255,0.01);
            padding: 1.5rem;
        }

        .profile-card-title {
            font-size: 0.52rem;
            font-weight: 600;
            letter-spacing: 0.22em;
            text-transform: uppercase;
            color: var(--gold);
            margin-bottom: 1.25rem;
            padding-bottom: 0.6rem;
            border-bottom: 1px solid var(--subtle);
        }

        .profile-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(168,155,194,0.05);
        }

        .profile-row:last-child { border-bottom: none; }

        .profile-row-label {
            font-size: 0.55rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            color: var(--muted);
        }

        .profile-row-val {
            font-size: 0.7rem;
            color: var(--text);
            text-align: right;
        }

        /* Buttons */
        .profile-actions {
            display: flex;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .btn-kap {
            font-family: 'Montserrat', sans-serif;
            font-size: 0.55rem;
            font-weight: 600;
            letter-spacing: 0.2em;
            text-transform: uppercase;
            padding: 0.7rem 1.5rem;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            border: none;
        }

        .btn-kap-primary { background: #5a3d8a; color: #fff; }
        .btn-kap-primary:hover { background: #6b4aa0; color: #fff; }

        .btn-kap-outline {
            background: transparent;
            border: 1px solid var(--subtle);
            color: var(--muted);
        }
        .btn-kap-outline:hover { border-color: var(--gold); color: var(--gold); }

        @media (max-width: 640px) {
            .profile-grid { grid-template-columns: 1fr; }
            .profile-header { flex-direction: column; text-align: center; }
        }
    </style>
@endsection

@section('body')
<div class="profile-page">
    <div class="profile-wrap">

        {{-- Flash messages --}}
        @if(session('success'))
            <div style="background:rgba(201,168,76,0.08);border:1px solid rgba(201,168,76,0.25);color:var(--gold);font-size:0.65rem;letter-spacing:0.08em;padding:0.75rem 1rem;margin-bottom:1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Profile Header --}}
        <div class="profile-header">
            <div class="profile-avatar">
                @if(Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default.jpg')
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="{{ Auth::user()->name }}">
                @else
                    <i class="fa-regular fa-user"></i>
                @endif
            </div>
            <div class="profile-info">
                <h1>{{ Auth::user()->name }}</h1>
                <p>{{ Auth::user()->email }}</p>
                <span class="profile-badge">
                    <i class="fa-regular fa-circle-check"></i>
                    {{ ucfirst(Auth::user()->role ?? 'Customer') }} Account
                </span>
            </div>
        </div>

        {{-- Info Cards --}}
        <div class="profile-grid">

            <div class="profile-card">
                <p class="profile-card-title">Account Details</p>
                <div class="profile-row">
                    <span class="profile-row-label">Full Name</span>
                    <span class="profile-row-val">{{ Auth::user()->name }}</span>
                </div>
                <div class="profile-row">
                    <span class="profile-row-label">Email</span>
                    <span class="profile-row-val">{{ Auth::user()->email }}</span>
                </div>
                <div class="profile-row">
                    <span class="profile-row-label">Member Since</span>
                    <span class="profile-row-val">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                </div>
                <div class="profile-row">
                    <span class="profile-row-label">Role</span>
                    <span class="profile-row-val">{{ ucfirst(Auth::user()->role ?? 'Customer') }}</span>
                </div>
            </div>

            <div class="profile-card">
                <p class="profile-card-title">Order Summary</p>
                <div class="profile-row">
                    <span class="profile-row-label">Total Orders</span>
                    <span class="profile-row-val">
                        {{ DB::table('orders')->where('customer_id', Auth::user()->id)->count() }}
                    </span>
                </div>
                <div class="profile-row">
                    <span class="profile-row-label">Pending</span>
                    <span class="profile-row-val">
                        {{ DB::table('orders')->where('customer_id', Auth::user()->id)->where('status','pending')->count() }}
                    </span>
                </div>
                <div class="profile-row">
                    <span class="profile-row-label">Completed</span>
                    <span class="profile-row-val">
                        {{ DB::table('orders')->where('customer_id', Auth::user()->id)->where('status','completed')->count() }}
                    </span>
                </div>
                <div class="profile-row">
                    <span class="profile-row-label">Total Spent</span>
                    <span class="profile-row-val">
                        ₱{{ number_format(DB::table('orders as o')->join('order_items as oi','o.order_id','=','oi.order_id')->where('o.customer_id', Auth::user()->id)->sum('oi.subtotal'), 2) }}
                    </span>
                </div>
            </div>

        </div>

        {{-- Actions --}}
        <div class="profile-actions">
            <a href="{{ route('home') }}" class="btn-kap btn-kap-primary">Browse Shop</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-kap btn-kap-outline">Sign Out</button>
            </form>
        </div>

    </div>
</div>
@endsection