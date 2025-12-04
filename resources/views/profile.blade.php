@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile</h2>
    <div class="card p-4">
        <div>
            @if($profile->avatar)
             <img src="{{ $profile->avatar }}" alt="Avatar" class="rounded-circle" width="120">
            @else
             <i class="fa-solid fa-circle-user text-secondary icon-sm"></i>
            @endif
        </div>
        <div class="mb-3">
            <strong>Nickname:</strong> {{ $profile->nickname }}
        </div>
        <div class="mb-3">
            <strong>Handle:</strong> {{ $profile->handle }}
        </div>
        <div class="mb-3">
            <strong>Age:</strong> 
            @if($user->profile->age_hidden)
             <span class="text-muted">Private</span>
            @else 
            {{ $user->age }}
            @endif
        </div>
        <div class="mb-3 d-flex justify-content-between align-items-center">
            <label class="form-label mb-0">Bio</label>
            <button id="translate-btn" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-language"></i>
            </button>
        </div>
               
        <p id="bio-text">{{ $profile->bio }}</p>

        <div id="translation-result" class="mt-2"></div>

        
        <div class="mb-3">
            <strong>Japanese Level:</strong> {{ $profile->JP_level }}
        </div>
        <div class="mb-3">
            <strong>English Level:</strong> {{ $profile->EN_level }}
        </div>
        <div class="mb-3">
            <strong>Country:</strong> 
            @if($user->profile->country_hidden)
             <span class="text-muted">Private</span>
            @else 
            {{ $profile->user->country }}
            @endif
        </div>
        <div class="mb-3">
            <strong>Region:</strong> 
            @if($user->profile->region_hidden)
             <span class="text-muted">Private</span>
            @else 
            {{ $profile->user->region }}
            @endif
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

@vite(['resources/js/profile.js'])

