@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center"><img src="{{ asset('images/logo.png') }}" alt="Site Logo" class="logo-img">Profile</h2>
    <div class="profile-wrapper">
    <div class="profile-top">
        <div class="avatar-section">
        <label class="mb-3">Avatar</label>
        <div>
            @if($profile->avatar)
             <img src="{{ $profile->avatar }}" alt="Avatar" class="rounded-circle" width="120">
            @else
             <i class="fa-solid fa-circle-user text-secondary icon-bd" ></i>
            @endif
        </div>
        </div>
        <div class="input-columns">
        <div class="form-group">
            <label>Nickname</label>
            <div class="profile-value">{{ $profile->nickname }}</div>
        </div>
        <div class="form-group">
            <label>Handle</label>
            <div class="profile-value">{{ $profile->handle }}</div>
        </div>
        <div class="form-group">
            <label>Japanese level</label>
            <div class="profile-value">{{ $profile->JP_level_text }}</div>
        </div>
        <div class="form-group">
            <label>English level</label>
            <div class="profile-value">{{ $profile->EN_level_text }}</div>
        </div>
        <div class="form-group">
            <label>Age</label>
            @if($user->profile->age_hidden)
             <span class="text-muted">Private</span>
            @else 
            {{ $user->age }}
            @endif
        </div>
        <div class="form-group">
            <label>Country</label>
            @if($user->profile->country_hidden)
             <span class="text-muted">Private</span>
            @else 
            {{ $profile->user->country }}
            @endif
        </div>
        <div class="form-group">
            <label>Region</label>
            @if($user->profile->region_hidden)
             <span class="text-muted">Private</span>
            @else 
            {{ $profile->user->region }}
            @endif
        </div>
        <div class="form-group empty-cell"></div>
        <div class="form-group bio-group">
            <label>Bio</label>
            <button id="translate-btn" class="btn btn-sm btn-outline-secondary">
                <i class="fa fa-language"></i>
            </button>
            <p id="bio-text">{{ $profile->bio }}</p>
            <div id="translation-result" class="mt-2"></div>
        </div>
        </div>
    </div>
</div>

<div class="interest-section">
    <div class="interest-title">Interest</div>
    <div class="interests-grid">
        @foreach($interests as $interest)
            <div class="interest-card {{ $user->interests->pluck('id')->contains($interest->id) ? 'selected' : '' }}">
                <div class="interest-card-content">{{ $interest->name }}</div>
            </div>
        @endforeach
    </div>
</div>
</div>

       
            <div>
        @if (auth()->id() === $profile->user_id)
            <a href="{{ route('profile.edit') }}" class="edit-btn btn-outline-primary btn-sm" >Edit</a>
        @endif
    </div>
</div>
@endsection 

@vite(['resources/js/translate.js'])

