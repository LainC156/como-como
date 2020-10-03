<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <!--<meta name="viewport" content="width=device-width, initial-scale=1.0">-->
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ __('¿Cómo como?') }}</title>
        <!-- Favicon -->
        <link href="/argon/img/brand/favicon1.png" rel="icon" type="image/png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <!-- Icons -->
        <link href="/argon/vendor/nucleo/css/nucleo.css" rel="stylesheet">
        <link href="/argon/vendor/@fortawesome/fontawesome-free/css/all.min.css" rel="stylesheet">

        <!-- flag-icon-css -->
        <link type="text/css" rel="stylesheet" href="{{ asset('css/app.css') }}">
        <!-- Argon CSS -->
        <link type="text/css" href="/argon/css/argon.min.css" rel="stylesheet">
        <!-- DataTables CSS 
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">-->
        <link rel="stylesheet" href="/argon/vendor/datatables/css/datatables.min.css">
        <style>
            #input_name {
                text-transform:capitalize !important;
            }
            #input_last_name{
                text-transform:capitalize !important;
            }
        </style>
    </head>
    <body class="{{ $class ?? '' }}">
        @auth()
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @include('layouts.navbars.sidebar')
        @endauth

        <div class="main-content">
            @include('layouts.navbars.navbar')
            @yield('content')
        </div>

        @guest()
            @include('layouts.footers.guest')
        @endguest
        @stack('js')
        <script src="/argon/vendor/jquery/dist/jquery.min.js"></script>
        <!-- DataTables JS -->
        <!--<script src="http://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>-->
        <script src="/argon/vendor/datatables/js/datatables.min.js"></script>
        <!--<script src="/argon/vendor/datatables/accent-neutralise.js"></script>-->

        <!-- Bootstrap JS -->
        <script src="/argon/vendor/bootstrap/dist/js/bootstrap.bundle.min.js"></script>

        <!-- Argon JS -->
        <script src="{{ asset('argon') }}/js/argon.js?v=1.0.0"></script>

        @yield('javascript')
    </body>
</html>
