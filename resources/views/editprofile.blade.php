@extends('layouts.app')

@section('title', 'Profile')


@section('content')

<div class="container">
    <h2>Edit Profile</h2>
    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="mb-3">
            <label>Nickname</label>
            <input type="text" name="nickname" value="{{ old('nickname', $profile->nickname) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Handle</label>
            <input type="text" name="handle" value="{{ old('handle', $profile->handle) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Bio</label>
            <textarea name="bio" class="form-control">{{ old('bio', $profile->bio) }}</textarea>
        </div>

        <div class="mb-3">
            <label>Japanese level</label>
            <select name="JP_level" class="form-select">
                @foreach (['Beginner', 'Intermediate', 'Advanced', 'Native'] as $level)
                    <option value="{{ $level }}" @selected($profile->JP_level === $level)>{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>English level</label>
            <select name="EN_level" class="form-select">
                @foreach (['Beginner', 'Intermediate', 'Advanced', 'Native'] as $level)
                    <option value="{{ $level }}" @selected($profile->EN_level === $level)>{{ $level }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Country</label>
            <input type="text" name="country" value="{{ old('country', $profile->user->country) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Region</label>
            <input type="text" name="region" value="{{ old('region', $profile->user->region) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Avator</label>
            <input type="file" name="avatar" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Edit</button>
    </form>
</div>

@endsection