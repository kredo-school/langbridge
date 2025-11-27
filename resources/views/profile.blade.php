@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Profile</h2>
    <div class="card p-4">
        <div class="mb-3">
            <strong>Nickname:</strong> {{ $profile->nickname }}
        </div>
        <div class="mb-3">
            <strong>Handle:</strong> @{{ $profile->handle }}
        </div>
        <div class="mb-3">
            <strong>Age:</strong> {{  }}
        </div>
        <div class="mb-3">
            <strong>Bio:</strong> {{ $profile->bio }}
        </div>
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
            @foreach ($profile->interests as $interest)
                <span class="badge bg-primary">{{ $interest->name }}</span>
            @endforeach
        </div>
        @if (auth()->id() === $profile->user_id)
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">Edit</a>
        @endif
    </div>
</div>
@endsection
