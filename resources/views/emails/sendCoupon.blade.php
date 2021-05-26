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
    <h1 style="color: black;">¡{{ __('Hola') }}!</h1>
    <p>{{ $user->name }}, {{ __('acabas de recibir un cupón de') }} <strong> {{ __('¿Cómo como?') }} </strong>
        {{ __('que te permite disfrutar de una versión de pago de') }} <strong> {{ $coupon->days }}
            {{ __('días') }} </strong> {{ __('totalmente gratis') }} </p>
    <div class="create-account">
        <!-- The text field -->
        <input type="text" value="{!! $coupon->code !!}" id="myInput">

        <!-- The button used to copy the text -->
        <button onclick="copyCode()">{{ __('Copiar código') }}</button>
    </div>
    <div class="create-account">
        <div>
            <p>{{ __('Activa tu cupón dando clic al siguiente botón') }}: </p>
        </div>
        <a href="{{ route('coupon.activate', ['coupon_code' => $coupon->code]) }}">{{ __('Activar cupón') }}</a>
        <p>{{ __('o copiando y pegando el código en el siguiente enlace') }}:</p>
        <a href="{{ route('coupon.index') }}">{{ __('Ir a enlace para activar cupón') }}</a>
        <div class="mt-5">
            <p class="text-muted">{{ __('Nota') }}:
                {{ __('es importante recordar que cualquier otra suscripción activa se cancelará y se aplicará la promoción del cupón actual') }}</p>
        </div>
    </div>
</div>
<div class="footer">
    <p>&copy; {{ now()->year }}, ¿Cómo como?</p>
</div>
@section('script')
    <script>
        const copyCode = () => {
            /* Get the text field */
            const copyText = document.getElementById("myInput");

            /* Select the text field */
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */

            /* Copy the text inside the text field */
            document.execCommand("copy");

            /* Alert the copied text */
            alert({{ __('Código copiado:') }} + copyText.value);
        }

    </script>
@endsection
