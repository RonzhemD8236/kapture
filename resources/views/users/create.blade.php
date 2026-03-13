@extends('layouts.admin-base')

@section('body')

<style>
    .kapture-page { background: var(--kapture-black); min-height: 100vh; padding: 3rem 2.5rem; font-family: 'Montserrat', sans-serif; color: var(--kapture-text); }

    .page-header { margin-bottom: 3rem; padding-bottom: 2rem; border-bottom: 1px solid var(--kapture-border); }
    .page-eyebrow { display: flex; align-items: center; gap: 0.75rem; margin-bottom: 0.75rem; }
    .page-eyebrow::before, .page-eyebrow::after { content: ''; flex: 0 0 40px; height: 1px; background: var(--kapture-gold); }
    .page-eyebrow span { font-size: 0.85rem; font-weight: 500; letter-spacing: 0.2em; text-transform: uppercase; color: var(--kapture-gold); }
    .page-title { font-family: 'Cormorant Garamond', serif; font-size: 3rem; font-weight: 300; color: #fff; margin: 0; line-height: 1.1; }
    .page-subtitle { font-size: 0.85rem; letter-spacing: 0.15em; text-transform: uppercase; color: var(--kapture-muted); margin-top: 0.5rem; font-style: italic; }

    .kap-two-col { display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: stretch; }
    .kap-panel { border: 1px solid var(--kapture-border-subtle); padding: 2rem; background: rgba(255,255,255,0.01); display: flex; flex-direction: column; }
    .kap-panel-right { justify-content: space-between; }
    .kap-panel-title { font-size: 0.6rem; font-weight: 500; letter-spacing: 0.25em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 1.75rem; padding-bottom: 0.75rem; border-bottom: 1px solid var(--kapture-border-subtle); }

    .kap-field { margin-bottom: 1.6rem; }
    .kap-label { display: block; font-size: 0.62rem; font-weight: 500; letter-spacing: 0.22em; text-transform: uppercase; color: var(--kapture-gold); margin-bottom: 0.55rem; }

    .kap-row { display: grid; grid-template-columns: 1fr 1fr; gap: 0 1.5rem; }

    .kap-input { width: 100%; background: transparent; border: none; border-bottom: 1px solid var(--kapture-border-subtle); color: var(--kapture-text); font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; padding: 0.45rem 0; outline: none; transition: border-color 0.3s; }
    .kap-input:focus { border-bottom-color: var(--kapture-gold); color: #fff; }
    .kap-input::placeholder { color: var(--kapture-muted); font-style: italic; }
    .kap-input.is-invalid { border-bottom-color: #c06060; }

    .kap-select { width: 100%; background: transparent; border: none; border-bottom: 1px solid var(--kapture-border-subtle); color: var(--kapture-text); font-family: 'Cormorant Garamond', serif; font-size: 1.1rem; padding: 0.45rem 0; outline: none; cursor: pointer; transition: border-color 0.3s; appearance: none; -webkit-appearance: none; }
    .kap-select:focus { border-bottom-color: var(--kapture-gold); color: #fff; }
    .kap-select option { background: var(--kapture-deep); color: var(--kapture-text); }

    .kap-error { font-size: 0.7rem; color: #e08080; letter-spacing: 0.05em; margin-top: 0.35rem; }

    .kap-btn-row { display: flex; align-items: center; gap: 0.75rem; margin-top: 1.75rem; }
    .btn-kap-submit { flex: 1; background: var(--kapture-gold); border: 1px solid var(--kapture-gold); color: var(--kapture-black); font-family: 'Montserrat', sans-serif; font-size: 0.75rem; font-weight: 600; letter-spacing: 0.2em; text-transform: uppercase; padding: 0.8rem 1.5rem; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .btn-kap-submit:hover { background: var(--kapture-gold-light); border-color: var(--kapture-gold-light); }
    .btn-kap-cancel { flex: 1; background: transparent; border: 1px solid var(--kapture-border-subtle); color: var(--kapture-muted); font-family: 'Montserrat', sans-serif; font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase; padding: 0.8rem 1.5rem; text-decoration: none; transition: all 0.3s; display: flex; align-items: center; justify-content: center; gap: 0.5rem; }
    .btn-kap-cancel:hover { border-color: var(--kapture-muted); color: var(--kapture-text); text-decoration: none; }

    .kap-errors { border: 1px solid rgba(192,96,96,0.4); background: rgba(192,96,96,0.06); padding: 1rem 1.25rem; margin-bottom: 2rem; }
    .kap-errors ul { margin: 0; padding-left: 1.2rem; font-size: 0.8rem; color: #e08080; }

    @media (max-width: 768px) { .kap-two-col { grid-template-columns: 1fr; } .kap-row { grid-template-columns: 1fr; } }
</style>

<div class="kapture-page">

    <div class="page-header">
        <div class="page-eyebrow"><span>User Management</span></div>
        <h1 class="page-title">Create User</h1>
        <p class="page-subtitle">New Account — Registration</p>
    </div>

    @if($errors->any())
        <div class="kap-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="kap-two-col">

            {{-- LEFT: Account Details --}}
            <div class="kap-panel">
                <p class="kap-panel-title">Account Details</p>

                <div class="kap-field">
                    <label class="kap-label">Full Name</label>
                    <input type="text" name="name"
                           class="kap-input @error('name') is-invalid @enderror"
                           value="{{ old('name') }}"
                           placeholder="e.g. Juan Dela Cruz">
                    @error('name') <p class="kap-error">{{ $message }}</p> @enderror
                </div>

                <div class="kap-field">
                    <label class="kap-label">Email Address</label>
                    <input type="email" name="email"
                           class="kap-input @error('email') is-invalid @enderror"
                           value="{{ old('email') }}"
                           placeholder="e.g. juan@email.com">
                    @error('email') <p class="kap-error">{{ $message }}</p> @enderror
                </div>

                {{-- Role & Status side by side --}}
                <div class="kap-row">
                    <div class="kap-field">
                        <label class="kap-label">Role</label>
                        <select name="role" class="kap-select @error('role') is-invalid @enderror">
                            <option value="customer" {{ old('role') === 'customer' ? 'selected' : '' }}>Customer</option>
                            <option value="admin"    {{ old('role') === 'admin'    ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <p class="kap-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="kap-field">
                        <label class="kap-label">Account Status</label>
                        <select name="is_active" class="kap-select @error('is_active') is-invalid @enderror">
                            <option value="1" {{ old('is_active', '1') == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ old('is_active') == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('is_active') <p class="kap-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- RIGHT: Password & Actions --}}
            <div class="kap-panel kap-panel-right">
                <p class="kap-panel-title">Password & Actions</p>

                <div class="kap-field">
                    <label class="kap-label">Password</label>
                    <input type="password" name="password"
                           class="kap-input @error('password') is-invalid @enderror"
                           placeholder="Minimum 8 characters">
                    @error('password') <p class="kap-error">{{ $message }}</p> @enderror
                </div>

                <div class="kap-field">
                    <label class="kap-label">Confirm Password</label>
                    <input type="password" name="password_confirmation"
                           class="kap-input"
                           placeholder="Re-enter password">
                </div>

                <div class="kap-btn-row">
                    <button type="submit" class="btn-kap-submit">
                        <i class="bi bi-plus-lg"></i> Create User
                    </button>
                    <a href="{{ route('admin.users') }}" class="btn-kap-cancel">
                        <i class="bi bi-x"></i> Cancel
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>

@endsection