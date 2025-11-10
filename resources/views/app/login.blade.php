@extends('_layouts.auth.index')
@php
    $title = "Login";
@endphp
@section('content')
<div class="card mb-3">
    <div class="card-body">
        <div class="pt-4 pb-2">
            <h5 class="card-title text-center pb-0 fs-4">
                Login to Your Account
            </h5>
            <p class="text-center small">
                Enter your callsign & password
                to login
            </p>
        </div>

        <form action="{{ route('login') }}" class="row g-3 needs-validation" novalidate method="POST">
            @csrf
            <div class="col-12">
                <label for="yourCallsign" class="form-label">Callsign</label>
                <div class="has-validation">
                    <input type="text" name="callsign" class="form-control @error('callsign') is-invalid @enderror" id="yourCallsign" required placeholder="JZ01..."/>
                    @error('callsign')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="col-12">
                <label for="yourPassword" class="form-label">Password</label>
                <input type="password" name="password" class="form-control"
                    id="yourPassword" required />
                <div class="invalid-feedback">
                    Please enter your password!
                </div>
            </div>

            <div class="col-12">
                <button class="btn btn-primary w-100" type="submit">
                    Login
                </button>
            </div>
            <div class="col-12">
                <p class="small mb-0">
                    Don't have account?
                    <a href="{{ route('register') }}">Create an account</a>
                </p>
            </div>
        </form>
    </div>
</div>
@endsection