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
        <div class="chat-list" style="display:flex; gap:20px; flex-wrap:wrap;">
            @foreach($recentChats as $user)
                <div class="chat-card" style="display:flex; flex-direction:column; align-items:center;">
                    @if($user->profile && $user->profile->avatar)
                    <a href="{{ route('chat.chat', ['to_user_id' => $user->id]) }}">    
                    <img src="{{ $user->profile->avatar }}" class="avatar rounded-circle" width="80"> 
                    </a>
                    @else
                    <a href="{{ route('chat.chat', ['to_user_id' => $user->id]) }}">
                        <i class="fa-solid fa-circle-user text-secondary" style="font-size: 70px;"></i>
                    </a>
                        @endif
                    <div class="name">{{ $user->profile->nickname }}</div>
                    <div class="handle">{{ $user->profile->handle }}</div>
                </div>
            @endforeach
        </div>
        
        
    </div> 

    {{-- Suggested Users --}}
    <div class="suggested-users">
        <h2>Suggested Users</h2>
        <div class="suggested-list">
            @foreach($otherUsers as $user)
                <div class="suggested-card pt-3">
                    @if($user->profile->avatar)
                    <a href="{{ route('profile.show', $user->id) }}">
                    <img src="{{ $user->profile->avatar }}" alt="Avatar" class="rounded-circle" width="80">
                    </a>
                    @else
                    <a href="{{ route('profile.show', $user->id) }}">
                    <i class="fa-solid fa-circle-user text-secondary" style="font-size: 70px;"></i>
                    </a>
                    @endif
                    <div class="user-meta">
                        <div class="name">{{ $user->profile->nickname }}</div>
                        <div class="handle">{{ $user->profile->handle }}</div>
                        <div class="bio">{{ $user->profile->bio }}</div>
                    </div>
                    <button class="start-chat"  onclick="window.location.href='{{ route('chat.chat', ['to_user_id' => $user->id]) }}'">
                    Start Chat
                    </button>
                </div>
                <button class="start-chat">Start Chat</button>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection