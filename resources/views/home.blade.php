@extends('layouts.app')

@section('content')
<div class="container">
    <div class="home-header">
        <h1>LangBridge</h1>
        <p class="subtitle">Connect through language. Learn through friendship.</p>
      </div>
    {{-- Chat user --}}
    <div class="recent-chats mb-4">
        <h2>Chat</h2> 
        {{-- <div class="chat-list">
            @foreach($recentChats as $user)
                <div class="chat-card">
                    <img src="{{ $profile->avatar }}" class="avatar">
                    <div class="name">{{ $profile->nickname }}</div>
                    <div class="handle">@{{ $profile->handle }}</div>
                </div>
            @endforeach
        </div>
    </div> --}} 

    {{-- Suggested Users --}}
    <div class="suggested-users">
        <h2>Suggested Users</h2>
        <div class="suggested-list">
            @foreach($otherUsers as $user)
                <div class="suggested-card pt-3">
                    @if($user->profile->avatar)
                    <img src="{{ $user->profile->avatar }}" alt="Avatar" class="rounded-circle" width="80">
                    @else
                    <i class="fa-solid fa-circle-user text-secondary" style="font-size: 60px;"></i>
                    @endif
                    <div class="user-meta">
                        <div class="name">{{ $user->profile->nickname }}</div>
                        <div class="handle">{{ $user->profile->handle }}</div>
                        <div class="bio">{{ $user->profile->bio }}</div>
                    </div>
                    <button class="start-chat">Start Chat</button>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

