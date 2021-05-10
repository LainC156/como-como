<div class="header bg-gradient-primary pb-8 pt-5 pt-md-8">
    <div class="container-fluid">
        <div class="header-body">
            <!-- Card stats -->
            <div class="row">
                @if($user->subscription_status == 1 || $user->trial_status == 1)
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-danger text-white rounded-circle shadow">
                                        <i class="fas fa-money-check-alt"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Estado de la cuenta') }}:</h5>
                                    @if( $user->trial_status == 1)
                                    <span class="h2 font-weight-bold mb-0">{{ __('Versión de prueba') }}</span>
                                    @elseif( $user->subscription_status == 1)
                                    <span class="h2 font-weight-bold mb-0">{{ __('Suscripción mensual') }}</span>
                                    @endif
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fa fa-arrow-up"></i> {{ __('Cuenta activa hasta') }}:</span>
                                <span class="text-nowrap">{!! date(' j - m - Y', strtotime($user->expiration_date)) !!}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
                @if($role_id == 3)
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-warning text-white rounded-circle shadow">
                                        <i class="fas fa-user-alt-slash"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Estado del perfil') }}:</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ __('Sin completar') }}</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-danger mr-2"><i class="fas fa-arrow-down"></i> {{ __('Es necesario completar tu perfil para poder empezar a crear menús') }}</span>
                                <a href="{{ route('profile.edit', auth()->user()->id) }}"><span class="text-nowrap">{{ __('Editar perfil') }}</span></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-yellow text-white rounded-circle shadow">
                                        <i class="ni ni-books"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Menús creados') }}</h5>
                                    <span class="h2 font-weight-bold mb-0">{!! $menus !!}</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-warning mr-2"><i class="fas fa-arrow-down"></i> {{ __('¿Necesitas un nuevo menú?') }}</span>
                                <a href=""><span class="text-nowrap">{{ __('Crear menú') }}</span></a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card card-stats mb-4 mb-xl-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-auto">
                                    <div class="icon icon-shape bg-info text-white rounded-circle shadow">
                                        <i class="ni ni-favourite-28"></i>
                                    </div>
                                </div>
                                <div class="col">
                                    <h5 class="card-title text-uppercase text-muted mb-0">{{ __('Social') }}</h5>
                                    <span class="h2 font-weight-bold mb-0">{{ __('¿A quién le gusta tu menú?') }}</span>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2"><i class="fas fa-arrow-up"></i> {{ __('¿Qué dicen los usuarios de tus menús?') }}</span>
                                <span class="text-nowrap">{{ __('Social') }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
