<div class="header-nav @if(!Route::is('home')) small-header @endif" id="header" style="background-position: 0px;background: url('{{ setting('background') ? image_url(setting('background')) : 'https://via.placeholder.com/2000x500' }}') top / cover no-repeat">
    <div class="header-nav-top sub-navigation">
        <div class="container">
            <ul class="header-nav-top-left">
                <li class="item" style="list-style-type: none;">
                    <div class="online">
                        @if($server && $server->isOnline())
                        <p>{{ trans_choice('messages.server.online', $server->getOnlinePlayers()) }}</p>
                        @else
                        <p>{{ trans('messages.server.offline') }}</p>
                        @endif
                    </div>
                </li>
            </ul>
            <ul class="header-nav-top-right">
                @guest
                @plugin('discord-auth')
                @guest
                <li class="item" style="list-style-type: none;">
                    <a href="{{ route('discord-auth.login') }}">{{ trans('discord-auth::messages.login_via_discord') }}</a>
                </li>
                @endguest
                @endplugin
                <li class="item" style="list-style-type: none;">
                    <a href="{{ route('login') }}">
                        {{ trans('auth.login') }}
                    </a>
                </li>
                @if(Route::has('register'))
                <li class="item" style="list-style-type: none;">
                    <a href="{{ route('register') }}">
                        {{ trans('auth.register') }}
                    </a>
                </li>
                @endif
                @else
                @include('elements.notifications')
                <li class="item" style="list-style-type: none;">
                    <a id="userDropdown" class="nav-link dropdown-toggle user-nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ auth()->user()->getAvatar(150) }}" class="rounded img-fluid" alt="{{ auth()->user()->name }}"> {{ Auth::user()->name }} <span class="caret"></span>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('profile.index') }}">
                            {{ trans('messages.nav.profile') }}
                        </a>

                        @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                        <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                            {{ trans($navItem['name']) }}
                        </a>
                        @endforeach

                        @if(Auth::user()->hasAdminAccess())
                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                            {{ trans('messages.nav.admin') }}
                        </a>
                        @endif

                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ trans('auth.logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>

    <div class="header-nav-bottom navigation dropdown-menu-right">
        <div class="container navigation-content ">
            <ul class="header-nav-bottom-left">
                <li class="item logo">
                    <a href="{{ route('home') }}">
                        @if(setting('logo'))
                        <img src="{{ image_url(setting('logo')) }}" alt="{{ site_name() }} Logo">
                        @endif
                    </a>
                </li>
                @foreach($navbar as $element)
                @if(!$element->isDropdown())
                <li class="item @if($element->isCurrent()) active @endif">
                    <a href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                        {{ $element->name }}
                    </a>
                </li>
                @else
                <li class="dropdown item" style="list-style-type: none;">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ $element->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                        @foreach($element->elements as $childElement)
                        <a class="dropdown-item @if($childElement->isCurrent()) active @endif text-white" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                        @endforeach
                    </div>
                </li>
                @endif
                @endforeach
            </ul>
            <ul class="header-nav-bottom-right">
                @foreach(['twitter', 'youtube', 'discord', 'steam', 'instagram'] as $social)
                @if($socialLink = theme_config("footer_social_{$social}"))
                <li class="item">
                    <a href="{{ $socialLink }}">
                        <i class="fab fa-{{ $social }}"></i>
                    </a>
                </li>
                @endif
                @endforeach
            </ul>
        </div>
    </div>

    @if(Route::is('home'))
    <div class="header-content">
        <div class="container" style="position: relative">
            <div class="header-content-mid">
                <div class="description">
                    <h1>{{ site_name() }}</h1>
                    <p>{{ theme_config('subtitle') }}</p>
                </div>
            </div>
            <div class="header-content-bottom">
                <div class="go-to-bottom">
                    <span><i id="go-to-bottom" class="fas fa-chevron-down"></i></span>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="header-mobile-nav">
    <div class="mobile-btn" id="mobile-btn">
        <span id="nav-btn-icon"><i class="fas fa-bars"></i></span>
    </div>

    <ul class="mobile-navigation" id="mobile-nav">
        <li>
            @if(setting('logo'))
            <img src="{{ image_url(setting('logo')) }}" alt="Logo">
            @endif
        </li>

        @foreach($navbar as $element)
        @if(!$element->isDropdown())
        <li class="item @if($element->isCurrent()) active @endif">
            <a href="{{ $element->getLink() }}" @if($element->new_tab) target="_blank" rel="noopener noreferrer" @endif>
                <span class="name">{{ $element->name }}</span>
            </a>
        </li>
        @else
        <li class="item nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown{{ $element->id }}" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ $element->name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown{{ $element->id }}">
                @foreach($element->elements as $childElement)
                <a class="dropdown-item @if($childElement->isCurrent()) active @endif" href="{{ $childElement->getLink() }}" @if($childElement->new_tab) target="_blank" rel="noopener noreferrer" @endif>{{ $childElement->name }}</a>
                @endforeach
            </div>
        </li>
        @endif
        @endforeach
        @guest
        <li class="item">
            <a href="{{ route('login') }}">
                <span class="name">{{ trans('auth.login') }}</span>
            </a>
        </li>

        @if(Route::has('register'))
        <li class="item">
            <a href="{{ route('register') }}">
                <span class="name">{{ trans('auth.register') }}</span>
            </a>
        </li>
        @endif
        @else
        <li class="item nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="notificationsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }} <span class="caret"></span>
            </a>
            <div class="dropdown-menu" aria-labelledby="notificationsDropdown">
                <a class="dropdown-item" href="{{ route('profile.index') }}">
                    {{ trans('messages.nav.profile') }}
                </a>

                @foreach(plugins()->getUserNavItems() ?? [] as $navId => $navItem)
                <a class="dropdown-item" href="{{ route($navItem['route']) }}">
                    {{ trans($navItem['name']) }}
                </a>
                @endforeach

                @if(Auth::user()->hasAdminAccess())
                <a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                    {{ trans('messages.nav.admin') }}
                </a>
                @endif

                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ trans('auth.logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
        @endguest
    </ul>
</div>