<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-shadow mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row m-0">
                                <div class="col-4">
                                    <input class="form-control" type="text" id="food_name" disabled
                                        placeholder="{{ __('Selecciona algún alimento de la tabla') }}">
                                </div>
                                <div class="col-2">
                                    <input class="form-control" type="number" id="food_amount"
                                        placeholder="{{ __('Cantidad') }}">
                                </div>
                                <div class="col-3">
                                    <select class="form-control" name="food_time" id="food_time">
                                        <option value="-1" disabled default>{{ __('Tiempo') }}</option>
                                        <option value="0">{{ __('Desayuno') }}</option>
                                        <option value="1">{{ __('Colación matutina') }}</option>
                                        <option value="2">{{ __('Comida') }}</option>
                                        <option value="3">{{ __('Colación vespertina') }}</option>
                                        <option value="4">{{ __('Cena') }}</option>
                                    </select>
                                </div>
                                <div class="col-3">
                                    <button id="add_food" type="button" class="btn btn-default " data-container="body"
                                        data-color="default" data-toggle="popover" data-placement="bottom" disabled><i
                                            class="ni ni-fat-add"></i>{{ __('Agregar al menú') }}</button>
                                </div>
                                <!--
                                <div class="col-1">
                                    <button id="remove_data" class="btn btn-warning">
                                        <i class="fas fa-trash"></i>{{ __('Limpiar campos') }}</button>
                                </div> -->
                            </div>
                            <div class="row">
                                @include('helpers.alerts')
                                <!-- food data table -->
                                <div class="table-responsive">
                                    <table id="food_table" class="table align-items-center table-flush">
                                        <thead class="thead-light">
                                            <tr>
                                                <th scope="col">{{ __('Nombre') }}</th>
                                                <th scope="col">{{ __('KCAL') }}</th>
                                                <th scope="col">{{ __('KJ') }}</th>
                                                <th scope="col">{{ __('Agua') }}</th>
                                                <th scope="col">{{ __('Fibra dietética') }}</th>
                                                <th scope="col">{{ __('Carbohidratos') }}</th>
                                                <th scope="col">{{ __('Proteínas') }}</th>
                                                <th scope="col">{{ __('Lípidos totales') }}</th>
                                                <th scope="col">{{ __('Lípidos saturados') }}</th>
                                                <th scope="col">{{ __('Lípidos monosaturados') }}</th>
                                                <th scope="col">{{ __('Lípidos polisaturados') }}</th>
                                                <th scope="col">{{ __('Colesterol') }}</th>
                                                <th scope="col">{{ __('Calcio') }}</th>
                                                <th scope="col">{{ __('Fósforo') }}</th>
                                                <th scope="col">{{ __('Hierro') }}</th>
                                                <th scope="col">{{ __('Magnesio') }}</th>
                                                <th scope="col">{{ __('Sodio') }}</th>
                                                <th scope="col">{{ __('Potasio') }}</th>
                                                <th scope="col">{{ __('Zinc') }}</th>
                                                <th scope="col">{{ __('Vitamina A') }}</th>
                                                <th scope="col">{{ __('Ácido ascórbico') }}</th>
                                                <th scope="col">{{ __('Tiamina') }}</th>
                                                <th scope="col">{{ __('Riboflavina') }}</th>
                                                <th scope="col">{{ __('Niacina') }}</th>
                                                <th scope="col">{{ __('Piridoxina') }}</th>
                                                <th scope="col">{{ __('Ácido fólico') }}</th>
                                                <th scope="col">{{ __('Cobalamina') }}</th>
                                                <th scope="col">{{ __('Porcentaje comestible') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody id="search_table">
                                        </tbody>
                                    </table>
                                    <div id="pagination">
                                    </div>
                                </div>
                                <!-- end food data table -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
