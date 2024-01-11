@extends('layouts.auth')
@section('title', 'Login')
@push('head')
    <style>
        .card {
            /* From https://css.glass */
            background: rgba(255, 255, 255, 0.65);
            border-radius: 16px;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
            backdrop-filter: blur(5px);
            -webkit-backdrop-filter: blur(5px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .bg-transparebt {
            background-color: transparent
        }

        .form-control {
            border-color: #085fce
        }
    </style>
@endpush
@section('content')
    <div class="row justify-content-center align-items-center" style="height: 100vh;">
        <div class="col-lg-4 col-md-8">
            <div class="card shadow-sm ">
                <div class="card-body p-md-5 p-sm-3">
                    <div class="card-header p-0 mb-5 bg-transparent">
                        <h3 class="text-center ">SHOWME ADMIN</h3>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3 needs-validation" novalidate>
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control bg-transparent @error('email') is-invalid @enderror"
                                name="email" id="email" required>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-5">
                            <label for="password" class="form-label">Password</label>
                            <input type="password"
                                class="form-control bg-transparent @error('password') is-invalid @enderror" name="password"
                                id="password" required>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            @if (Route::has('password.request'))
                                <span class="row text-end"><a href="{{ route('password.request') }}"
                                        class="text-primary">{{ __('Forgot Password?') }}</a></span>
                            @endif
                        </div>
                        <div class="form-group my-3 d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-md">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
