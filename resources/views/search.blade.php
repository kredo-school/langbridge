@extends('layouts.app')
@section('content')

<h1>Profile Search</h1>

<!-- 🔍 Search Form -->
<form method="GET" action="{{ route('users.search') }}">
    <input type="text" name="handle" placeholder="Handle Name" value="{{ request('handle') }}">

    <h3>Interest Categories</h3>
    @foreach($interests as $interest)
    <label>
        <input type="checkbox" name="interests[]" value="{{ $interest->id }}" {{ in_array($interest->id,
        (array)request('interests')) ? 'checked' : '' }}>
        {{ $interest->name }}
    </label>
    @endforeach

    <button type="submit">Search</button>
</form>

<hr>


<!-- 👥 Results Display -->
@forelse ($users as $profile)
<div style="margin-bottom: 1em;">
    <a href="#">
        <strong>{{ $profile->handle }}</strong>
    </a><br>
    @foreach($profile->user->interests as $i)
    <span style="display: inline-block; background: #eef; padding: 2px 6px; margin: 2px; border-radius: 4px;">
        {{ $i->name }}
    </span>
    @endforeach
</div>
@empty
@if(request()->filled('handle') || request()->filled('interests'))
<p>No matching profiles found.</p>
@endif
@endforelse



<!-- 📄 Pagination -->
@if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
{{ $users->appends(request()->query())->links() }}
@endif
@endsection