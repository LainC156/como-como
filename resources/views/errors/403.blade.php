<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 403 | ¿Cómo como?</title>
    <!-- Favicon -->
    <link href="/argon/img/brand/favicon1.png" rel="icon" type="image/png">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
    <link type="text/css" href="/argon/css/argon.min.css" rel="stylesheet">
</head>

<body class="{{ $class ?? '' }}">
    @include('layouts.headers.guest')
    <div class="container text-center">
        <div class="card">
            <h2 class="text-primary">{{ __('Error 404') }}</h2>
            <h3>{{ __('No tienes permitido acceder al recurso solicitado :(') }}</h3>
            <a href="{{ route('home') }}">Regresar a inicio</a>
        </div>
    </div>
    @include('layouts.footers.auth')
</body>

</html>
