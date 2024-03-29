@extends('layouts.app', ['class' => 'bg-default'])
@section('title')
    {{ __('Inicio de sesión') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <div class="card-body px-lg-5 py-lg-5">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                <strong>¡{{ __('Error') }}!:</strong> {{ session('error') }}
                            </div>
                        @elseif(session('success'))
                            <div class="alert alert-success" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
                                <strong>¡{{ __('Listo') }}!:</strong> {{ session('success') }}
                            </div>
                        @endif
                        <div class="text-center text-muted mb-4">
                            <small>
                                <a href="{{ route('register') }}">{{ __('Crea una cuenta nueva') }}</a>
                                {{ __('O inicia sesión con tu correo y contraseña') }}
                            </small>
                        </div>
                        <form role="form" method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}"
                                        placeholder="{{ __('Correo') }}" type="email" name="email"
                                        value="{{ old('email') }}" value="" required autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <!--<strong>{{ $errors->first('email') }}</strong>-->
                                        <strong>{{ __('El correo o contraseña son incorrectos') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                        name="password" placeholder="{{ __('Contraseña') }}" type="password" value=""
                                        required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <!-- <strong>{{ $errors->first('password') }}</strong>-->
                                        <strong>{{ __('El correo o contraseña son incorrectos') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-muted">{{ __('Recuérdame') }}</span>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary my-4">{{ __('Iniciar sesión') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <!--
                        <div class="col-6">
                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-light">
                                    <small>{{ __('¿Olvidaste tu contraseña?') }}</small>
                                </a>
                            @endif
                        </div>
                        -->
                    <div class="col-12 text-center">
                        <a href="{{ route('register') }}" class="text-light">
                            <small>{{ __('Crea una cuenta nueva') }}</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
