@extends('layouts.app')

@section('header')
    <h2 class="fw-semibold fs-3 text-dark">
        {{ __('My Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-4">
    <div class="container">

        <!-- Profile Overview Card -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex align-items-center">
                <!-- Avatar -->
                <img class="rounded-circle shadow-sm me-4"
                     src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0D8ABC&color=fff&size=120"
                     width="96" height="96"
                     alt="{{ Auth::user()->name }}">
                
                <div>
                    <h3 class="fw-bold mb-1">{{ Auth::user()->name }}</h3>
                    <p class="text-muted mb-1">{{ Auth::user()->email }}</p>
                    <p class="mb-1">
                        Role: <span class="fw-semibold">{{ ucfirst(Auth::user()->role ?? 'User') }}</span>
                    </p>
                    <p class="text-muted small">
                        Member since {{ Auth::user()->created_at->format('F j, Y') }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Update Profile Information -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header fw-semibold">Update Profile Information</div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')

                    <!-- Example fields -->
                    <div class="mb-3">
                        <label class="form-label">Name</label>
                        <input name="name" type="text" class="form-control" value="{{ old('name', Auth::user()->name) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input name="email" type="email" class="form-control" value="{{ old('email', Auth::user()->email) }}">
                    </div>

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>

        <!-- Update Password -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header fw-semibold">Change Password</div>
            <div class="card-body">
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    @method('put')

                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password" name="current_password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Update Password</button>
                </form>
            </div>
        </div>

        <!-- Delete Account -->
        <div class="card shadow-sm border-danger">
            <div class="card-header text-danger fw-semibold">Danger Zone</div>
            <div class="card-body">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <p class="mb-3 text-muted">
                        Once your account is deleted, all of its resources and data will be permanently removed.
                        Please be certain before proceeding.
                    </p>

                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
