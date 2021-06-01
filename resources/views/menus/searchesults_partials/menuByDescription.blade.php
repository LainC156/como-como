<div class="card-columns">
    @forelse( $menusByDescription as $mbd)
        <div class="card border-primary bg-secondary">
            <div class="card-body text-center">
                <div class="row m-0 p-0">
                    <div class="col-auto m-0 p-0">
                        <span class="avatar avatar rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('img/avatar/' . $mbd->avatar) }}">
                        </span>
                    </div>
                    <div class="col-auto m-0 p-0">
                        <h5 class="text-primary">
                            {!! $mbd->name !!}
                            {!! $mbd->last_name !!}</h5>
                        <h6 class="text-muted">
                            {{ __('Fecha de creación') }}:
                            {!! date_format($mbd->created_at, 'd-m-Y') !!}.</h6>
                        <h6 class="text-muted">
                            {{ __('Última actualización') }}:
                            {!! date_format($mbd->updated_at, 'd-m-Y') !!}.</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <h5 class="text-muted">{{ __('Edad') }}:
                            <b class="text-primary">{!! $mbd->age !!}
                                {{ __('años') }}</b>
                        </h5>
                    </div>
                    <div class="col-auto">
                        @if ($mbd->genre == 0)
                            <h5 class="text-muted">
                                {{ __('Género') }}:
                                <b class="text-primary">{{ __('Hombre') }}</b>
                            </h5>
                        @else
                            <h5 class="text-muted">
                                {{ __('Género') }}:
                                <b class="text-primary">{{ __('Mujer') }}</b>
                            </h5>
                        @endif
                    </div>
                    <div class="col-auto">
                        <h5 class="text-muted">
                            {{ __('Requerimiento calórico') }}:
                            <b class="text-primary">{!! $mbd->caloric_requirement !!}
                                {{ __('kcal') }}.</b>
                        </h5>
                    </div>
                    @if ($mbd->weight)
                        <div class="col-auto">
                            <h5 class="text-muted">{{ __('Peso') }}:
                                <b class="text-primary">{!! $mbd->weight !!}
                                    {{ __('kg') }}.</b>
                            </h5>
                        </div>
                    @endif
                    @if ($mbd->height)
                        <div class="col-auto">
                            <h5 class="text-muted">{{ __('Estatura') }}:
                                <b class="text-primary">{!! $mbd->height !!}
                                    {{ __('cm') }}.</b>
                            </h5>
                        </div>
                    @endif
                    <div class="col-auto">
                        @if ($mbd->psychical_activity == 0)
                            <h5 class="text-muted">
                                {{ __('Tipo de actividad física') }}:
                                <b class="text-primary">{{ __('Reposo') }}</b>
                            </h5>
                        @elseif( $mbd->psychical_activity == 1 )
                            <h5 class="text-muted">
                                {{ __('Tipo de actividad física') }}:
                                <b class="text-primary">{{ __('Ligera') }}</b>
                            </h5>
                        @elseif( $mbd->psychical_activity == 2 )
                            <h5 class="text-muted">
                                {{ __('Tipo de actividad física') }}:
                                <b class="text-primary">{{ __('Moderada') }}</b>
                            </h5>
                        @elseif( $mbd->psychical_activity == 3 )
                            <h5 class="text-muted">
                                {{ __('Tipo de actividad física') }}:
                                <b class="text-primary">{{ __('Intensa') }}</b>
                            </h5>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <h5 class="text-muted">
                            {{ __('Nombre') }}: <b class="text-primary">{!! $mbd->menu_name !!}</b>
                        </h5>
                    </div>
                    <div class="col-auto">
                        <h5 class="text-muted">
                            {{ __('Descripción') }}:
                            <b class="text-primary">{!! $mbd->description !!}</b>
                        </h5>
                    </div>
                    <div class="col-auto">
                        @if ($mbd->kind_of_menu == 1)
                            <h5 class="text-muted">
                                {{ __('Tipo de menú') }}: <b class="text-primary">{{ __('Menú propio') }}</b>
                            </h5>
                        @elseif( $mbd->kind_of_menu == 2)
                            <h5 class="text-muted">
                                {{ __('Tipo de menú') }}: <b
                                    class="text-primary">{{ __('Menú de otro usuario') }}</b>
                            </h5>
                        @elseif( $mbd->kind_of_menu == 3)
                            <h5 class="text-muted">
                                {{ __('Tipo de menú') }}: <b
                                    class="text-primary">{{ __('Menú editado de otro usuario') }}</b>
                            </h5>
                        @endif
                    </div>
                    <div class="col-auto">
                        @if ($mbd->ideal == 0)
                            <h5 class="text-muted">
                                {{ __('Estado') }}:
                                <b class="text-danger">{{ __('Menú desequilibrado') }}</b>
                            </h5>
                        @elseif($mbd->ideal == 1)
                            <h5 class="text-muted">
                                {{ __('Estado') }}:
                                <b class="text-success">{{ __('Menú ideal') }}</b>
                            </h5>
                        @endif
                    </div>
                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.show', [$mbd->menu_id]) }}"
                        target="_blank"><i class="fas fa-eye">
                        </i> {{ __('Ver menú') }}</a>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="mb-4"></div>
    @empty
        <p class="text-muted">
            {{ __('Sin resultados de búsqueda') }}
        </p>
    @endforelse
</div>
