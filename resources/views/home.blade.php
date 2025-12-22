@extends('layouts.app')

@section('content')
<div class="container home-main">

    {{-- page header --}}
    <div class="home-header">
        <h1>
            <img src="{{ asset('images/logo.png') }}" alt="Site Logo" class="logo-img">
            LangBridge
        </h1>
        <p class="subtitle">Connect through language. Learn through friendship.</p>
    </div>

    <div class="home-body">
        {{-- Learning Journey (Streak Calendar placeholder) --}}
        <section class="learning-journey">
            <h2 class="section-title">{{__('messages.learning_journey')}}</h2>

            {{-- TODO: streak calendar --}}
            <div class="streak-calendar-placeholder">
                <p>Streak calendar will appear here</p>
            </div>
        </section>

        {{-- Connections --}}
        <section class="connections">

            {{-- Recent Chat --}}
            <section class="recent-chats-section">
                <h2 class="section-title">{{__('messages.recent_chats')}}</h2>

                <div class="chat-list">
                    @foreach($recentChats as $user)
                    <div class="chat-card">
                        <a href="{{ route('chat.pages.chat', ['to_user_id' => $user->id]) }}">
                            @if($user->profile && $user->profile->avatar)
                                <img src="{{ $user->profile->avatar }}" class="avatar rounded-circle">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-bd"></i>
                            @endif
                        </a>
                        <div class="name">{{ $user->profile->nickname }}</div>
                        <div class="handle">{{ $user->profile->handle }}</div>
                    </div>
                    @endforeach
                </div>
            </section>

            {{-- Suggested Users --}}
            <section class="suggested-users-section">
                <h2 class="section-title">{{__('messages.suggested_users')}}</h2>

                <div class="suggested-list">
                    @foreach($otherUsers as $user)
                    <div class="suggested-card">
                        <a href="{{ route('profile.show', $user->id) }}">
                            @if($user->profile->avatar)
                                <img src="{{ $user->profile->avatar }}" class="avatar rounded-circle">
                            @else
                                <i class="fa-solid fa-circle-user text-secondary icon-bd"></i>
                            @endif
                        </a>

                        <div class="suggested-info">
                            <p class="name">{{ $user->profile->nickname }}</p>
                            <p class="handle">{{ $user->profile->handle }}</p>
                            <p class="bio">{{ $user->profile->bio }}</p>
                        </div>

    {{-- Suggested Users --}}
    <section class="suggested-users-section">
        <h2 class="section-title">Suggested Users</h2>
        <div class="suggested-list">
            @foreach($otherUsers as $user)
                <div class="suggested-card">
                    @if($user->profile->avatar)
                    <a href="{{ route('profile.show', ['user_id' => encrypt($user->id)]) }}">
                    <img src="{{ $user->profile->avatar }}" alt="Avatar" class="avatar rounded-circle" >
                    </a>
                    @else
                    <a href="{{ route('profile.show', ['user_id' => encrypt($user->id)]) }}">
                    <i class="fa-solid fa-circle-user text-secondary icon-bd"></i>
                    </a>
                    @endif
                    <div class="suggested-info">
                        <p class="name">{{ $user->profile->nickname }}</p>
                        <p class="handle">{{ $user->profile->handle }}</p>
                        <p class="bio">{{ $user->profile->bio }}</p>
                        <button class="chat-btn"
                            onclick="window.location.href='{{ route('chat.pages.chat', ['to_user_id' => $user->id]) }}'">
                            <i class="fa-regular fa-comment"></i> {{__('messages.start_chat')}}
                        </button>
                    </div>
                    @endforeach
                </div>
            </section>

        </section>

    </div>
</div>
@endsection
