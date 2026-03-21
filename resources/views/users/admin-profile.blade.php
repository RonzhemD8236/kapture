@extends('layouts.admin-base')

@section('body')
<style>
    .ap-page {
        background: var(--kapture-black);
        min-height: 100vh;
        padding: 2.5rem 2rem;
        font-family: 'Montserrat', sans-serif;
        color: var(--kapture-text);
    }
    .ap-wrap { max-width: 900px; margin: 0 auto; }

    .flash {
        background: rgba(201,168,76,0.07);
        border: 1px solid rgba(201,168,76,0.25);
        color: var(--kapture-gold);
        font-size: 0.62rem; letter-spacing: 0.08em;
        padding: 0.75rem 1rem; margin-bottom: 1.5rem;
    }

    /* ── Hero ── */
    .ap-hero {
        display: flex; align-items: center; gap: 1.75rem;
        padding-bottom: 2rem; margin-bottom: 2rem;
        border-bottom: 1px solid var(--kapture-border);
    }
    .ap-avatar {
        width: 88px; height: 88px; border-radius: 50%;
        border: 2px solid rgba(201,168,76,0.3);
        overflow: hidden; flex-shrink: 0;
        background: rgba(255,255,255,0.03);
        display: flex; align-items: center; justify-content: center;
        color: var(--kapture-muted); font-size: 2rem;
    }
    .ap-avatar img { width:100%; height:100%; object-fit:cover; }
    .ap-hero-info { flex: 1; }
    .ap-hero-info h1 {
        font-family: 'Cormorant Garamond', serif;
        font-size: 2rem; font-weight: 300;
        color: #fff; margin: 0 0 0.2rem; line-height: 1;
    }
    .ap-email { font-size: 0.62rem; color: var(--kapture-muted); letter-spacing: 0.06em; margin-bottom: 0.5rem; }
    .ap-badge {
        display: inline-flex; align-items: center; gap: 0.35rem;
        font-size: 0.5rem; font-weight: 600; letter-spacing: 0.2em; text-transform: uppercase;
        color: var(--kapture-gold); border: 1px solid rgba(201,168,76,0.25); padding: 0.2rem 0.65rem;
    }
    .btn-edit-profile {
        display: inline-flex; align-items: center; gap: 0.4rem;
        font-family: 'Montserrat', sans-serif;
        font-size: 0.55rem; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase;
        background: transparent; border: 1px solid var(--kapture-border-subtle);
        color: var(--kapture-muted); padding: 0.55rem 1.1rem;
        text-decoration: none; cursor: pointer; transition: all 0.2s;
    }
    .btn-edit-profile:hover { border-color: var(--kapture-gold); color: var(--kapture-gold); }

    /* ── View cards ── */
    .ap-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .ap-card { border: 1px solid var(--kapture-border-subtle); background: rgba(255,255,255,0.01); padding: 1.4rem 1.5rem; }
    .card-title {
        font-size: 0.5rem; font-weight: 600; letter-spacing: 0.25em; text-transform: uppercase;
        color: var(--kapture-gold); padding-bottom: 0.6rem; margin-bottom: 1.1rem;
        border-bottom: 1px solid var(--kapture-border-subtle);
    }
    .info-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 0.45rem 0; border-bottom: 1px solid rgba(168,155,194,0.05);
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 0.52rem; letter-spacing: 0.12em; text-transform: uppercase; color: var(--kapture-muted); }
    .info-val { font-size: 0.68rem; color: var(--kapture-text); text-align: right; }
    .info-val.empty { color: var(--kapture-muted); font-style: italic; font-size: 0.62rem; }
    .status-pill { font-size: 0.48rem; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; padding: 0.2rem 0.55rem; }
    .pill-active   { background: rgba(80,180,100,0.1); color: #6dc87a; }
    .pill-inactive { background: rgba(220,80,80,0.1);  color: #e07070; }

    /* ── Edit section ── */
    .ap-edit-section { display: none; }
    .ap-edit-section.open { display: block; }

    /* Edit card — matches customer profile-edit */
    .edit-wrap {
        width: 100%;
        border: 1px solid rgba(168,155,194,0.08);
        background: #0d0b1c;
        box-shadow: 0 40px 80px rgba(0,0,0,0.5);
    }
    .edit-head {
        padding: 1.5rem 2.5rem;
        border-bottom: 1px solid rgba(168,155,194,0.1);
        display: flex; align-items: center; justify-content: space-between;
    }
    .edit-head-title {
        font-family: 'Cormorant Garamond', serif;
        font-size: 1.6rem; font-weight: 300; color: #fff; margin: 0; line-height: 1;
    }
    .edit-head-sub { font-size: 0.58rem; color: var(--kapture-muted); font-style: italic; margin: 0.2rem 0 0; }
    .edit-body { padding: 2rem 2.5rem; }

    /* Photo row */
    .photo-upload-row {
        display: flex; align-items: center; gap: 1.25rem;
        margin-bottom: 1.75rem; padding-bottom: 1.75rem;
        border-bottom: 1px solid rgba(168,155,194,0.1);
    }
    .photo-circle {
        width: 72px; height: 72px; border-radius: 50%;
        border: 2px dashed rgba(201,168,76,0.3);
        background: rgba(255,255,255,0.02);
        display: flex; align-items: center; justify-content: center;
        color: var(--kapture-muted); font-size: 1.5rem;
        overflow: hidden; flex-shrink: 0; cursor: pointer; transition: border-color 0.2s;
    }
    .photo-circle:hover { border-color: rgba(201,168,76,0.6); }
    .photo-circle img { width:100%; height:100%; object-fit:cover; }
    .photo-label { font-size: 0.55rem; font-weight: 600; letter-spacing: 0.15em; text-transform: uppercase; color: var(--kapture-text); margin-bottom: 0.2rem; }
    .photo-hint { font-size: 0.55rem; color: var(--kapture-muted); line-height: 1.6; }
    .photo-btn {
        display: inline-block; margin-top: 0.5rem;
        background: transparent; border: 1px solid rgba(168,155,194,0.15);
        color: var(--kapture-muted); font-family: 'Montserrat', sans-serif;
        font-size: 0.52rem; letter-spacing: 0.15em; text-transform: uppercase;
        padding: 0.35rem 0.8rem; cursor: pointer; transition: all 0.2s;
    }
    .photo-btn:hover { border-color: var(--kapture-gold); color: var(--kapture-gold); }

    /* Fields */
    .fields-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 0.85rem 1rem; }
    .field-full { grid-column: 1 / -1; }
    .field label {
        display: block; font-size: 0.52rem; font-weight: 600;
        letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--kapture-muted); margin-bottom: 0.4rem;
    }
    .field input {
        width: 100%; background: rgba(255,255,255,0.025);
        border: 1px solid rgba(168,155,194,0.12); color: var(--kapture-text);
        font-family: 'Montserrat', sans-serif; font-size: 0.72rem; padding: 0.65rem 0.9rem;
        outline: none; border-radius: 0; transition: border-color 0.2s, background 0.2s;
    }
    .field input::placeholder { color: var(--kapture-muted); opacity: 0.4; }
    .field input:focus { border-color: rgba(201,168,76,0.35); background: rgba(201,168,76,0.025); }
    .field input.is-invalid { border-color: rgba(220,80,80,0.5); }
    .field .invalid-feedback { font-size:0.55rem; color:#e07070; margin-top:0.3rem; display:block; }
    .field input[readonly] { opacity:0.5; cursor:not-allowed; }

    .edit-divider { border:none; border-top:1px solid rgba(168,155,194,0.1); margin:1.25rem 0; }

    .edit-footer {
        display: flex; align-items: center; justify-content: space-between;
        margin-top: 2rem; padding-top: 1.5rem;
        border-top: 1px solid rgba(168,155,194,0.1);
    }
    .btn-back {
        font-size: 0.55rem; letter-spacing: 0.12em; text-transform: uppercase;
        color: var(--kapture-muted); background: none; border: none;
        cursor: pointer; text-decoration: none; transition: color 0.2s;
    }
    .btn-back:hover { color: var(--kapture-text); }
    .btn-save {
        background: #5a3d8a; border: none; color: #fff;
        font-family: 'Montserrat', sans-serif; font-size: 0.58rem; font-weight: 600;
        letter-spacing: 0.25em; text-transform: uppercase;
        padding: 0.85rem 2.5rem; cursor: pointer; transition: background 0.25s;
    }
    .btn-save:hover { background: #6b4aa0; }

    @media(max-width:680px){
        .ap-grid { grid-template-columns: 1fr; }
        .ap-hero { flex-direction: column; text-align: center; }
        .fields-grid { grid-template-columns: 1fr; }
        .edit-body { padding: 1.5rem; }
        .edit-head { padding: 1.25rem 1.5rem; }
    }
</style>

<div class="ap-page">
<div class="ap-wrap">

    @if(session('success'))
        <div class="flash">{{ session('success') }}</div>
    @endif

    {{-- Hero --}}
    <div class="ap-hero" id="heroSection">
        <div class="ap-avatar">
            @if(Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default.jpg')
                <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="">
            @else
                <i class="bi bi-person"></i>
            @endif
        </div>
        <div class="ap-hero-info">
            <h1>{{ Auth::user()->name }}</h1>
            <p class="ap-email">{{ Auth::user()->email }}</p>
            <span class="ap-badge"><i class="bi bi-shield-check"></i> Administrator</span>
        </div>
        <button class="btn-edit-profile" onclick="toggleEdit()">
            <i class="bi bi-pencil"></i>
            <span id="editBtnText">Edit Profile</span>
        </button>
    </div>

    {{-- View Mode --}}
    <div id="viewSection">
        <div class="ap-grid">
            <div class="ap-card">
                <div class="card-title">Personal Information</div>
                <div class="info-row">
                    <span class="info-label">First Name</span>
                    <span class="info-val {{ Auth::user()->fname ? '' : 'empty' }}">{{ Auth::user()->fname ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Last Name</span>
                    <span class="info-val {{ Auth::user()->lname ? '' : 'empty' }}">{{ Auth::user()->lname ?? '—' }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Member Since</span>
                    <span class="info-val">{{ Auth::user()->created_at->format('M d, Y') }}</span>
                </div>
            </div>
            <div class="ap-card">
                <div class="card-title">Account Settings</div>
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-val">{{ Auth::user()->email }}</span>
                </div>
                <div class="info-row">
                    <span class="info-label">Status</span>
                    <span class="info-val">
                        @if(Auth::user()->is_active)
                            <span class="status-pill pill-active">Active</span>
                        @else
                            <span class="status-pill pill-inactive">Inactive</span>
                        @endif
                    </span>
                </div>
                <div class="info-row">
                    <span class="info-label">Role</span>
                    <span class="info-val">Administrator</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Mode --}}
    <div id="editSection" class="ap-edit-section">
        <div class="edit-wrap">
            <div class="edit-body">
                <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Photo --}}
                    <div class="photo-upload-row">
                        <label for="profile_photo" class="photo-circle">
                            @if(Auth::user()->profile_photo && Auth::user()->profile_photo !== 'default.jpg')
                                <img id="photoPreview" src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="">
                            @else
                                <img id="photoPreview" src="" alt="" style="display:none;">
                                <i class="bi bi-person" id="photoIcon"></i>
                            @endif
                        </label>
                        <div>
                            <p class="photo-label">Profile Photo</p>
                            <p class="photo-hint">JPG, PNG or WEBP — max 2MB</p>
                            <label for="profile_photo" class="photo-btn">
                                <i class="bi bi-camera" style="margin-right:0.35rem;"></i>Change Photo
                            </label>
                            <input type="file" id="profile_photo" name="profile_photo" accept="image/*" style="display:none;">
                        </div>
                    </div>

                    {{-- Fields --}}
                    <div class="fields-grid">
                        <div class="field">
                            <label>First Name</label>
                            <input type="text" name="fname"
                                value="{{ old('fname', Auth::user()->fname) }}"
                                placeholder="First name" required
                                class="{{ $errors->has('fname') ? 'is-invalid' : '' }}">
                            @error('fname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="field">
                            <label>Last Name</label>
                            <input type="text" name="lname"
                                value="{{ old('lname', Auth::user()->lname) }}"
                                placeholder="Last name" required
                                class="{{ $errors->has('lname') ? 'is-invalid' : '' }}">
                            @error('lname')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="field field-full">
                            <label>Email Address</label>
                            <input type="email" name="email"
                                value="{{ old('email', Auth::user()->email) }}"
                                placeholder="your@email.com" required
                                class="{{ $errors->has('email') ? 'is-invalid' : '' }}">
                            @error('email')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>

                        <div class="field field-full">
                            <label>Role</label>
                            <input type="text" value="Administrator" readonly>
                        </div>
                    </div>

                    <hr class="edit-divider">
                    <p class="card-title">Change Password <span style="font-weight:400;opacity:0.5;">(leave blank to keep current)</span></p>

                    <div class="fields-grid">
                        <div class="field">
                            <label>New Password</label>
                            <input type="password" name="password" placeholder="Min. 8 characters"
                                class="{{ $errors->has('password') ? 'is-invalid' : '' }}">
                            @error('password')<span class="invalid-feedback">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label>Confirm Password</label>
                            <input type="password" name="password_confirmation" placeholder="Repeat password">
                        </div>
                    </div>

                    <div class="edit-footer">
                        <button type="button" class="btn-back" onclick="toggleEdit()">← Cancel</button>
                        <button type="submit" class="btn-save">Save Changes</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

</div>
</div>

@push('scripts')
<script>
    var hasErrors = {{ $errors->any() ? 'true' : 'false' }};
    if (hasErrors) {
        document.getElementById('editSection').classList.add('open');
        document.getElementById('viewSection').style.display = 'none';
        document.getElementById('heroSection').style.display = 'none';
        document.getElementById('editBtnText').textContent = 'Cancel';
    }

    function toggleEdit() {
        const edit = document.getElementById('editSection');
        const view = document.getElementById('viewSection');
        const hero = document.getElementById('heroSection');
        const btn  = document.getElementById('editBtnText');
        if (edit.classList.contains('open')) {
            edit.classList.remove('open');
            view.style.display = '';
            hero.style.display = '';
            btn.textContent = 'Edit Profile';
        } else {
            edit.classList.add('open');
            view.style.display = 'none';
            hero.style.display = 'none';
            btn.textContent = 'Cancel';
        }
    }

    document.getElementById('profile_photo').addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;
        const reader = new FileReader();
        reader.onload = e => {
            const img  = document.getElementById('photoPreview');
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