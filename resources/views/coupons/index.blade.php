@extends('layouts.app')
@section('title')
    {{ __('Cupones') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('users.partials.header', ['title' => __('Generador de cupones')])
    <div class="container-fluid mt--7">
        <input type="hidden" id="users_list" value="">
        <input type="hidden" id="false" value="{{ __('No usado') }}">
        <input type="hidden" id="true" value="{{ __('En uso') }}">
        <input type="hidden" id="url_coupons" value="{{ route('coupon.index') }}">
        <input type="hidden" id="store_coupons" value="{{ route('coupon.store') }}">
        <input type="hidden" id="send_coupon_url" value="{{ route('coupon.send') }}">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div>
                            @include('helpers.alerts')
                        </div>
                        @if ($role_id === 1)
                            <div class="text-right">
                                <button id="createCoupon" data-toggle="modal" data-target="#createCouponModal"
                                    class="btn btn-primary">{{ __('Crear cupones') }}</button>
                                <button id="assignCoupon" data-toggle="modal" data-target="#assignCouponModal"
                                    class="btn btn-default">{{ __('Asignar cupones') }}</button>
                            </div>
                        @else
                            <div>
                                <p>{{ __('A continuación puedes ingresar tu cupón correspondiente y activarlo') }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="card-body">
                        @if ($role_id === 1)
                            <div class="table-responsive">
                                <table id="coupons_table" class="table align-items-center table-flush">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">{{ __('Identificador') }}</th>
                                            <th scope="col">{{ __('Nombre') }}</th>
                                            <th scope="col">{{ __('Descripción') }}</th>
                                            <th scope="col">{{ __('Código') }}</th>
                                            <th scope="col">{{ __('Estado') }}</th>
                                            <th scope="col">{{ __('Días de promoción') }}</th>
                                            <th scope="col">{{ __('ID de usuario') }}</th>
                                            <th scope="col">{{ __('Fecha de creación') }}</th>
                                            <th scope="col">{{ __('Última actualización') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div> <!-- end table -->
                        @else
                            <div class="row">
                                <div class="col">
                                    <input class="form-control form-control-alternative" type="text" name="promotional_code"
                                        id="promotional_code">
                                </div>
                                <button id="loader" class="btn btn-primary" hidden>
                                    <span class="spinner-border spinner-border"></span>
                                    {{ __('Procesando') }}...
                                </button>
                                <div class="col">
                                    <a hidden id="activate_coupon_btn" class="btn btn-primary"
                                        type="button">{{ __('Activar cupón') }}</a>
                                    <button id="verify_coupon_btn" class="btn btn-primary"
                                        type="button">{{ __('Verificar cupón') }}</button>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @if ($role_id === 1)
            @include('helpers.admin.createCoupon')
            @include('helpers.admin.assignCoupon')
        @endif
        @include('layouts.footers.auth')
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/coupon/index.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
