@extends('layouts.base')

@section('head')
    @parent
    <style>
        :root {
            --black:#07070d;--panel:#0d0b1c;--gold:#c9a84c;--gold-lt:#e8c97a;
            --text:#d4cfe0;--muted:#6b6480;--subtle:rgba(168,155,194,0.1);
        }

        .edit-page {
            min-height: calc(100vh - 64px);
            display: flex; align-items: center; justify-content: center;
            padding: 2.5rem 1.5rem;
            background:
                radial-gradient(ellipse 55% 45% at 10% 70%, rgba(80,40,140,0.15) 0%, transparent 65%),
                var(--black);
        }

        .edit-card {
            width: 100%; max-width: 700px;
            border: 1px solid rgba(168,155,194,0.08);
            background: var(--panel);
            box-shadow: 0 40px 80px rgba(0,0,0,0.5);
        }

        .edit-head {
            padding: 1.5rem 2.5rem;
            border-bottom: 1px solid var(--subtle);
            display: flex; align-items: center; justify-content: space-between;
        }

        .edit-title {
            font-family: 'Cormorant Garamond', serif;
            font-size: 1.6rem; font-weight: 300;
            color: #fff; margin: 0; line-height: 1;
        }

        .edit-sub {
            font-size: 0.58rem; color: var(--muted);
            font-style: italic; margin: 0.2rem 0 0;
        }

        .edit-body { padding: 2rem 2.5rem; }

        /* Flash */
        .flash-success {
            background: rgba(201,168,76,0.08);
            border: 1px solid rgba(201,168,76,0.25);
            color: var(--gold);
            font-size: 0.62rem; letter-spacing: 0.06em;
            padding: 0.75rem 1rem; margin-bottom: 1.5rem;
        }

        /* Photo section */
        .photo-row {
            display: flex; align-items: center; gap: 1.25rem;
            margin-bottom: 1.75rem; padding-bottom: 1.75rem;
            border-bottom: 1px solid var(--subtle);
        }

        .photo-circle {
            width: 72px; height: 72px; border-radius: 50%;
            border: 2px dashed rgba(201,168,76,0.3);
            background: rgba(255,255,255,0.02);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: 1.5rem;
            overflow: hidden; flex-shrink: 0; cursor: pointer;
            transition: border-color 0.2s;
        }
        .photo-circle:hover { border-color: rgba(201,168,76,0.6); }
        .photo-circle img { width:100%;height:100%;object-fit:cover; }

        .photo-info .photo-label {
            font-size: 0.55rem; font-weight: 600;
            letter-spacing: 0.15em; text-transform: uppercase;
            color: var(--text); margin-bottom: 0.2rem;
        }
        .photo-hint { font-size: 0.55rem; color: var(--muted); line-height: 1.6; }
        .photo-btn {
            display: inline-block; margin-top: 0.5rem;
            background: transparent;
            border: 1px solid rgba(168,155,194,0.15);
            color: var(--muted);
            font-family: 'Montserrat', sans-serif;
            font-size: 0.52rem; letter-spacing: 0.15em;
            text-transform: uppercase; padding: 0.35rem 0.8rem;
            cursor: pointer; transition: all 0.2s;
        }
        .photo-btn:hover { border-color: var(--gold); color: var(--gold); }

        /* Fields */
        .fields-grid {
            display: grid; grid-template-columns: 1fr 1fr;
            gap: 0.85rem 1rem;
        }
        .field-full { grid-column: 1 / -1; }

        .field label {
            display: block; font-size: 0.52rem; font-weight: 600;
            letter-spacing: 0.18em; text-transform: uppercase;
            color: var(--muted); margin-bottom: 0.4rem;
        }
        .field input {
            width: 100%;
            background: rgba(255,255,255,0.025);
            border: 1px solid rgba(168,155,194,0.12);
            color: var(--text); font-family: 'Montserrat', sans-serif;
            font-size: 0.72rem; padding: 0.65rem 0.9rem;
            outline: none; border-radius: 0;
            transition: border-color 0.2s, background 0.2s;
        }
        .field input::placeholder { color: var(--muted); opacity: 0.4; }
        .field input:focus {
            border-color: rgba(201,168,76,0.35);
            background: rgba(201,168,76,0.025);
        }
        .field input.is-invalid { border-color: rgba(220,80,80,0.5); }
        .field .invalid-feedback { font-size:0.55rem;color:#e07070;margin-top:0.3rem;display:block; }

        .edit-footer {
            display: flex; align-items: center; justify-content: space-between;
            margin-top: 2rem; padding-top: 1.5rem;
            border-top: 1px solid var(--subtle);
        }

        .btn-back {
            font-size: 0.55rem; letter-spacing: 0.12em; text-transform: uppercase;
            color: var(--muted); text-decoration: none; transition: color 0.2s;
        }
        .btn-back:hover { color: var(--text); }

        .btn-save {
            background: #5a3d8a; border: none; color: #fff;
            font-family: 'Montserrat', sans-serif;
            font-size: 0.58rem; font-weight: 600;
            letter-spacing: 0.25em; text-transform: uppercase;
            padding: 0.85rem 2.5rem; cursor: pointer;
            transition: background 0.25s;
        }
        .btn-save:hover { background: #6b4aa0; }

        @media(max-width:600px){
            .fields-grid{grid-template-columns:1fr}
            .edit-body{padding:1.5rem}
            .edit-head{padding:1.25rem 1.5rem}
        }
    </style>
@endsection

@section('body')
<div class="edit-page">
    <div class="edit-card">

        <div class="edit-head">
            <div>
                <h2 class="edit-title">Edit Profile</h2>
                <p class="edit-sub">Update your personal information and photo</p>
            </div>
        </div>

        <div class="edit-body">

            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif

            <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Photo --}}
                <div class="photo-row">
                    <label for="profile_photo" class="photo-circle" id="photoCircle">
                        @if($user->profile_photo && $user->profile_photo !== 'default.jpg')
                            <img id="photoPreview" src="{{ asset('storage/' . $user->profile_photo) }}" alt="">
                        @else
                            <img id="photoPreview" src="" alt="" style="display:none;">
                            <i class="fa-regular fa-user" id="photoIcon"></i>
                        @endif
                    </label>
                    <div class="photo-info">
                        <p class="photo-label">Profile Photo</p>
                        <p class="photo-hint">JPG, PNG or WEBP — max 2MB</p>
                        <label for="profile_photo" class="photo-btn">
                            <i class="fa-regular fa-arrow-up-from-bracket" style="margin-right:0.35rem;"></i>Change Photo
                        </label>
                        <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display:none;">
                    </div>
                </div>

                {{-- Fields --}}
                <div class="fields-grid">

                    <div class="field field-full">
                        <label for="title">Title <span style="color:var(--muted);font-weight:400;">(Optional)</span></label>
                        <input id="title" type="text" name="title"
                            value="{{ old('title', $customer->title ?? '') }}"
                            placeholder="e.g. Mr., Ms., Dr.">
                    </div>

                    <div class="field">
                        <label for="fname">First Name</label>
                        <input id="fname" type="text" name="fname"
                            value="{{ old('fname', $customer->fname ?? '') }}"
                            placeholder="First name" required
                            class="{{ $errors->has('fname') ? 'is-invalid' : '' }}">
                        @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label for="lname">Last Name</label>
                        <input id="lname" type="text" name="lname"
                            value="{{ old('lname', $customer->lname ?? '') }}"
                            placeholder="Last name" required
                            class="{{ $errors->has('lname') ? 'is-invalid' : '' }}">
                        @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field field-full">
                        <label for="addressline">Address</label>
                        <input id="addressline" type="text" name="addressline"
                            value="{{ old('addressline', $customer->addressline ?? '') }}"
                            placeholder="Street address" required
                            class="{{ $errors->has('addressline') ? 'is-invalid' : '' }}">
                        @error('addressline')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label for="town">City / Town</label>
                        <input id="town" type="text" name="town"
                            value="{{ old('town', $customer->town ?? '') }}"
                            placeholder="City or town" required
                            class="{{ $errors->has('town') ? 'is-invalid' : '' }}">
                        @error('town')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field">
                        <label for="zipcode">Zip Code</label>
                        <input id="zipcode" type="text" name="zipcode"
                            value="{{ old('zipcode', $customer->zipcode ?? '') }}"
                            placeholder="e.g. 1800" required
                            class="{{ $errors->has('zipcode') ? 'is-invalid' : '' }}">
                        @error('zipcode')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                    <div class="field field-full">
                        <label for="phone">Phone Number</label>
                        <input id="phone" type="text" name="phone"
                            value="{{ old('phone', $customer->phone ?? '') }}"
                            placeholder="e.g. 09XX XXX XXXX" required
                            class="{{ $errors->has('phone') ? 'is-invalid' : '' }}">
                        @error('phone')<span class="invalid-feedback">{{ $message }}</span>@enderror
                    </div>

                </div>

                <div class="edit-footer">
                    <a href="{{ route('home') }}" class="btn-back">← Back to Shop</a>
                    <button type="submit" class="btn-save">Save Changes</button>
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
            const img = document.getElementById('photoPreview');
            const icon = document.getElementById('photoIcon');
            img.src = e.target.result;
            img.style.display = 'block';
            if (icon) icon.style.display = 'none';
        };
        reader.readAsDataURL(file);
    });
</script>
@endpush

@endsection