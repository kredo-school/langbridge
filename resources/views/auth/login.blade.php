@extends('layouts.auth')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm rounded-4 border-0 p-4" style="width: 100%; max-width: 420px; background-color: #fff;">
                <div class="text-center mb-4">
                    <h2 class="mt-2 fw-semibold">Welcome to LangBridge</h2>
                </div>
                <!--Login form -->
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" placeholder="email" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text bg-white"><i class="bi bi-key"></i></span>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="d-flex justify-content-beween align-item-center mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                                @if (Route::has('password.request'))
                                <a class="text-decoration-none" href="{{ route('password.request') }}">
                                    Forgot Password?
                                </a>
                            @endif
                        </div>

                        <!-- login button -->
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Login') }}
                                </button>

                        <!-- Register Link -->
                                <p class="text-center mb-0">
                                Don't have an account? <a href="{{ route('register') }}">Register</a>
                                </p>
                     </form>
    </div>
</div>
                   
@endsection
