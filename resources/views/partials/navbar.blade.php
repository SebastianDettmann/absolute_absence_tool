<nav class="navbar navbar-default navbar-expand-lg bg-light">
    <a class="navbar-brand mt-1" href="{{ route('dashboard') }}">
        <img class="mr-2" src="{{asset('images/absolute.png')}}" height="30" alt="{{__('Absolute Logo')}}"/>
        {{ config('app.name', 'Absolute Absence Tool') }}
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse navbar-responsive-collapse" id="navbarSupportedContent">
        @guest
            <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                </ul>
        @else
            <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('period.index')}}">{{ __('Übersicht') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('period.indexall')}}">{{ __('Im Büro?') }}</a>
                    </li>
                    @if(\Auth::user()->admin)
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('confirm.index') }}">{{ __('Abwesenheit genehmigen') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               href="{{ route('reason.index') }}">{{ __('Gründe für Abwesenheit') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('report') }}">{{ __('Auswertung') }}</a>
                        </li>
                    @endif
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <img src="https://www.gravatar.com/avatar/{{ md5(\Auth::user()->email) }}?s=30&r=g&d=mm"
                                 class="img-circle"/>
                            {{ Auth::user()->fullname() }}
                            <span class="caret"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item"
                               href="{{ route('user.edit', [\Auth::user()->id]) }}">{{ __('Profil') }}</a>
                            <a class="dropdown-item"
                               href="{{ asset('userdocumentation/aat_benutzerhandbuch.pdf') }}">{{ __('Hilfe') }}</a>
                            @if(\Auth::user()->admin)
                                <a class="dropdown-item" href="{{ route('user.index') }}">{{ __('Verwaltung') }}</a>
                            @endif
                            <div class="dropdown-divider"></div>
                            <!-- Authentication Links -->
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            @endguest
    </div>
</nav>
