<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main"
            aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/favicon1.png" class="navbar-brand-img" alt="...">
            {{ __('Bienvenido') }}
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('img/avatar/' . auth()->user()->avatar) }}">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('¡Bienvenido!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit', auth()->user()->id) }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mi perfil') }}</span>
                    </a>
                    <!--
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Con') }}</span>
                    </a>
                    -->
                    <a href="" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Social') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Soporte') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Cerrar sesión') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/favicon1.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <span class="text-primary">{{ __('¿Cómo como?') }}</span>
                        <button type="button" class="navbar-toggler" data-toggle="collapse"
                            data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false"
                            aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form 
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>-->
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Inicio') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button"
                        aria-expanded="true" aria-controls="navbar-examples">
                        <i class="ni ni-circle-08" style="color: #f4645f;"></i>
                        @if ($role_id == 2)
                            <span class="nav-link-text" style="color: #f4645f;">{{ __('Pacientes') }}</span>
                        @elseif( $role_id == 1 )
                            <span class="nav-lin-text" style="color:#f4645f;">{{ __('Usuarios') }}</span>
                        @elseif( $role_id == 3 )
                            <span class="nav-link-text" style="color: #f4645f;">{{ __('Datos') }}</span>
                        @endif
                    </a>
                    <div class="collapse show" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            @if ($role_id == 2)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('user.create') }}">
                                        <i class="fa fa-user-plus" aria-hidden="true">
                                            @if ($role_id == 2)
                                                <span class="nav-link-text">{{ __('Nuevo paciente') }}</span>
                                            @elseif( $role_id == 1 )
                                                <span class="nav-link-text">{{ __('Nuevo usuario') }}</span>
                                            @endif
                                        </i>
                                    </a>
                                </li>
                                <li>
                                    <a class="nav-link" href="{{ route('user.index') }}">
                                        <i class="fa fa-users" aria-hidden="true">
                                            @if ($role_id == 2)
                                                <span class="nav-link-text">{{ __('Pacientes registrados') }}</span>
                                            @elseif( $role_id == 1 )
                                                <span class="nav-link-text">{{ __('Usuarios registrados') }}</span>
                                            @endif
                                        </i>
                                    </a>
                                </li>
                            @endif
                            @if ($role_id == 3)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('menu.create', auth()->user()->id) }}">
                                        <i class="ni ni-folder-17" aria-hidden="true">
                                            <span class="nav-link-text">{{ __('Menú nuevo') }}</span>
                                        </i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('menu.index', auth()->user()->id) }}">
                                        <i class="ni ni-single-copy-04" aria-hidden="true">
                                            <span class="nav-link-text">{{ __('Mis menús') }}</span>
                                        </i>
                                    </a>
                                </li>
                            @endif
                            @if ($role_id == 1)
                                <!-- admin routes -->
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('patients.index') }}">
                                        <i class="ni ni-folder-17" aria-hidden="true">
                                            <span class="nav-link-text">{{ __('Pacientes') }}</span>
                                        </i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('nutritionists.index') }}">
                                        <i class="ni ni-single-copy-04" aria-hidden="true">
                                            <span class="nav-link-text">{{ __('Nutriólogos') }}</span>
                                        </i>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('coupon.index') }}">
                                        <i class="ni ni-single-copy-04" aria-hidden="true">
                                            <span class="nav-link-text">{{ __('Generador de códigos/cupones') }}</span>
                                        </i>
                                    </a>
                                </li>
                            @endif
                            @if($role_id !== 1)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('profile.edit', auth()->user()->id) }}">
                                    <i class="fa fa-user" aria-hidden="true">
                                        <span class="nav-link-text">{{ __('Mi perfil') }}</span>
                                    </i>
                                </a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    @if ($role_id !== 1)
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('menu.search') }}">
                                <i class="ni ni-planet text-blue"></i> {{ __('Buscar menús') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('social.index') }}">
                                <i class="ni ni-like-2 text-blue">
                                </i>
                                {{ __('Social') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('payment.index') }}">
                                <i class="ni ni-credit-card text-red"></i> {{ __('Suscripción') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('coupon.index') }}">
                                <i class="ni ni-credit-card text-red"></i> {{ __('Cupones') }}
                            </a>
                        </li>
                    @endif
                </li>


                <!--
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-pin-3 text-orange"></i> {{ __('Maps') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-key-25 text-info"></i> {{ __('Login') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="ni ni-circle-08 text-pink"></i> {{ __('Register') }}
                    </a>
                </li>
                -->
                <!--
                <li class="nav-item mb-5" style="position: absolute; bottom: 0;">
                    <a class="nav-link" href="https://www.creative-tim.com/product/argon-dashboard-pro-laravel" target="_blank">
                        <i class="ni ni-cloud-download-95"></i> Upgrade to PRO
                    </a>
                </li>
            -->
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading
            <h6 class="navbar-heading text-muted">Documentation</h6> -->
            <!-- Navigation
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
                        <i class="ni ni-palette"></i> Foundation
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/components/alerts.html">
                        <i class="ni ni-ui-04"></i> Components
                    </a>
                </li>
            </ul>
            -->
        </div>
    </div>
</nav>
