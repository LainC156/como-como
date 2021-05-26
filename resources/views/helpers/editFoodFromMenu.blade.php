<!-- edit food from menu modal -->
<div class="modal fade" id="editMenuComponentModal" tabindex="-1" role="dialog" aria-labelledby="editComponentMenuModal"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header alert-primary">
                <h3 class="modal-title mb-0" id="editMenuComponentModalTitle">{{ __('Editar componente') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-wrapper">
                    <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                aria-selected="true"><i class="ni ni-cloud-upload-96 mr-2"></i>{{ __('Editar') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                aria-selected="false"><i class="ni ni-bell-55 mr-2"></i>{{ __('Borrar') }}</a>
                        </li>
                    </ul>
                </div>
                <div class="card shadow">
                    <div class="card-body">
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                aria-labelledby="tabs-icons-text-1-tab">
                                <div class="row">
                                    <!-- food name -->
                                    <div class="col-auto">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="edit_component_name">{{ __('Nombre') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="ni ni-caps-small"></i></span>
                                                </div>
                                                <input type="text" id="menuComponentNameEdited"
                                                    name="edit_component_name" class="form-control" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- food weight -->
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="edit_component_amount">{{ __('Peso(ml./gr.)') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i
                                                            class="fas fa-sort-numeric-up"></i></span>
                                                </div>
                                                <input type="number" id="menuComponentFoodWeightEdited"
                                                    name="edit_component_amount" class="form-control" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- kind of food -->
                                    <div class="col">
                                        <div class="form-group">
                                            <label class="form-control-label"
                                                for="edit_component_kindoffood">{{ __('Tiempo') }}</label>
                                            <div class="input-group input-group-alternative">
                                                <div class="input-group-prepend  btn btn-sm btn-block">
                                                    <select id="menuComponentKindOfFoodEdited" class="form-control"
                                                        name="edit_component_kindoffood" data-toggle="tooltip"
                                                        data-placement="top"
                                                        title="{{ __('Selecciona en que momento del día fue consumido el alimento') }}">
                                                        <option value="-1" disabled>{{ __('Tipo de comida') }}
                                                        </option>
                                                        <option value="0">{{ __('Desayuno') }}</option>
                                                        <option value="1">{{ __('Colación matutina') }}</option>
                                                        <option value="2">{{ __('Comida') }}</option>
                                                        <option value="3">{{ __('Colación vespertina') }}</option>
                                                        <option value="4">{{ __('Cena') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col text-center">
                                            <button id="update_component_btn" type="button" data-container="body"
                                                data-color="default" data-toggle="popover" data-placement="top"
                                                class="btn btn-default"><i
                                                    class="ni ni-fat-add"></i>{{ __('Actualizar componente') }}</button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                aria-labelledby="tabs-icons-text-2-tab">
                                <div class="alert alert-warning" role="alert">
                                    <strong>{{ __('Advertencia') }}:
                                    </strong>{{ __('Esta acción no puede deshacerse') }}
                                </div>
                                <div class="col text-center ">
                                    <button id="delete_component_btn" class="btn btn-warning"><i
                                            class="ni ni-fat-remove"
                                            aria-hidden="true"></i>{{ __('Eliminar componente') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
