@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile</h2>
    <div class="card p-4">
        <div class="mb-3">
            <strong>Nickname:</strong> {{ $profile->nickname }}
        </div>
        <div class="mb-3">
            <strong>Handle:</strong> {{ $profile->handle }}
        </div>
        <div class="mb-3">
            <strong>Age:</strong> {{ $user->age }}
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <label class="form-label mb-0">Bio</label>
            <button id="translate-btn" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-language"></i>
            </button>
        </div>
        
        <p id="bio-text">{{ $profile->bio }}</p>
        <div class="mb-3">
            <strong>Japanese Level:</strong> {{ $profile->JP_level }}
        </div>
        <div class="mb-3">
            <strong>English Level:</strong> {{ $profile->EN_level }}
        </div>
        <div class="mb-3">
            <strong>Country:</strong> {{ $profile->user->country }}
        </div>
        <div class="mb-3">
            <strong>Region:</strong> {{ $profile->user->region }}
        </div>
        <div class="mb-3">
            <strong>interest:</strong>
            @foreach ($profile->user->interests as $interest)
                <span class="badge bg-primary">{{ $interest->name }}</span>
            @endforeach
        </div>
        @if (auth()->id() === $profile->user_id)
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit</a>
        @endif
    </div>
</div>
@endsection

