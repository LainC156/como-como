<div class="modal fade" id="createCouponModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ __('Crear cupones') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <!-- coupon name -->
                    <div class="col">
                        <div class="form-group">
                            <label class="form-control-label" for="coupon_name">{{ __('Nombre del cupón') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input type="text" id="coupon_name" name="coupon_name" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <!-- coupon description -->
                        <div class="form-group">
                            <label class="form-control-label"
                                for="edit_component_name">{{ __('Descripción del cupón') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input type="text" id="coupon_description" name="coupon_description"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <!-- coupon amount -->
                        <div class="form-group">
                            <label class="form-control-label" for="coupon_amount">{{ __('Cupones a crear') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input min="1" type="number" id="coupon_amount" name="coupon_amount"
                                    class="form-control">
                            </div>
                        </div>
                    </div>
                    <!-- coupon days -->
                    <div class="col">
                        <div class="form-group">
                            <label class="form-control-label"
                                for="coupon_days">{{ __('Días de suscripción') }}</label>
                            <div class="input-group input-group-alternative">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                                </div>
                                <input min="1" type="number" id="coupon_days" name="coupon_days" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-muted">
                    <span class="text-warning"><strong>{{ __('Nota') }} 1:</strong>
                        {{ __('Todos los campos son necesarios') }}</span>
                    <span class="text-warning"><strong>{{ __('Nota') }} 2:</strong>
                        {{ __('Después de crear los cupones se actualizará la página') }}</span>
                </div>
                <div class="col text-center">
                    <button id="create_coupon_btn" type="button" data-container="body" data-toggle="popover"
                        data-placement="top" class="btn btn-primary"><i
                            class="ni ni-fat-add"></i>{{ __('Crear cupones') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
