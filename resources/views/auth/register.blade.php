@extends('layouts.customer')

@push('styles')
<style>
    :root {
        --black:#07070d;--deep:#100e20;--panel:#0d0b1c;
        --gold:#c9a84c;--gold-lt:#e8c97a;--text:#d4cfe0;
        --muted:#6b6480;--subtle:rgba(168,155,194,0.1);
    }
    .page {
        min-height: calc(100vh - 80px);
        display: flex; align-items: center; justify-content: center;
        padding: 2rem;
        background:
            radial-gradient(ellipse 60% 55% at 85% 40%, rgba(80,40,140,0.18) 0%, transparent 65%),
            radial-gradient(ellipse 40% 40% at 15% 80%, rgba(201,168,76,0.05) 0%, transparent 60%),
            var(--black);
    }
    .reg-card {
        display: grid; grid-template-columns: 1fr 1fr;
        width: 100%; max-width: 980px; min-height: 560px;
        box-shadow: 0 40px 100px rgba(0,0,0,0.6);
        border: 1px solid rgba(168,155,194,0.08);
    }
    .rc-left {
        background: linear-gradient(145deg,#1a1535 0%,#120f28 50%,#0e0c1f 100%);
        padding: 3rem 2.75rem;
        display: flex; flex-direction: column; justify-content: space-between;
        position: relative; overflow: hidden;
    }
    .rc-left::before {
        content:''; position:absolute; inset:0;
        background: radial-gradient(ellipse 70% 60% at 90% 10%, rgba(100,55,180,0.3) 0%, transparent 65%);
        pointer-events:none;
    }
    .rc-left::after {
        content:''; position:absolute;
        top:1.5rem;left:1.5rem;right:1.5rem;bottom:1.5rem;
        border:1px solid rgba(168,155,194,0.08); pointer-events:none;
    }
    .rc-brand { position:relative;z-index:1;font-family:'Cormorant Garamond',serif;font-size:1rem;font-weight:400;letter-spacing:.5em;text-transform:uppercase;color:rgba(255,255,255,.9); }
    .rc-body { position:relative;z-index:1; }
    .rc-heading { font-family:'Cormorant Garamond',serif;font-size:2.2rem;font-weight:600;line-height:1.15;color:#fff;margin-bottom:1rem; }
    .rc-desc { font-size:.68rem;font-style:italic;line-height:1.9;color:rgba(212,207,224,.55);margin-bottom:2rem; }
    .rc-steps { list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:.9rem; }
    .rc-steps li { display:flex;align-items:flex-start;gap:.75rem;font-size:.63rem;color:rgba(212,207,224,.5); }
    .rc-step-num { width:18px;height:18px;border-radius:50%;border:1px solid rgba(201,168,76,.4);color:var(--gold);font-size:.5rem;font-weight:600;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:1px; }
    .rc-footer { position:relative;z-index:1;font-size:.52rem;letter-spacing:.1em;text-transform:uppercase;color:rgba(107,100,128,.5); }

    .rc-right {
        background:var(--panel);padding:3rem 3.25rem;
        display:flex;flex-direction:column;justify-content:center;position:relative;
    }
    .rc-right::before { content:'';position:absolute;top:0;left:0;width:1px;height:100%;background:linear-gradient(to bottom,transparent,rgba(201,168,76,.15) 30%,rgba(201,168,76,.15) 70%,transparent); }

    .rc-tabs { display:flex;gap:2.5rem;margin-bottom:2rem;border-bottom:1px solid var(--subtle); }
    .rc-tab { font-size:.58rem;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);padding-bottom:.8rem;border-bottom:2px solid transparent;margin-bottom:-1px;text-decoration:none;transition:color .2s; }
    .rc-tab.active { color:var(--text);border-bottom-color:var(--gold); }
    .rc-tab:hover { color:var(--text); }

    .rc-title { font-family:'Cormorant Garamond',serif;font-size:1.85rem;font-weight:300;color:#fff;margin-bottom:.3rem;line-height:1; }
    .rc-sub { font-size:.6rem;color:var(--muted);font-style:italic;margin-bottom:1.75rem; }

    .rc-field { margin-bottom:1.1rem; }
    .rc-field label { display:block;font-size:.53rem;font-weight:600;letter-spacing:.2em;text-transform:uppercase;color:var(--muted);margin-bottom:.5rem; }
    .rc-field input { width:100%;background:rgba(255,255,255,.025);border:1px solid rgba(168,155,194,.12);color:var(--text);font-family:'Montserrat',sans-serif;font-size:.75rem;padding:.75rem 1rem;outline:none;border-radius:0;transition:border-color .2s,background .2s; }
    .rc-field input::placeholder { color:var(--muted);opacity:.4; }
    .rc-field input:focus { border-color:rgba(201,168,76,.35);background:rgba(201,168,76,.025); }
    .rc-field input.is-invalid { border-color:rgba(220,80,80,.5); }
    .rc-field .invalid-feedback { font-size:.58rem;color:#e07070;margin-top:.35rem;display:block; }

    .rc-submit { width:100%;background:#5a3d8a;border:none;color:#fff;font-family:'Montserrat',sans-serif;font-size:.58rem;font-weight:600;letter-spacing:.25em;text-transform:uppercase;padding:1rem;cursor:pointer;transition:background .25s;margin-bottom:1.25rem; }
    .rc-submit:hover { background:#6b4aa0; }

    .rc-login { text-align:center;font-size:.58rem;color:var(--muted);letter-spacing:.06em;margin:0; }
    .rc-login a { color:var(--gold);text-decoration:none;font-weight:500;margin-left:.3rem;transition:color .2s; }
    .rc-login a:hover { color:var(--gold-lt); }

    @media(max-width:760px){.reg-card{grid-template-columns:1fr}.rc-left{display:none}.rc-right{padding:2.5rem 1.75rem}}
</style>
@endpush

@section('content')
<div class="page">
    <div class="reg-card">

        <div class="rc-left">
            <div class="rc-brand">Kapture</div>
            <div class="rc-body">
                <h1 class="rc-heading">Create Your<br>Account</h1>
                <p class="rc-desc">Join the Kapture community and unlock an exclusive world of premium photography.</p>
                <ul class="rc-steps">
                    <li><span class="rc-step-num">1</span> Register with your name, email &amp; password</li>
                    <li><span class="rc-step-num">2</span> Set up your profile — photo, address &amp; details</li>
                    <li><span class="rc-step-num">3</span> Start browsing our curated catalogue</li>
                </ul>
            </div>
            <div class="rc-footer">&copy; {{ date('Y') }} Kapture. All rights reserved.</div>
        </div>

        <div class="rc-right">
            <div class="rc-tabs">
                <a href="{{ route('login') }}" class="rc-tab">Sign In</a>
                <span class="rc-tab active">Create Account</span>
            </div>

            <h2 class="rc-title">Join Kapture</h2>
            <p class="rc-sub">Create your account to get started</p>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="rc-field">
                    <label for="fname">First Name</label>
                    <input id="fname" type="text" name="fname" value="{{ old('fname') }}"
                        placeholder="First name" required autofocus
                        class="{{ $errors->has('fname') ? 'is-invalid' : '' }}">
                    @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="rc-field">
                    <label for="lname">Last Name</label>
                    <input id="lname" type="text" name="lname" value="{{ old('lname') }}"
                        placeholder="Last name" required
                        class="{{ $errors->has('lname') ? 'is-invalid' : '' }}">
                    @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="rc-field">
                    <label for="email">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                        placeholder="your@email.com" required autocomplete="email"
                        class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                    @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="rc-field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password"
                        placeholder="Min. 8 characters" required autocomplete="new-password"
                        class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                    @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                </div>

                <div class="rc-field">
                    <label for="password-confirm">Confirm Password</label>
                    <input id="password-confirm" type="password" name="password_confirmation"
                        placeholder="Repeat password" required autocomplete="new-password">
                </div>

                <button type="submit" class="rc-submit">Create My Account</button>
            </form>

            <p class="rc-login">Already have an account?<a href="{{ route('login') }}">Sign In</a></p>
        </div>

    </div>
</div>
@endsection