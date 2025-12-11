@extends('layouts.app')



@section('content')
<div class="container">
    {{-- page header --}}
    <div class="home-header">
        <h1>LangBridge</h1>
        <p class="subtitle">Connect through language. Learn through friendship.</p>
      </div>
    {{-- Recent Chat --}}
    <section class="recent-chats-section">
        <h2 class="section-title">Recent Chats</h2> 
        <div class="chat-list">
            <div class="chat-inner">
            @foreach($recentChats as $user)
                <div class="chat-card">
                    @if($user->profile && $user->profile->avatar)
                    <a href="{{ route('chat.chat', ['to_user_id' => $user->id]) }}">    
                    <img src="{{ $user->profile->avatar }}" class="avatar rounded-circle" > 
                    </a>
                    @else
                    <a href="{{ route('chat.chat', ['to_user_id' => $user->id]) }}">
                        <i class="fa-solid fa-circle-user text-secondary"></i>
                    </a>
                        @endif
                    <div class="name">{{ $user->profile->nickname }}</div>
                    <div class="handle">{{ $user->profile->handle }}</div>
                </div>
                </div>
            @endforeach
        </div>
        
        
    </section> 

    {{-- Suggested Users --}}
    <section class="suggested-users-section">
        <h2 class="section-title">Suggested Users</h2>
        <div class="suggested-list">
            @foreach($otherUsers as $user)
                <div class="suggested-card">
                    @if($user->profile->avatar)
                    <a href="{{ route('profile.show', $user->id) }}">
                    <img src="{{ $user->profile->avatar }}" alt="Avatar" class="avatar rounded-circle" >
                    </a>
                    @else
                    <a href="{{ route('profile.show', $user->id) }}">
                    <i class="fa-solid fa-circle-user text-secondary"></i>
                    </a>
                    @endif
                    <div class="suggested-info">
                        <p class="name">{{ $user->profile->nickname }}</p>
                        <p class="handle">{{ $user->profile->handle }}</p>
                        <p class="bio">{{ $user->profile->bio }}</p>
                    </div>
                    <button class="chat-btn"  onclick="window.location.href='{{ route('chat.chat', ['to_user_id' => $user->id]) }}'">
                        <i class="fa-regular fa-comment"></i>Start Chat
                    </button>
                </div>
            @endforeach
        </div>
    </div>

</div>
@endsection

