

@extends('layouts.app')

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="card shadow-sm rounded-4 border-0 p-4" style="width: 100%; max-width: 520px; background-color: #fff;">
        
        <!-- Title -->
        <div class="text-center mb-4">
            <h2 class="mt-2 fw-semibold">Let's get to know you!</h2>
        </div>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- fullname -->
            <div class="mb-3">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" 
                       name="name" placeholder="name" value="{{ old('name') }}"required autofocus>
                @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- email -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail Address</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                       name="email" placeholder="email" value="{{ old('email') }}"required>
                @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- PW -->
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                       name="password" required>
                @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <!-- PW confirm -->
            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirm Password</label>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
            </div>

            <!-- ROle -->
            <div class="mb-3">
                <label class="form-label">Role in the app</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role1" value="learner_en_teacher_jp" checked>
                    <label class="form-check-label" for="role1">
                        Japanese learner & English teacher
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="role" id="role2" value="learner_jp_teacher_en">
                    <label class="form-check-label" for="role2">
                        English learner & Japanese teacher
                    </label>
                </div>
            </div>

            <!-- Age -->
            <div class="mb-3">
                <label for="birthday" class="form-label">Date of Birth</label>
                <input id="birthday" type="date" class="form-control @error('birthday') is-invalid @enderror" 
                       name="birthday" placeholder="yyyy-mm-dd" value="{{ old('birthday') }}"required>
                @error('birthday')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            

            <!-- Country -->
            <div class="mb-3">
                <label for="country" class="form-label">Country</label>
                <input id="country" type="text" class="form-control" name="country" placeholder="country" value="{{ old('country') }}">
            </div>

            <!-- Region -->
            <div class="mb-3">
                <label for="region" class="form-label">Region</label>
                <input id="region" type="text" class="form-control" name="region" placeholder="region" value="{{ old('region') }}">
            </div>


            <!-- Kiyaku -->
            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                <label class="form-check-label" for="terms">
                    I agree to the <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>
                </label>
            </div>

            <!-- Register button -->
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>
    </div>
</div>
@endsection
