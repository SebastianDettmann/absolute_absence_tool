<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Absolute Software</title>
    <link rel="icon" href="{{ asset('images/absolute.ico') }}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/moment.min.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/absolute.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    <div class="container py-4">
        <nav class="navbar navbar-default navbar-expand-lg bg-light">
            <a class="navbar-brand mt-1" href="{{ route('dashboard') }}">
                <img class="mr-2" src="{{asset('images/absolute.png')}}" height="25" alt="{{__('Absolute Logo')}}"/>
                Absolute Software
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
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
                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                      style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    </ul>
                @endguest
            </div>
        </nav>
    </div>

    <main class="py-4">
        <div class="container">
            <div id="alert-holder">
                @foreach (\Alert::getMessages() as $type => $messages)
                    @foreach ($messages as $message)
                        <div class="alert alert-{{ $type }}">{!! $message !!}</div>
                    @endforeach
                @endforeach
            </div>
            @foreach ($errors as $error)
                <div class="row col-lg-12">
                    <div class="alert alert-danger">
                        <span>{{ $error }}</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">Dashboard</div>
                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif
                            <h4 class="mb-3"> {{ __('Willkommen bei Absolute Software !') }} </h4>
                            <p>
                                {{ __('Hier finden Sie Ihre freigeschalteten Ressourcen.') }}
                            </p>
                            <div class="m-4">
                                @foreach($accesses as $access)
                                    <div class="row m-1">
                                        <a href="{{ $access->url }}">
                                            {{ $access->title }}
                                            @if($access->image)
                                                <img class="ml-3" src="{{asset($access->image)}}" height="30"
                                                     alt="{{__('Logo für Zugang')}}"/>
                                            @endif
                                        </a>
                                    </div>
                                    <hr/>
                                @endforeach
                            </div>
                            <p>
                                {{ __('Sollten Sie weitere Ressourcen brauchen, fragen Sie Ihren Admin.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
</html>
