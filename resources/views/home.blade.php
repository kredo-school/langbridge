@extends('layouts.app')

@section('content')

@php
    use Carbon\Carbon;

    $start = Carbon::parse($fromDate);
    $end = Carbon::parse($today);

    function contributionLevel(int $count): string
        {
            return match (true) {
                $count === 0 => 'level-0',
                $count < 5   => 'level-1',
                $count < 10  => 'level-2',
                $count < 20  => 'level-3',
                default      => 'level-4',
            };
        }
@endphp

<div class="container home-main">

    {{-- page header --}}
    <div class="home-header">
        <h1 class="logo-title">
            <img src="{{ asset('images/logo.png') }}" alt="Site Logo" class="logo-img">
            LangBridge
        </h1>
        <p class="subtitle">Connect through language. Learn through friendship.</p>
    </div>

    <div class="home-body">
        {{-- Learning Journey (Streak Calendar placeholder) --}}
        <section class="learning-journey">
            <h2 class="section-title">{{__('messages.learning_journey')}}</h2>

            {{-- streak calendar --}}
            <div class="streak-calendar-placeholder">
                <div class="calendar-header">
                    <a href="{{ route('home', [
                        'year' => $startOfMonth->copy()->subMonth()->year,
                        'month' => $startOfMonth->copy()->subMonth()->month,
                    ]) }}">◀</a>

                    <h3>
                        {{ __('messages.month.' . strtolower($startOfMonth->format('M'))) }}
                        {{ $year }}
                    </h3>

                    <a href="{{ route('home', [
                        'year' => $startOfMonth->copy()->addMonth()->year,
                        'month' => $startOfMonth->copy()->addMonth()->month,
                    ]) }}">▶</a>
                </div>
                <div class="calendar-grid calendar-weekdays">
                    @foreach(['mon','tue','wed','thu','fri','sat','sun'] as $day)
                        <div class="weekday">{{ __('messages.day_of_week.'.$day) }}</div>
                    @endforeach
                </div>
                @php
                    $firstDay = $startOfMonth->copy();
                    $startWeekday = $firstDay->dayOfWeekIso; // 1(Mon)〜7(Sun)
                @endphp

                <div class="calendar-grid calendar-days">

                    {{-- 月初までの空白 --}}
                    @for ($i = 1; $i < $startWeekday; $i++)
                        <div class="day empty"></div>
                    @endfor

                    {{-- 日付 --}}
                    @for ($day = 1; $day <= $startOfMonth->daysInMonth; $day++)
                        @php
                            $date = $startOfMonth->copy()->day($day)->toDateString();
                            $count = $dailyStats[$date]->total_questions ?? 0;
                        @endphp

                        <div class="day {{ contributionLevel($count) }}"
                            title="{{ $date }} : {{ $count }} questions">
                            {{ $day }}
                        </div>
                    @endfor
                </div>
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
                </div>
                    @endforeach
                </div>
            </section>

        </section>

    </div>
</div>
@endsection
