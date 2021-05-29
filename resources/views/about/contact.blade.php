@extends('layouts.app', ['class' => 'bg-default'])
@section('title')
    {{ __('Acerca de') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('layouts.headers.guest')

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card bg-secondary shadow border-0">
                    <!--
                        <div class="card-header bg-transparent pb-5">
                            <div class="text-muted text-center mt-2 mb-3"><small>{{ __('Sign in with') }}</small></div>
                            <div class="btn-wrapper text-center">

                            </div>
                        </div>
                        -->
                    <div class="card-body px-lg-5 py-lg-5">
                        <div class="text-center text-muted mb-4">
                            <strong>
                                {{ __('Contacto') }}
                            </strong>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
