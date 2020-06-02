
<style rel="stylesheet">
    @import url('https://fonts.googleapis.com/css?family=Roboto');

    * {
        font-family: 'Roboto', sans-serif;
    }

    .header {
        background-color: #525f7f;
        width: 100%;
        text-align: center;
    }

    .header img {
        width: 18%;
        padding: 50px 0;
    }

    .body {
        margin-top: 40px;
    }

    .body h1 {
        color: #fff;
        text-align: center;
        font-size: 2em;
        margin-bottom: 20px;
    }

    .body p {
        margin: 20px 20%;
        text-align: center;
    }

    .create-account {
        text-align: center;
        margin: 80px 0px 120px 0px;
    }

    .create-account a {
        background-color: #825ee4;
        color: #fff;
        padding: 15px 20px;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
    }

    .footer {
        padding: 10px 0px;
        background-color: #825ee4;
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        color: white;
        text-align: center;
    }

    .footer p {
        font-size: 0.8em;
    }

</style>

<div class="header">
    <img src="{{ asset('argon') }}/img/brand/favicon1.png">
</div>
<div class="body">
    <h1 style="color: black;">¡{{ __('Bienvenido') }}!</h1>
    <p>{{ $register->name }}, {{ __('gracias por registrarte en') }} <strong> {{ __('¿Cómo como?') }} </strong> </p>
    <p>{{ __('Contraseña') }}: <strong> {{ $register->password }}

    <p>{{ __('Activa tu cuenta dando clic al siguiente botón') }}.</p>

    <div class="create-account">
        <a href="{{ route('signup.token', ['token' => $token]) }}">{{ __('Activar cuenta') }}</a>
    </div>
</div>
<div class="footer">
    <p>&copy; {{ now()->year }}, ¿Cómo como?</p>
</div>
