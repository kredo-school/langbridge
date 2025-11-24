@extends ('layouts.app')
@section ('content')

<!DOCTYPE html>
<meta charset="UTF-8">
<title>Profile search</title>
<style>
    .interest-button {
        display: inline-block;
        margin: 5px;
        padding: 6px 12px;
        background-color: #eee;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .interest-button.active {
        background-color: #f48fb1;
        color: white;
    }

    .profile-card {
        border: 1px solid #ccc;
        padding: 12px;
        margin-bottom: 10px;
        border-radius: 6px;
    }

    .tag {
        background-color: #f48fb1;
        color: white;
        padding: 2px 6px;
        border-radius: 4px;
        margin-right: 4px;
        font-size: 0.9em;
    }
</style>

<h1>Profile search</h1>

<!-- 🔍 検索フォーム -->
<form action="{{ route('users.search') }}" method="GET">
    <input type="text" name="handle" placeholder="Handle Name" value="{{ request('handle') }}">
    <button type="submit">Search</button>
</form>

<!-- 🎯 Interest Category Buttons -->
<h3>Interest Categories</h3>
<div>
    @foreach($interests as $interest)
    <form action="{{ route('users.search') }}" method="GET" style="display:inline;">
        <input type="hidden" name="interest" value="{{ $interest->id }}">
        <button type="submit" class="interest-button {{ request('interest') == $interest->id ? 'active' : '' }}">
            {{ $interest->name }}
        </button>
    </form>
    @endforeach
</div>

<hr>

<!-- 👥 検索結果 -->
<h3>Search Results</h3>
@forelse ($users as $profile)
<div class="profile-card">
    <!-- アバターとハンドルネーム -->
    <a href="" style="display: flex; align-items: center; text-decoration: none;">
        @if($profile->avatar)
        <img src="{{ asset('storage/avatars/' . $profile->avatar) }}" alt="avatar" width="40" height="40"
            style="border-radius: 50%; object-fit: cover; margin-right: 10px;">
        @else
        <i class="fa-solid fa-circle-user" style="font-size: 40px; color: #888; margin-right: 10px;"></i>
        @endif
        <strong style="color: #333;">{{ $profile->handle }}</strong>
    </a><br>

    <!-- 興味タグ -->
    <div style="margin-top: 6px;">
        @if($profile->user && $profile->user->interests)
        @foreach($profile->user->interests as $i)
        <span class="tag">{{ $i->name }}</span>
        @endforeach
        @endif
    </div>
</div>
@empty
<p>No profiles found.</p>
@endforelse

@endsection