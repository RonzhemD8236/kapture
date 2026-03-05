@extends('layouts.base')
@section('body')
    @include('layouts.flash-messages')

    <div class="container" style="max-width: 600px; margin-top: 30px;">
        <h2>Edit User — {{ $user->name }}</h2>
        <hr>

        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="form-control @error('name') is-invalid @enderror">
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="form-control @error('email') is-invalid @enderror">
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            {{-- Password section --}}
            <div class="card mb-3">
                <div class="card-body bg-light">
                    <p class="text-muted mb-3">
                        <small>⚠️ Leave password fields blank to keep the current password.</small>
                    </p>

                    <div class="mb-3">
                        <label>New Password</label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="New password (optional)">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation"
                               class="form-control"
                               placeholder="Re-enter new password">
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
@endsection