<div class="card-columns">
    @forelse( $patients as $p)
        <div class="card border-primary bg-secondary">
            <div class="card-body text-center">
                <div class="row m-0 p-0">
                    <div class="col-auto m-0 p-0">
                        <span class="avatar avatar rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('img/avatar/' . $p->avatar) }}">
                        </span>
                    </div>
                    <div class="col-auto m-0 p-0">
                        <h5 class="text-primary">
                            {!! $p->fullname !!}
                        </h5>
                        <h6 class="text-muted">
                            {{ __('Se unió a') }} <b>{{ __('¿Cómo como?') }}</b>:
                            {!! date_format($p->created_at, 'd-m-Y') !!}</h6>
                    </div>
                </div>
                <div class="row">
                    <div class="col-auto">
                        <h5 class="text-muted">{{ __('Edad') }}:
                            <b class="text-primary">{!! $p->age !!}
                                {{ __('años') }}</b>
                        </h5>
                    </div>
                    <div class="col-auto">
                        @if ($p->genre == 0)
                            <h5 class="text-muted">
                                {{ __('Género') }}: <b class="text-primary">{{ __('Hombre') }}</b>
                            </h5>
                        @else
                            <h5 class="text-muted">
                                {{ __('Género') }}: <b class="text-primary">{{ __('Mujer') }}</b>
                            </h5>
                        @endif
                    </div>
                    <div class="col-auto">
                        <h5 class="text-muted">
                            {{ __('Requerimiento calórico') }}:
                            <b class="text-primary">{!! $p->caloric_requirement !!}
                                {{ __('kcal') }}.</b>
                        </h5>
                    </div>
                    <div class="col-auto">
                        <h5 class="text-muted">{{ __('Peso') }}:
                            <b class="text-primary">{!! $p->weight !!}
                                {{ __('kg') }}.</b>
                        </h5>
                    </div>
                    <div class="col-auto">
                        <h5 class="text-muted">
                            {{ __('Estatura') }}: <b class="text-primary">{!! $p->height !!}
                                {{ __('cm') }}.</b></h5>
                    </div>
                    <div class="col-auto">
                        @if ($p->psychical_activity == 0)
                            <h5 class="text-muted">
                                {{ __('Actividad física') }}:
                                <b class="text-primary">{{ __('Reposo') }}</b>
                            </h5>
                        @elseif( $p->psychical_activity == 1 )
                            <h5 class="text-muted">
                                {{ __('Actividad física') }}:
                                <b class="text-primary">{{ __('Ligera') }}</b>
                            </h5>
                        @elseif( $p->psychical_activity == 2 )
                            <h5 class="text-muted">
                                {{ __('Actividad física') }}:
                                <b class="text-primary">{{ __('Moderada') }}</b>
                            </h5>
                        @elseif( $p->psychical_activity == 3 )
                            <h5 class="text-muted">
                                {{ __('Actividad física') }}:
                                <b class="text-primary">{{ __('Intensa') }}</b>
                            </h5>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.index', [$p->user_id]) }}"
                        target="_blank"><i class="fas fa-eye fa-2x">
                            {{ __('Ver menús') }}</i></a>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="mb-4"></div>
    @empty
        <p class="text-muted">
            {{ __('Sin resultados de búsqueda') }}</p>
    @endforelse
</div>
