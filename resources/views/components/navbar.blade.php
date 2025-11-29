<div class="position-fixed top-0 start-0 d-flex flex-column align-items-center vh-100 nav-body">

    <!-- ロゴ -->
    <div class="my-3">
        <a href="{{ url('/') }}"> <!--Homeページへのルートを入れる-->
            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="nav-logo">
        </a>
    </div>

    <!-- ハンバーガーメニュー -->
    <button class="btn mb-3 border-0" type="button"
            data-bs-toggle="collapse"
            data-bs-target="#sidebarMenuContent"
            aria-expanded="false"
            >
        <span><i class="fa-solid fa-bars"></i></span>
    </button>

    <!-- 固定アイコン：プロフィール -->
    <a class="nav-link mb-4" href="{{ route('profile.show', Auth::id())}}">
        <i class="fas fa-user fa-lg"></i>
    </a>

    <!-- 固定アイコン：検索 -->
    <a class="nav-link mb-4" href="{{ route('users.search')}}">
        <i class="fas fa-search fa-lg"></i>
    </a>

    <!-- 固定アイコン：設定 -->
    <a class="nav-link mb-4" href=""> <!--settingページへのルートを入れる-->
        <i class="fas fa-cog fa-lg"></i>
    </a>

    <!-- 右にスライドで出るメニュー -->
    <div class="collapse position-absolute"
         id="sidebarMenuContent"
         style="top: 70px; left: 80px; width: 180px;">
        <div class="card shadow-sm">
            <ul class="list-group list-group-flush">

                <li class="list-group-item">
                    <a href="" class="text-decoration-none text-dark"> <!--chatページへのルートを入れる-->
                        <i class="fas fa-comment me-2"></i>{{ __('messages.chat')}}
                    </a>
                </li>

                <li class="list-group-item">
                    <a href="" class="text-decoration-none text-dark"> <!--vocabularyページへのルートを入れる-->
                        <i class="fas fa-book me-2"></i>{{ __('messages.vocabulary')}}
                    </a>
                </li>

                @guest
                    @if (Route::has('login'))
                        <li class="list-group-item">
                            <a class="text-decoration-none text-dark" href="{{ route('login') }}">{{__('messages.login')}}</a>
                        </li>
                    @endif
                    @if (Route::has('register'))
                        <li class="list-group-item">
                            <a class="text-decoration-none text-dark" href="{{ route('register') }}">{{__('messages.register')}}</a>
                        </li>
                    @endif
                @else
                    <li class="list-group-item">
                        <a class="text-decoration-none text-dark"
                           href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-right-from-bracket me-2"></i> {{__('messages.logout')}}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endguest

            </ul>
        </div>
    </div>
</div>
