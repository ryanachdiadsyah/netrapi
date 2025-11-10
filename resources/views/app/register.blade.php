@extends('_layouts.auth.index')
@php
    $title = "Register";
@endphp
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                Create Your Account
            </h5>
            <p class="text-center small">
                Enter your callsign & password
                to create an account
            </p>
        </div>

        <form action="{{ route('register') }}" class="row g-3 needs-validation" novalidate method="POST">
            @csrf
            <div class="col-12">
                <label for="yourCallsign" class="form-label">Callsign</label>
                <div class="has-validation">
                    <input type="text" name="callsign" class="form-control @error('callsign') is-invalid @enderror"
                        id="yourCallsign" required placeholder="JZ01..." />
                        @error('callsign')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                </div>
            </div>
            
            <div class="col-12">
                <label for="yourName" class="form-label">Name</label>
                <div class="has-validation">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        id="yourName" required />
                        @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="yourEmail" class="form-label">Email</label>
                <div class="has-validation">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        id="yourEmail" required />
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="yourPhone" class="form-label">Phone</label>
                <div class="has-validation">
                    <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                        id="yourPhone" required />
                    @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}  
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                    id="yourPassword" required />
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="col-12">
                <label for="yourConfirmPassword" class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control"
                    id="yourConfirmPassword" required />
                <div class="invalid-feedback">
                    Please confirm your password!
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">
                    Register
                </button>
            </div>
            <div class="col-12">
                <p class="small mb-0">
                    I Have an account?
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection