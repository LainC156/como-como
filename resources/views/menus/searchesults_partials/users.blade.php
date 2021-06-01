<div class="card-columns">
    @forelse( $usernames as $u)
        <div class="card border-primary bg-secondary">
            <div class="card-body text-center bg-dark">
                <div class="row m-0 p-0">
                    <div class="col-auto m-0 p-0">
                        <span class="avatar avatar rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('img/avatar/' . $u->avatar) }}">
                        </span>
                    </div>
                    <div class="col-auto m-0 p-0">
                        <h5 class="text-primary">
                            {!! $u->fullname !!}
                        </h5>
                        <h6 class="text-muted">
                            {{ __('Se unió a') }} <b>{{ __('¿Cómo como?') }}</b>:
                            {!! date_format($u->created_at, 'd-m-Y') !!}</h6>
                    </div>
                </div>
                <div class="row">
                    @if ($u->age)
                        <div class="col-auto">
                            <h5 class="text-muted">{{ __('Edad') }}:
                                <b class="text-primary">{!! $u->age !!}
                                    {{ __('años') }}</b>
                            </h5>
                        </div>
                    @endif
                    <div class="col-auto">
                        @if ($u->genre == 0)
                            <h5 class="text-muted">
                                {{ __('Género') }}:
                                <strong class="text-primary">{{ __('Hombre') }}</strong>
                            </h5>
                        @else
                            <h5 class="text-muted">
                                {{ __('Género') }}:
                                <strong class="text-primary">{{ __('Mujer') }}</strong>
                            </h5>
                        @endif
                    </div>
                    @if ($u->caloric_requirement)
                        <div class="col-auto">
                            <h5 class="text-muted">
                                {{ __('Requerimiento calórico') }}:
                                <strong class="text-primary">{!! $u->caloric_requirement !!}
                                    {{ __('kcal') }}.</strong>
                            </h5>
                        </div>
                    @endif
                    @if ($u->weight)
                        <div class="col-auto">
                            <h5 class="text-muted">{{ __('Peso') }}:
                                <strong class="text-primary">{!! $u->weight !!}
                                    {{ __('kg') }}.</strong>
                            </h5>
                        </div>
                    @endif
                    @if ($u->height)
                        <div class="col-auto">
                            <h5 class="text-muted">{{ __('Estatura') }}:
                                <strong class="text-primary">{!! $u->height !!}
                                    {{ __('cm') }}.</strong>
                            </h5>
                        </div>
                    @endif
                    <div class="col-auto">
                        @if ($u->psychical_activity == 0)
                            <h5 class="text-muted">
                                {{ __('Actividad física') }}:
                                <strong class="text-primary">{{ __('Reposo') }}</strong>
                            </h5>
                        @elseif( $u->psychical_activity == 1 )
                            <h5 class="text-muted">
                                {{ __('Actividad física') }}:
                                <strong class="text-primary">{{ __('Ligera') }}</strong>
                            </h5>
                        @elseif( $u->psychical_activity == 2 )
                            <h5 class="text-muted">
                                {{ __('Tipo de actividad física') }}:
                                <strong class="text-primary">{{ __('Moderada') }}</strong>
                            </h5>
                        @elseif( $u->psychical_activity == 3 )
                            <h5 class="text-muted">
                                {{ __('Tipo de actividad física') }}:
                                <strong class="text-primary">{{ __('Intensa') }}</strong>
                            </h5>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <a class="btn btn-primary btn-sm btn-block" href="{{ route('menu.index', [$u->user_id]) }}"
                        target="_blank"><i class="fas fa-eye">
                        </i> {{ __('Ver menús') }}</a>
                </div>
            </div>
        </div> <!-- end card -->
        <div class="mb-4"></div>
    @empty
        <p class="text-muted">{{ __('Sin resultados de búsqueda') }}</p>
    @endforelse
</div>
