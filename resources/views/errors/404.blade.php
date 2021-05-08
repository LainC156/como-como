<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error 404</title>
</head>

<body class="{{ $class ?? '' }}">
    @include('layouts.headers.guest')
    <div class="container text-center">
        <div class="card">
            <h3>{{ __('No es posible ingresar a la página solicitada :(') }}</h3>
            <a href="{{ route('home') }}">Regresar a inicio</a>
        </div>
    </div>
</body>

</html>
