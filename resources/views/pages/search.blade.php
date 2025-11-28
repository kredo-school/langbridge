@extends('layouts.app')

@section('title',__('messages.search'))

@section('content')
<div class="container">
<h1>Profile Search</h1>

<!-- Search Form -->
<form method="GET" action="{{ route('users.search') }}" autocomplete="off">
    <input class="form-control my-3" type="text" name="keyword" placeholder="Search by @handle, nickname, or bio"
        value="{{ request('keyword') }}">

    <h3>Interest Categories</h3>
    <div class="d-flex flex-wrap gap-2 mb-5">
    @foreach($interests as $interest)
        <input 
            type="checkbox" 
            class="btn-check" 
            id="interest-{{ $interest->id }}" 
            name="interests[]" 
            value="{{ $interest->id }}"
            autocomplete="off"
            {{ in_array($interest->id, (array)request('interests')) ? 'checked' : '' }}
        >

        <label class="interest-label" for="interest-{{ $interest->id }}">
            {{ $interest->name }}
        </label>
    @endforeach
</div>

    <button type="submit" class="btn-search d-block mx-auto">Search</button>
</form>

<!-- Results Display -->
@forelse ($users as $profile)
<div class="row mb-4">
    <div class="col-auto d-flex align-items-center">
        @if($profile->avatar)
            <img src="{{ $prifile->avatar }}" alt="" class="rounded-circle image-md d-block mx-auto my-auto">
        @else
            <i class="fa-solid fa-circle-user text-secondary icon-md d-block text-center"></i>
        @endif
    </div>
    <div class="col">
    @if($profile->nickname)
    <div class="d-inline"><strong>{{ $profile->nickname }}</strong></div>
    @endif
    <a class="d-inline" href="{{ route('profile.show', $profile->user_id)}}">
        <strong>{{ $profile->handle }}</strong>
    </a><br>

    @if($profile->bio)
    <div>{{ $profile->bio }}</div>
    @endif

        <div style="margin-top: 5px;">
            @foreach($profile->user->interests as $i)
            <span class="interest-label-sm">
                {{ $i->name }}
            </span>
            @endforeach
        </div>
    </div>
</div>
@empty
@if(request()->filled('keyword') || request()->filled('interests'))
<p>No matching profiles found.</p>
@endif
@endforelse

<!-- Pagination -->
@if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
{{ $users->appends(request()->query())->links() }}
@endif
</div>
@endsection
