<!-- save menu modal -->
<div class="modal fade" id="saveMenuModal" tabindex="-1" role="dialog" aria-labelledby="saveMenuModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header alert-success">
                <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Guardar menú') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3 class="mb-0 text-red">{{ __('Campos requeridos') }} *</h3>
                <div class="col" >
                    <div class="form-group">
                        <label class="form-control-label" for="save_menu_name">{{ __('Nombre') }}
                            <span id="name_required" style="color: red;">*</span>
                            <span id="name_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                        </label>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                            </div>
                            <input type="text" id="menu_name" name="save_new_menu_name" class="form-control" placeholder="{{ __('Nombre') }}" />
                        </div>
                    </div>
                </div>
                <div class="col" >
                    <div class="form-group">
                        <label class="form-control-label" for="save_menu_description">{{ __('Descripción') }}
                            <span id="description_required" style="color: red;">*</span>
                            <span id="description_check" style="display:none;" class="text-green"><i class="ni ni-check-bold"></i></span>
                        </label>
                        <div class="input-group input-group-alternative">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="ni ni-caps-small"></i></span>
                            </div>
                            <textarea type="text" id="menu_description"name="save_new_menu_description" class="form-control" placeholder="{{ __('Descripción') }}"></textarea>
                        </div>
                    </div>
                </div>
                <div class="col alert alert-success">
                    <p class="text-black">{{ __('Al guardar el menú, serás redireccionado a los menús disponibles del paciente') }}</p>
                </div>
                <div class="col">
                    <button id="save_menu_btn" class="btn btn-success btn-block"><i class="ni ni-folder-17"></i> {{ __('Guardar') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
