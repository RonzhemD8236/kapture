<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Your Kapture Account</title>
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #07070d;
            font-family: 'Georgia', serif;
            color: #d4cfe0;
            padding: 40px 20px;
        }

        .wrapper {
            max-width: 560px;
            margin: 0 auto;
        }

        /* Header */
        .header {
            text-align: center;
            padding-bottom: 32px;
            border-bottom: 1px solid rgba(201,168,76,0.2);
            margin-bottom: 40px;
        }

        .brand {
            font-family: 'Georgia', serif;
            font-size: 22px;
            font-weight: normal;
            letter-spacing: 8px;
            text-transform: uppercase;
            color: #fff;
        }

        .brand-sub {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #c9a84c;
            margin-top: 4px;
        }

        /* Card */
        .card {
            background: linear-gradient(145deg, #1a1535 0%, #120f28 50%, #0e0c1f 100%);
            border: 1px solid rgba(168,155,194,0.12);
            padding: 48px 48px 40px;
            text-align: center;
        }

        .icon-wrap {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            border: 1px solid rgba(201,168,76,0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 24px;
        }

        .icon-wrap img {
            width: 28px;
            height: 28px;
        }

        .title {
            font-family: 'Georgia', serif;
            font-size: 28px;
            font-weight: normal;
            color: #fff;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .subtitle {
            font-size: 12px;
            color: #6b6480;
            font-style: italic;
            letter-spacing: 1px;
            margin-bottom: 32px;
        }

        .divider {
            border: none;
            border-top: 1px solid rgba(168,155,194,0.1);
            margin: 0 0 32px;
        }

        .message {
            font-size: 13px;
            color: rgba(212,207,224,0.7);
            line-height: 1.8;
            margin-bottom: 32px;
        }

        .btn {
            display: inline-block;
            background: #c9a84c;
            color: #07070d !important;
            font-family: 'Georgia', serif;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 3px;
            text-transform: uppercase;
            text-decoration: none;
            padding: 16px 40px;
            margin-bottom: 32px;
        }

        .btn:hover { background: #e8c97a; }

        .note {
            font-size: 11px;
            color: #6b6480;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        .url-wrap {
            background: rgba(255,255,255,0.03);
            border: 1px solid rgba(168,155,194,0.1);
            padding: 12px 16px;
            margin-bottom: 24px;
        }

        .url-wrap a {
            font-size: 10px;
            color: #c9a84c;
            word-break: break-all;
            text-decoration: none;
        }

        /* Footer */
        .footer {
            text-align: center;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid rgba(201,168,76,0.1);
        }

        .footer p {
            font-size: 10px;
            color: #6b6480;
            letter-spacing: 1px;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <div class="wrapper">

        <!-- Header -->
        <div class="header">
            <div class="brand">Kapture</div>
            <div class="brand-sub">Premium Photography</div>
        </div>

        <!-- Card -->
        <div class="card">

            <div class="icon-wrap">
                <!-- envelope SVG in gold -->
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="2" y="4" width="20" height="16" rx="2" stroke="#c9a84c" stroke-width="1.5"/>
                    <path d="M2 7l10 7 10-7" stroke="#c9a84c" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </div>

            <h1 class="title">Verify Your Email</h1>
            <p class="subtitle">One last step to complete your registration</p>

            <hr class="divider">

            <p class="message">
                Thank you for joining Kapture.<br>
                Please click the button below to verify your email address and activate your account.
            </p>

            <a href="{{ $url }}" class="btn">Verify Email Address</a>

            <p class="note">
                If you did not create a Kapture account,<br>
                no further action is required.
            </p>

            <div class="url-wrap">
                <a href="{{ $url }}">{{ $url }}</a>
            </div>

        </div>

        <!-- Footer -->
        <div class="footer">
            <p>
                &copy; {{ date('Y') }} Kapture. All rights reserved.<br>
                This email was sent to verify your account registration.
            </p>
        </div>

    </div>
</body>
</html>