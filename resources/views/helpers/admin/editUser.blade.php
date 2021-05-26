<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Editar datos del usuario') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- user name -->
                    <div class="col">
                        <div class="form-group">
                            <label class="form-control-label" for="edit_component_name">{{ __('Nombre') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input type="text" id="username" name="username" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- user lastname -->
                        <div class="form-group">
                            <label class="form-control-label" for="edit_component_name">{{ __('Apellidos') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input type="text" id="last_name" name="last_name" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- user email -->
                        <div class="form-group">
                            <label class="form-control-label"
                                for="edit_component_name">{{ __('Correo electrónico') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input type="text" id="email" name="email" class="form-control" disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- current and expiration date -->
                    <div class="col">
                        <div class="form-group">
                            <label class="form-control-label"
                                for="edit_component_amount">{{ __('Fecha del último pago') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                </div>
                                <input type="date" id="current_date" name="current_date" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label class="form-control-label"
                                for="edit_component_amount">{{ __('Válido hasta') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-sort-numeric-up"></i></span>
                                </div>
                                <input type="date" id="expiration_date" name="expiration_date" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- trial version or payment version -->
                        <div class="form-group">
                            <label class="form-control-label">{{ __('Modificar suscripción') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend  btn btn-sm btn-block">
                                    <span>{{ __('Versión de pago') }}</span>
                                    <label class="custom-toggle">
                                        <input id="subscription_status" type="checkbox">
                                        <span class="custom-toggle-slider rounded-circle"></span>
                                    </label>
                                    <span class="clearfix"></span>
                                    <span>{{ __('Versión de prueba') }}</span>
                                    <label class="custom-toggle">
                                        <input disabled id="trial_version_status" type="checkbox">
                                        <span class="custom-toggle-slider rounded-circle"></span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-muted">
                    <span class="text-warning"><strong>{{ __('Nota') }} 1:</strong>
                        {{ __('Para actualizar a versión de prueba no se necesita ingresar nada, en este caso se desactivan los registros de pago y se activa la versión de prueba por 1 mes') }}</span>
                    <br>
                    <span class="text-warning"><strong>{{ __('Nota') }} 2:</strong>
                        {{ __('Para actualizar a versión de pago se requieren ambas fechas(se puede ingresar el intervalo de tiempo que se desee), si existe una versión de pago activa solo se actualizan las fechas, si no hay una versión de pago activa se crea una nueva') }}</span>
                </div>
                <div>
                    @include('helpers.alerts')
                </div>
                <div class="col text-center">
                    <button id="update_user_btn" type="button" data-container="body" data-toggle="popover"
                        data-placement="top" class="btn btn-primary"><i
                            class="ni ni-fat-add"></i>{{ __('Actualizar usuario') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
