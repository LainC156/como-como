@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Suscripción')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col-8">
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="" class="btn btn-sm btn-primary">{{ __('Alguna opción') }}</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                <strong>¡Error!:</strong> {{ session('error') }}
                            </div>
                        @elseif(session('success'))
                            <div class="alert alert-success" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
                                <strong>¡Listo!:</strong> {{ session('success') }}
                            </div>
                        @endif
                        <!-- search input -->
                        <div class="container">
                            @if ($user->trial_version_status === true)
                                <h3 class="display-2 text-primary text-center"><i
                                        class="ni ni-check-bold"></i>{{ __('Cuenta activa') }}.</h2>
                                    <h4 class="display-4 text-success text-center">
                                        {{ __('Este es tu mes de prueba gratis') }}</h4>
                                @elseif( $user->subscription_status === true && $user->trial_version_status === false)
                                    <h3 class="display-2 text-primary text-center"><i
                                            class="ni ni-check-bold"></i>{{ __('Cuenta activa') }}.</h2>
                                        <div class="row text-center">
                                            @if ($role_id == 2)
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="patients"
                                                            class="form-control-label">{{ __('Total de pacientes') }}:</label>
                                                        <input type="number" class="form-control text-center" id="patients"
                                                            value="{!! $total_patients !!}" disabled>
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="amount"
                                                        class="form-control-label">{{ __('Monto') }}:</label>
                                                    <input type="number" class="form-control text-center" id="amount"
                                                        value="{!! $amount_to_pay !!}" disabled>
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="currency_unit"
                                                        class="form-control-label">{{ __('Unidad de cambio') }}:</label>
                                                    <input id="currency_unit" type="text" value="{!! $user->currency_unit !!}"
                                                        class="form-control text-center" disabled />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="payment_date"
                                                        class="form-control-label">{{ __('Fecha de pago') }}:</label>
                                                    <input id="payment_date" type="text" value="{!! $user->current_date !!}"
                                                        class="form-control text-center" disabled />
                                                </div>
                                            </div>
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="expiration_date"
                                                        class="form-control-label">{{ __('Fecha de vencimiento') }}:</label>
                                                    <input id="expiration_date" type="text" value="{!! $user->expiration_date !!}"
                                                        class="form-control text-center" disabled />
                                                </div>
                                            </div>
                                        </div>
                                    @elseif( $user->trial_version_status === false && $user->subscription_status ===
                                        false )
                                        <h3 class="display-4 text-warning text-center">
                                            {{ __('Tu cuenta está inactiva, para poder activar tu cuenta es necesario que realices el pago correspondiente.') }}
                                        </h3>
                                        <div class="row text-center">
                                            @if($user->expiration_date !== null)
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="expiration_date"
                                                        class="form-control-label">{{ __('Fecha de vencimiento') }}:</label>
                                                    <input id="expiration_date" type="text" value="{!! $user->expiration_date !!}"
                                                        class="form-control text-center" disabled />
                                                </div>
                                            </div>
                                            @endif
                                            @if ($role_id == 2)
                                                <div class="col-auto">
                                                    <div class="form-group">
                                                        <label for="patients"
                                                            class="form-control-label">{{ __('Total de pacientes') }}:</label>
                                                        <input id="patients" type="text" value="{!! $total_patients !!}"
                                                            class="form-control text-center" disabled />
                                                    </div>
                                                </div>
                                            @endif
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="amount"
                                                        class="form-control-label">{{ __('Monto a pagar') }}:</label>
                                                    <input type="number" class="form-control text-center" id="amount"
                                                        value="{!! $amount_to_pay !!}" disabled>
                                                </div>
                                            </div>
                                            @if($user->currency_unit !== null)
                                            <div class="col-auto">
                                                <div class="form-group">
                                                    <label for="currency_unit"
                                                        class="form-control-label">{{ __('Unidad de cambio') }}:</label>
                                                    <input id="currency_unit" type="text" value="{!! $user->currency_unit !!}"
                                                        class="form-control text-center" disabled />
                                                </div>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="display-3">
                                            <h2 class="text-primary text-center">{{ __('Métodos de pago') }}</h2>
                                        </div>
                                        <div class="nav-wrapper">
                                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text"
                                                role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab"
                                                        data-toggle="tab" href="#tabs-icons-text-4" role="tab"
                                                        aria-controls="tabs-icons-text-4" aria-selected="false"><i
                                                            class="fab fa-cc-paypal fa-2x"></i> {{ __('Paypal') }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="tab-content" id="myTabContent">
                                                    <div class="tab-pane fade show active" id="tabs-icons-text-4"
                                                        role="tabpanel" aria-labelledby="tabs-icons-text-4-tab">
                                                        <div class="content text-center">

                                                            <table border="0" cellpadding="10" cellspacing="0"
                                                                align="center">
                                                                <tr>
                                                                    <td align="center"></td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="center"><a
                                                                            href="https://www.paypal.com/in/webapps/mpp/paypal-popup"
                                                                            title="How PayPal Works"
                                                                            onclick="javascript:window.open('https://www.paypal.com/in/webapps/mpp/paypal-popup','WIPaypal','toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=1060, height=700'); return false;"><img
                                                                                src="https://www.paypalobjects.com/webstatic/mktg/Logo/pp-logo-200px.png"
                                                                                border="0" alt="PayPal Logo"></a></td>
                                                                </tr>
                                                            </table>

                                                            <a href="{{ route('paypal.payment') }}"
                                                                class="btn btn-success">{{ __('Pagar desde Paypal') }}</a>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@section('javascript')

@endsection
