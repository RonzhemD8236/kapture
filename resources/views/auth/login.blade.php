@extends('layouts.customer')

@push('styles')
<style>
    body { margin: 0; }

    :root {
        --black:  #07070d;
        --deep:   #100e20;
        --panel:  #0d0b1c;
        --gold:   #c9a84c;
        --gold-lt:#e8c97a;
        --lilac:  #a89bc2;
        --text:   #d4cfe0;
        --muted:  #6b6480;
        --border: rgba(201,168,76,0.18);
        --subtle: rgba(168,155,194,0.1);
    }

    .page {
        min-height: calc(100vh - 80px);
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        background:
            radial-gradient(ellipse 60% 55% at 15% 60%, rgba(80,40,140,0.18) 0%, transparent 65%),
            radial-gradient(ellipse 40% 40% at 85% 20%, rgba(201,168,76,0.05) 0%, transparent 60%),
            var(--black);
    }

    .login-card {
        display: grid;
        grid-template-columns: 1fr 1fr;
        width: 100%;
        max-width: 980px;
        min-height: 580px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.6);
        border: 1px solid rgba(168,155,194,0.08);
    }

    .lc-left {
        background: linear-gradient(145deg, #1a1535 0%, #120f28 50%, #0e0c1f 100%);
        padding: 3rem 2.75rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        position: relative;
        overflow: hidden;
    }

    .lc-left::before {
        content: '';
        position: absolute;
        inset: 0;
        background: radial-gradient(ellipse 70% 60% at 10% 90%, rgba(100,55,180,0.3) 0%, transparent 65%);
        pointer-events: none;
    }

    .lc-left::after {
        content: '';
        position: absolute;
        top: 1.5rem; left: 1.5rem; right: 1.5rem; bottom: 1.5rem;
        border: 1px solid rgba(168,155,194,0.08);
        pointer-events: none;
    }

    .lc-brand {
        position: relative; z-index: 1;
        font-family: 'Cormorant Garamond', serif;
        font-size: 1rem;
        font-weight: 400;
        letter-spacing: 0.5em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.9);
    }

    .lc-body { position: relative; z-index: 1; }

    .lc-heading {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2.2rem;
        font-weight: 600;
        line-height: 1.15;
        color: #fff;
        margin-bottom: 1rem;
    }

    .lc-desc {
        font-size: 0.68rem;
        font-style: italic;
        line-height: 1.9;
        color: rgba(212,207,224,0.55);
        margin-bottom: 2rem;
    }

    .lc-perks { list-style: none; display: flex; flex-direction: column; gap: 0.55rem; padding: 0; margin: 0; }

    .lc-perks li {
        display: flex;
        align-items: center;
        gap: 0.65rem;
        font-size: 0.63rem;
        color: rgba(212,207,224,0.5);
        letter-spacing: 0.02em;
    }

    .lc-perks li::before {
        content: '';
        width: 5px; height: 5px;
        border-radius: 50%;
        background: var(--gold);
        opacity: 0.75;
        flex-shrink: 0;
    }

    .lc-footer {
        position: relative; z-index: 1;
        font-size: 0.52rem;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: rgba(107,100,128,0.5);
    }

    .lc-right {
        background: var(--panel);
        padding: 3rem 3.25rem;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
    }

    .lc-right::before {
        content: '';
        position: absolute;
        top: 0; left: 0;
        width: 1px; height: 100%;
        background: linear-gradient(to bottom, transparent, rgba(201,168,76,0.15) 30%, rgba(201,168,76,0.15) 70%, transparent);
    }

    .lc-tabs {
        display: flex;
        gap: 2.5rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid var(--subtle);
    }

    .lc-tab {
        font-size: 0.58rem;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--muted);
        padding-bottom: 0.8rem;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
    }

    .lc-tab.active { color: var(--text); border-bottom-color: var(--gold); }

    .lc-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.85rem;
        font-weight: 300;
        color: #fff;
        margin-bottom: 0.3rem;
        line-height: 1;
    }

    .lc-sub {
        font-size: 0.6rem;
        color: var(--muted);
        font-style: italic;
        margin-bottom: 1.75rem;
        letter-spacing: 0.03em;
    }

    .lc-field { margin-bottom: 1.1rem; }

    .lc-field label {
        display: block;
        font-size: 0.53rem;
        font-weight: 600;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        color: var(--muted);
        margin-bottom: 0.5rem;
    }

    .lc-field input {
        width: 100%;
        background: rgba(255,255,255,0.025);
        border: 1px solid rgba(168,155,194,0.12);
        color: var(--text);
        font-family: 'Montserrat', sans-serif;
        font-size: 0.75rem;
        padding: 0.75rem 1rem;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
        border-radius: 0;
    }

    .lc-field input::placeholder { color: var(--muted); opacity: 0.5; }
    .lc-field input:focus {
        border-color: rgba(201,168,76,0.35);
        background: rgba(201,168,76,0.025);
    }
    .lc-field input.is-invalid { border-color: rgba(220,80,80,0.5); }

    .lc-field .invalid-feedback {
        font-size: 0.58rem;
        color: #e07070;
        margin-top: 0.35rem;
        display: block;
    }

    .lc-field-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.5rem;
    }

    .lc-remember { display: flex; align-items: center; gap: 0.45rem; cursor: pointer; }

    .lc-remember input[type=checkbox] {
        appearance: none;
        width: 12px; height: 12px;
        border: 1px solid rgba(168,155,194,0.25);
        background: transparent;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
        transition: border-color 0.2s, background 0.2s;
    }
    .lc-remember input[type=checkbox]:checked { border-color: var(--gold); background: var(--gold); }
    .lc-remember input[type=checkbox]:checked::after {
        content: '';
        position: absolute;
        left: 2px; top: 0;
        width: 5px; height: 8px;
        border: 1.5px solid #07070d;
        border-left: none; border-top: none;
        transform: rotate(45deg);
    }
    .lc-remember span { font-size: 0.56rem; color: var(--muted); letter-spacing: 0.06em; text-transform: uppercase; }

    .lc-forgot {
        font-size: 0.53rem;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--muted);
        text-decoration: none;
        transition: color 0.2s;
    }
    .lc-forgot:hover { color: var(--gold); }

    .lc-submit {
        width: 100%;
        background: #5a3d8a;
        border: none;
        color: #fff;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.58rem;
        font-weight: 600;
        letter-spacing: 0.25em;
        text-transform: uppercase;
        padding: 1rem;
        cursor: pointer;
        transition: background 0.25s;
        margin-bottom: 1.5rem;
    }
    .lc-submit:hover { background: #6b4aa0; }

    .lc-signup {
        text-align: center;
        font-size: 0.58rem;
        color: var(--muted);
        letter-spacing: 0.06em;
        margin: 0;
    }
    .lc-signup a {
        color: var(--gold);
        text-decoration: none;
        font-weight: 500;
        margin-left: 0.3rem;
        transition: color 0.2s;
    }
    .lc-signup a:hover { color: var(--gold-lt); }

    @media (max-width: 760px) {
        .login-card { grid-template-columns: 1fr; }
        .lc-left { display: none; }
        .lc-right { padding: 2.5rem 1.75rem; }
    }
</style>
@endpush

@section('content')
<div class="page">
    <div class="login-card">

        {{-- LEFT --}}
        <div class="lc-left">
            <div class="lc-brand">Kapture</div>

            <div class="lc-body">
                <h1 class="lc-heading">The Atelier<br>Membership</h1>
                <p class="lc-desc">Access to an exclusive world of premium photography<br>instruments, private events, and curated services.</p>
                <ul class="lc-perks">
                    <li>Early access to new arrivals &amp; limited editions</li>
                    <li>Members-only workshop invitations</li>
                    <li>Priority repair &amp; CLA scheduling</li>
                    <li>Lifetime complimentary sensor cleaning</li>
                    <li>KAPTURE Atelier darkroom access</li>
                    <li>Exclusive member pricing on trade-ins</li>
                </ul>
            </div>

            <div class="lc-footer">&copy; {{ date('Y') }} Kapture. All rights reserved.</div>
        </div>

        {{-- RIGHT --}}
        <div class="lc-right">

            <div class="lc-tabs">
                <span class="lc-tab active">Sign In</span>
            </div>

            <h2 class="lc-title">Welcome Back</h2>
            <p class="lc-sub">Sign in to your Kapture account</p>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="lc-field">
                    <label for="email">Email Address</label>
                    <input
                        id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="your@email.com"
                        required autocomplete="email" autofocus
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="lc-field">
                    <label for="password">Password</label>
                    <input
                        id="password" type="password" name="password"
                        placeholder="••••••••••"
                        required autocomplete="current-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
                <br>

                <button type="submit" class="lc-submit">Sign In to Your Account</button>
            </form>

            <p class="lc-signup">
                Don't have an account?
                <a href="{{ route('register') }}">Sign Up</a>
            </p>

        </div>
    </div>
</div>
@endsection