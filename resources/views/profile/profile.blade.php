@extends('layouts.app')

@section('header')
    User Profile
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <!-- Profile Card -->
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body p-5">

                    <!-- Avatar + Name -->
                    <div class="text-center mb-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=120" 
                             alt="Avatar" class="rounded-circle shadow-sm mb-3">
                        <h3 class="fw-bold">{{ $user->name }}</h3>
                        <p class="text-muted mb-0">{{ ucfirst($user->role) }}</p>
                    </div>

                    <hr>

                    <!-- Profile Information -->
                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Full Name:</div>
                        <div class="col-sm-8">{{ $user->name }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Email:</div>
                        <div class="col-sm-8">{{ $user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Role:</div>
                        <div class="col-sm-8">{{ ucfirst($user->role) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4 fw-bold">Member Since:</div>
                        <div class="col-sm-8">{{ $user->created_at->format('F j, Y') }}</div>
                    </div>

                    <hr>

                    <!-- Action Buttons -->
                    <div class="d-flex justify-content-between">
                        <a href="/profiled" class="btn btn-primary px-4">Edit Profile</a>
                        <a href="{{ route('logout') }}" 
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();" 
                           class="btn btn-outline-danger px-4">Log Out</a>
                    </div>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection
