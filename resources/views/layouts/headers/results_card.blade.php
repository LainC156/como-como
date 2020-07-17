<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row">
                <div class="col-xl-12">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Resultados') }}</h5>
                                    @if($menu_data->ideal == 0)
                                        <span class="h3 font-weight-bold mb-0 text-red">{{ __('Estado') }}: {{ __('Desequilibrado') }}</span>
                                    @elseif($menu_data->ideal == 1)
                                        <span class="h3 font-weight-bold mb-0 text-green">{{ __('Estado') }}: {{ __('Equilibrado') }}</span>
                                    @endif
                                    <h3 class="mb-0">{{ __('Da clic sobre cualquier renglón para ver los detalles') }}</h3>
                                </div>
                                <div class="col">
                                        <h5 class="mb-0">{{ __('Paciente') }}:
                                            <b class="text-primary text-uppercase">{!! $patient->name !!} {!! $patient->last_name !!}</b>
                                        </h5>
                                        @if( $menu_data->name ==! '' && $menu_data->description ==! '' )
                                        <h5 class="mb-0">{{ __('Nombre') }}:
                                            <b class="text-primary text-uppercase" > {!! $menu_data->name !!}</b>
                                        </h5>
                                        <h5 class="mb-0">{{ __('Descripción') }}:
                                            <b class="text-primary text-uppercase">{!! $menu_data->description !!}</b>
                                        </h5>
                                        @else
                                            <b class="text-primary text-uppercase">{{ __('Menú nuevo') }}
                                            </b>
                                        @endif
                                        <h5 class="mb-0">{{ __('Requerimiento calórico') }}:
                                            <b class="text-primary text-uppercase"> {!! $patient->caloric_requirement !!} {{ __('calorías') }}</b>
                                        </h5>
                                </div>
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-chart-pie"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
