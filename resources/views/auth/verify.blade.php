<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KAPTURE — Verify Email</title>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Montserrat:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous"/>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; background: #07070d; font-family: 'Montserrat', sans-serif; }

        :root {
            --black: #07070d; --panel: #0d0b1c;
            --gold: #c9a84c; --gold-lt: #e8c97a;
            --text: #d4cfe0; --muted: #6b6480;
            --subtle: rgba(168,155,194,0.1);
        }

        .verify-page {
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center;
            padding: 2rem;
            background:
                radial-gradient(ellipse 60% 55% at 15% 60%, rgba(80,40,140,0.18) 0%, transparent 65%),
                radial-gradient(ellipse 40% 40% at 85% 20%, rgba(201,168,76,0.05) 0%, transparent 60%),
                var(--black);
        }

        .verify-card {
            width: 100%; max-width: 520px;
            border: 1px solid rgba(168,155,194,0.08);
            background: linear-gradient(145deg, #1a1535 0%, #120f28 50%, #0e0c1f 100%);
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
            padding: 3rem 3.5rem;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .verify-card::before {
            content: '';
            position: absolute; inset: 0;
            background: radial-gradient(ellipse 70% 60% at 10% 90%, rgba(100,55,180,0.3) 0%, transparent 65%);
            pointer-events: none;
        }

        .verify-card::after {
            content: '';
            position: absolute;
            top: 1.5rem; left: 1.5rem; right: 1.5rem; bottom: 1.5rem;
            border: 1px solid rgba(168,155,194,0.08);
            pointer-events: none;
        }

        .verify-card > * { position: relative; z-index: 1; }

        .verify-icon {
            width: 64px; height: 64px; border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.25);
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 1.75rem;
            color: var(--gold); font-size: 1.5rem;
        }

        .verify-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.85rem; font-weight: 300;
            color: #fff; margin-bottom: 0.5rem; line-height: 1;
        }

        .verify-sub {
            font-size: 0.6rem; color: var(--muted);
            font-style: italic; margin-bottom: 2rem;
            letter-spacing: 0.04em;
        }

        .verify-divider {
            border: none; border-top: 1px solid var(--subtle); margin: 1.75rem 0;
        }

        .verify-msg {
            font-size: 0.68rem; color: var(--text);
            line-height: 1.8; letter-spacing: 0.03em; margin-bottom: 1.5rem;
        }

        .verify-alert {
            background: rgba(201,168,76,0.07);
            border: 1px solid rgba(201,168,76,0.25);
            color: var(--gold);
            font-size: 0.62rem; letter-spacing: 0.06em;
            padding: 0.75rem 1rem; margin-bottom: 1.5rem; text-align: left;
        }

        .verify-resend-label {
            font-size: 0.58rem; color: var(--muted);
            letter-spacing: 0.06em; margin-bottom: 0.75rem;
        }

        .btn-resend {
            background: transparent;
            border: 1px solid rgba(201,168,76,0.3);
            color: var(--gold);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.56rem; font-weight: 600;
            letter-spacing: 0.2em; text-transform: uppercase;
            padding: 0.75rem 2rem; cursor: pointer;
            transition: all 0.2s; width: 100%;
        }
        .btn-resend:hover { background: rgba(201,168,76,0.08); border-color: var(--gold); }

        .verify-login {
            font-size: 0.56rem; color: var(--muted);
            margin-top: 1.25rem; letter-spacing: 0.06em;
        }
        .verify-login a { color: var(--gold); text-decoration: none; font-weight: 500; margin-left: 0.3rem; }
        .verify-login a:hover { color: var(--gold-lt); }
    </style>
</head>
<body>

<div class="verify-page">
    <div class="verify-card">

        <div class="verify-icon">
            <i class="fa-regular fa-envelope"></i>
        </div>

        <h2 class="verify-title">Verify Your Email</h2>
        <p class="verify-sub">One last step before you can access your account</p>

        <hr class="verify-divider">

        @if(session('resent'))
            <div class="verify-alert">
                <i class="fa-regular fa-circle-check" style="margin-right:0.4rem;"></i>
                A fresh verification link has been sent to your email address.
            </div>
        @endif

        <p class="verify-msg">
            A verification link has been sent to your email address.<br>
            Please check your inbox and click the link to activate your account.
        </p>

        <p class="verify-resend-label">Didn't receive the email?</p>

        <form method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit" class="btn-resend">
                <i class="fa-regular fa-paper-plane" style="margin-right:0.5rem;"></i>
                Resend Verification Email
            </button>
        </form>

        <p class="verify-login">
            Wrong account?
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sign out</a>
        </p>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
            @csrf
        </form>

    </div>
</div>

</body>
</html>