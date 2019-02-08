<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Absolute Absence Tool') }}</title>
    <link rel="icon" href="{{ asset('images/absolute.ico') }}"/>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/jquery-ui.min.js') }}" defer></script>
    <script src="{{ asset('js/moment.min.js') }}" defer></script>
    @if($calendar ?? false)
        <script src="{{ asset('js/fullcalendar.js') }}" defer></script>
        <script src="{{ asset('js/locale-all.js') }}" defer></script>
        <script src="{{ asset('js/datepicker-de.js') }}" defer></script>
    @endif

<!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/all.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/absolute.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery-ui.min.css') }}" rel="stylesheet">
    @if($calendar ?? false)
        <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    @endif

</head>
<body>
<div id="app">
    @include('partials.navbar')
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
        @yield('content')
    </main>
</div>
@stack('foot-scripts')
</body>
</html>
