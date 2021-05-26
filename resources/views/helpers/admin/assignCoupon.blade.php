<div class="modal fade" id="assignCouponModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="progress-wrapper">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ __('Se enviará un correo a los usuarios seleccionados para que activen su promoción') }}
                    </h5>
                    <div class="progress-info">
                        <div class="progress-label">
                            <span>{{ __('Progreso de selección de cupones') }}</span>
                        </div>
                        <div class="progress-percentage">
                            <span id="progress_span_text">0%</span>
                        </div>
                    </div>
                    <div class="progress">
                        <div id="progress_span_percent" class="progress-bar bg-primary" role="progressbar"
                            aria-valuenow="10" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div>
                    </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="select_coupon_row" class="row text-center">
                    <!-- coupon amount, identificator, name and description -->
                    <div class="col text-left">
                        <div class="form-group">
                            <label class="form-control-label text-primary">{{ __('Cupones disponibles') }}
                                ({{ __('Identificador') }})/
                                {{ __('Nombre y descripción') }}</label>
                            @forelse ($coupons as $coupon)
                                <div class="custom-control custom-radio custom-radio-inline mb-3">
                                    <input data-total="{!! $coupon->total !!}"
                                        data-description="{!! $coupon->description !!}" data-name="{!! $coupon->name !!}"
                                        data-id="{!! $coupon->identificator !!}" name="custom-radio-btn"
                                        class="custom-control-input coupon" id="customRadio{!! $coupon->identificator !!}"
                                        type="radio">
                                    <label class="custom-control-label"
                                        for="customRadio{{ $coupon->identificator }}"><strong>{!! $coupon->total !!}
                                            ({!! $coupon->identificator !!}) </strong>/
                                        {!! $coupon->name !!} ({!! $coupon->description !!})</label>
                                </div>
                            @empty
                                <small>{{ __('Sin cupones disponibles') }}</small>
                            @endforelse
                        </div>
                        <button disabled id="select_coupon_next_btn"
                            class="btn btn-primary btn-sm">{{ __('Siguiente') }}</button>
                    </div>
                </div>
                <div id="select_users_row" hidden class="row">
                    <div class="col">
                        <!-- patients availables -->
                        <div class="form-group">
                            <label class="form-control-label text-primary"
                                for="edit_component_name">{{ __('Pacientes seleccionables') }} {{ __('Nombre') }},
                                {{ __('apellidos') }}, {{ __('correo') }} {{ __('y') }}
                                {{ __('tipo de cuenta') }}</label>
                            @forelse ($patients as $patient)
                                <div class="custom-control custom-checkbox mb-3">
                                    <input data-id="{!! $patient->id !!}" data-name="{!! $patient->name !!}"
                                        data-last_name="{!! $patient->last_name !!}" data-email="{!! $patient->email !!}"
                                        name="custom-checkbox-btn{!! $patient->id !!}"
                                        class="custom-control-input user" id="customRadio{!! $patient->id !!}"
                                        type="checkbox">
                                    <label class="custom-control-label" for="customRadio{{ $patient->id }}">
                                        {!! $patient->name !!} {!! $patient->last_name !!} ({!! $patient->email !!})
                                        <strong>
                                            @if ($patient->trial_version_status)
                                            {{ __('Versión de prueba') }} @else {{ __('Versión de pago') }}
                                            @endif
                                        </strong></label>
                                </div>
                            @empty
                                <small>{{ __('Sin usuarios seleccionables') }}</small>
                            @endforelse
                        </div>
                    </div>
                    <div class="col">
                        <!-- nutritionists availables -->
                        <div class="form-group">
                            <label class="form-control-label text-primary"
                                for="edit_component_name">{{ __('Nutriólogos seleccionables') }}
                                {{ __('Nombre') }}, {{ __('apellidos') }},
                                {{ __('correo') }} {{ __('y') }} {{ __('tipo de cuenta') }}</label>
                            @forelse ($nutritionists as $nutritionist)
                                <div class="custom-control custom-checkbox mb-3">
                                    <input data-id="{!! $nutritionist->id !!}" data-name="{!! $nutritionist->name !!}"
                                        data-last_name="{!! $nutritionist->last_name !!}" data-email="{!! $nutritionist->email !!}"
                                        name="custom-checkbox-btn{!! $nutritionist->id !!}"
                                        class="custom-control-input user" id="customRadio{!! $nutritionist->id !!}"
                                        type="checkbox">
                                    <label class="custom-control-label" for="customRadio{{ $nutritionist->id }}">
                                        {!! $nutritionist->name !!} {!! $nutritionist->last_name !!} ({!! $nutritionist->email !!})
                                        <strong>
                                            @if ($nutritionist->trial_version_status)
                                            {{ __('Versión de prueba') }} @else {{ __('Versión de pago') }}
                                            @endif
                                        </strong></label>
                                </div>
                            @empty
                                <small>{{ __('Sin usuarios seleccionables') }}</small>
                            @endforelse
                        </div>
                    </div>
                </div>
                <button hidden id="back_user_btn" class="btn btn-primary btn-sm">{{ __('Regresar') }}</button>
                <button hidden id="next_user_btn" class="btn btn-primary btn-sm"
                    disabled>{{ __('Siguiente') }}</button>
                <div id="confirmation_row" class="row" hidden>
                    <div id="confirmation_col" class="col">
                    </div>
                </div>
                <button hidden id="back_confirmation_btn"
                    class="btn btn-primary btn-sm">{{ __('Regresar') }}</button>
            </div>
            <div class="modal-footer">
                <div class="text-muted">
                    <span class="text-warning"><strong>{{ __('Nota') }} 1:</strong>
                        {{ __('Solo se puede asignar un cupón a la vez y por usuario') }}
                    </span>
                    <br>
                    <span class="text-warning"><strong>{{ __('Nota') }} 2:</strong>
                        {{ __('Al final se muestra el cupón y los usuarios seleccionados') }}
                    </span>
                    <br>
                    <span class="text-warning"><strong>{{ __('Nota') }} 3:</strong>
                        {{ __('Después de enviar los cupones se recargará la página para actualizar los datos') }}
                    </span>
                    <br>
                    <span hidden id="excesiveUsers" class="text-danger">{{ __('Error') }}:
                        {{ __('hay mas usuarios seleccionados que cupones disponibles') }}</span>
                </div>
                <div class="col text-center">
                    <button id="loader" class="btn btn-primary" hidden>
                        <span class="spinner-border spinner-border"></span>
                        {{ __('Procesando') }}...
                    </button>
                    <button id="send_coupons_btn" type="button" data-container="body" data-toggle="popover"
                        data-placement="top" class="btn btn-primary" disabled><i
                            class="ni ni-fat-add"></i>{{ __('Enviar cupones') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
