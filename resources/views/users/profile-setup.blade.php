@extends('layouts.base')

@section('head')
    @parent
    <style>
        :root {
            --black:#07070d;--panel:#0d0b1c;--gold:#c9a84c;--gold-lt:#e8c97a;
            --text:#d4cfe0;--muted:#6b6480;--subtle:rgba(168,155,194,0.1);
        }

        .setup-page {
            min-height: calc(100vh - 64px);
            display: flex; align-items: center; justify-content: center;
            padding: 2.5rem 1.5rem;
            background:
                radial-gradient(ellipse 55% 45% at 10% 70%, rgba(80,40,140,0.15) 0%, transparent 65%),
                radial-gradient(ellipse 40% 40% at 90% 20%, rgba(201,168,76,0.05) 0%, transparent 60%),
                var(--black);
        }

        .setup-card {
            width: 100%; max-width: 700px;
            border: 1px solid rgba(168,155,194,0.08);
            background: var(--panel);
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
        }

        /* Progress bar at top */
        .setup-progress {
            display: flex;
            border-bottom: 1px solid var(--subtle);
        }
        .setup-step {
            flex: 1; padding: .75rem 1rem;
            font-size: .5rem; font-weight: 600;
            letter-spacing: .18em; text-transform: uppercase;
            color: var(--muted); text-align: center;
            position: relative;
        }
        .setup-step.done { color: rgba(201,168,76,.5); }
        .setup-step.active { color: var(--gold); }
        .setup-step.active::after {
            content: '';
            position: absolute; bottom: -1px; left: 0; right: 0;
            height: 2px; background: var(--gold);
        }

        .setup-body { padding: 2.5rem 3rem; }

        .setup-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.75rem; font-weight: 300;
            color: #fff; margin-bottom: .25rem; line-height: 1;
        }
        .setup-sub {
            font-size: .6rem; color: var(--muted);
            font-style: italic; margin-bottom: 2rem;
        }

        /* Photo upload */
        .photo-upload-row {
            display: flex; align-items: center; gap: 1.25rem;
            margin-bottom: 1.75rem;
            padding-bottom: 1.75rem;
            border-bottom: 1px solid var(--subtle);
        }
        .photo-circle {
            width: 72px; height: 72px; border-radius: 50%;
            border: 2px dashed rgba(201,168,76,.3);
            background: rgba(255,255,255,.02);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: 1.5rem;
            overflow: hidden; flex-shrink: 0; cursor: pointer;
            transition: border-color .2s;
        }
        .photo-circle:hover { border-color: rgba(201,168,76,.6); }
        .photo-circle img { width:100%;height:100%;object-fit:cover;display:none; }
        .photo-info {}
        .photo-label {
            font-size: .55rem; font-weight: 600;
            letter-spacing: .15em; text-transform: uppercase;
            color: var(--text); margin-bottom: .25rem;
        }
        .photo-hint { font-size: .55rem; color: var(--muted); line-height: 1.6; }
        .photo-btn {
            display: inline-block; margin-top: .5rem;
            background: transparent;
            border: 1px solid rgba(168,155,194,.15);
            color: var(--muted);
            font-family: 'Montserrat', sans-serif;
            font-size: .52rem; letter-spacing: .15em;
            text-transform: uppercase; padding: .35rem .8rem;
            cursor: pointer; transition: all .2s;
        }
        .photo-btn:hover { border-color: var(--gold); color: var(--gold); }

        /* Fields grid */
        .fields-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: .85rem 1rem;
        }
        .field-full { grid-column: 1 / -1; }

        .field label {
            display: block; font-size: .52rem; font-weight: 600;
            letter-spacing: .18em; text-transform: uppercase;
            color: var(--muted); margin-bottom: .4rem;
        }
        .field input, .field select {
            width: 100%;
            background: rgba(255,255,255,.025);
            border: 1px solid rgba(168,155,194,.12);
            color: var(--text);
            font-family: 'Montserrat', sans-serif;
            font-size: .72rem; padding: .65rem .9rem;
            outline: none; border-radius: 0;
            transition: border-color .2s, background .2s;
        }
        .field input::placeholder { color: var(--muted); opacity: .4; }
        .field input:focus, .field select:focus {
            border-color: rgba(201,168,76,.35);
            background: rgba(201,168,76,.025);
        }
        .field input.is-invalid { border-color: rgba(220,80,80,.5); }
        .field .invalid-feedback { font-size:.55rem;color:#e07070;margin-top:.3rem;display:block; }

        .setup-footer {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 2rem; padding-top: 1.5rem;
            border-top: 1px solid var(--subtle);
        }
        .setup-skip {
            font-size: .55rem; letter-spacing: .12em; text-transform: uppercase;
            color: var(--muted); text-decoration: none; transition: color .2s;
        }
        .setup-skip:hover { color: var(--text); }

        .btn-setup {
            background: #5a3d8a; border: none; color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: .58rem; font-weight: 600;
            letter-spacing: .25em; text-transform: uppercase;
            padding: .85rem 2.5rem; cursor: pointer;
            transition: background .25s;
        }
        .btn-setup:hover { background: #6b4aa0; }

        @media(max-width:600px){
            .fields-grid{grid-template-columns:1fr}
            .setup-body{padding:2rem 1.5rem}
        }
    </style>
@endsection

@section('body')
<div class="setup-page">
    <div class="setup-card">

        {{-- Progress --}}
        <div class="setup-progress">
            <div class="setup-step done">① Account Created</div>
            <div class="setup-step active">② Profile Setup</div>
            <div class="setup-step">③ Start Shopping</div>
        </div>

        <div class="setup-body">
            <h2 class="setup-title">Set Up Your Profile</h2>
            <p class="setup-sub">Tell us a bit about yourself so we can personalise your experience</p>

            <form method="POST" action="{{ route('customer.profile.setup.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Photo --}}
                <div class="photo-upload-row">
                    <label for="profile_photo" class="photo-circle" id="photoCircle">
                        <img id="photoPreview" src="" alt="">
                        <i class="fa-regular fa-user" id="photoIcon"></i>
                    </label>
                    <div class="photo-info">
                        <p class="photo-label">Profile Photo</p>
                        <p class="photo-hint">Optional — JPG, PNG or WEBP, max 2MB</p>
                        <label for="profile_photo" class="photo-btn">
                            <i class="fa-regular fa-arrow-up-from-bracket" style="margin-right:.35rem;"></i>Choose Photo
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display:none;">
                    </div>
                </div>

                {{-- Fields --}}
                <div class="fields-grid">

                    <div class="field field-full">
                        <label for="title">Title <span style="color:var(--muted);font-weight:400;">(Optional)</span></label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}"
                            placeholder="e.g. Mr., Ms., Dr.">
                    </div>

                    <div class="field">
                        <label for="fname">First Name</label>
                        <input id="fname" type="text" name="fname" value="{{ old('fname', Auth::user()->fname) }}"
                            placeholder="First name" required
                            class="{{ $errors->has('fname') ? 'is-invalid' : '' }}">
                        @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label for="lname">Last Name</label>
                        <input id="lname" type="text" name="lname" value="{{ old('lname', Auth::user()->lname) }}"
                            placeholder="Last name" required
                            class="{{ $errors->has('lname') ? 'is-invalid' : '' }}">
                        @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field field-full">
                        <label for="addressline">Address</label>
                        <input id="addressline" type="text" name="addressline" value="{{ old('addressline') }}"
                            placeholder="Street address" required
                            class="{{ $errors->has('addressline') ? 'is-invalid' : '' }}">
                        @error('addressline')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label for="town">City / Town</label>
                        <input id="town" type="text" name="town" value="{{ old('town') }}"
                            placeholder="City or town" required
                            class="{{ $errors->has('town') ? 'is-invalid' : '' }}">
                        @error('town')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label for="zipcode">Zip Code</label>
                        <input id="zipcode" type="text" name="zipcode" value="{{ old('zipcode') }}"
                            placeholder="e.g. 1800" required
                            class="{{ $errors->has('zipcode') ? 'is-invalid' : '' }}">
                        @error('zipcode')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field field-full">
                        <label for="phone">Phone Number</label>
                        <input id="phone" type="text" name="phone" value="{{ old('phone') }}"
                            placeholder="e.g. 09XX XXX XXXX" required
                            class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                </div>

                <div class="setup-footer">
                    <a href="{{ route('home') }}" class="setup-skip">Skip for now →</a>
                    <button type="submit" class="btn-setup">Save &amp; Continue</button>
                </div>

            </form>
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.getElementById('profile_photo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('photoPreview').src = e.target.result;
            document.getElementById('photoPreview').style.display = 'block';
            document.getElementById('photoIcon').style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection