<!-- Top navbar -->
<nav class="navbar navbar-top navbar-expand-md navbar-dark" id="navbar-main">
    <div class="container-fluid">
        <!-- Brand -->
        <a class="h4 mb-0 text-white text-uppercase d-none d-lg-inline-block" href="{{ route('home') }}">{{ __('¿Cómo como?') }}</a>
        <!-- Form -->
        <!--<form class="navbar-search navbar-search-dark form-inline mr-3 d-none d-md-flex ml-lg-auto">
            <div class="form-group mb-0">
                <div class="input-group input-group-alternative">
                    <div class="input-group-prepend">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                    </div>
                    <input class="form-control" placeholder="Search" type="text">
                </div>
            </div>
        </form>-->
        <!-- language -->
        <li class="nav-item dropdown">
            <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="media align-items-bottom">
                    @if(App::getLocale() == 'en')
                    <img src="{{ asset('/img/flags/us.png') }}" alt="" >
                    @elseif(App::getLocale() == 'es')
                    <img src="{{ asset('/img/flags/mx.png') }}" alt="" >
                    @elseif(App::getLocale() == 'fr')
                    <img src="{{ asset('/img/flags/fr.png')}}" alt="" >
                    @endif
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left">
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">{{ __('Escoge tu idioma') }}</h6>
                </div>
                <a href="{{ route('set_language', ['es']) }}" class="dropdown-item">
                    <img src="{{ asset('img/flags/mx.png') }}" alt="">
                    <span>{{ __('Español') }}</span>
                </a>
                <a href="{{ route('set_language', ['en']) }}" class="dropdown-item">
                    <img src="{{ asset('img/flags/us.png') }}" alt="">
                    <span>{{ __('English') }}</span>
                </a>
                <a href="{{ route('set_language', ['fr']) }}" class="dropdown-item">
                    <img src="{{ asset('img/flags/fr.png') }}" alt="">
                    <span>{{ __('Francais') }}</span>
                </a>
            </div>
        </li>
        <!-- User -->
        <ul class="navbar-nav align-items-center d-none d-md-flex">
            <li class="nav-item dropdown">
                <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                            <img alt="Image placeholder" src="{{ asset('img/avatar/'.auth()->user()->avatar) }}">
                        </span>
                        <div class="media-body ml-2 d-none d-lg-block">
                            <span class="mb-0 text-sm  font-weight-bold">{{ auth()->user()->name }} {{ auth()->user()->last_name }}</span>
                            <div class="media-body ml-2 d-none d-lg-block">
                                @if($role_id == 2)
                                    <span class="mb-0 text-sm font-weight-bold">{{ __('Nutriólogo') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit',auth()->user()->id) }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('Mi perfil') }}</span>
                    </a>
                    <!--<a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>-->
                    <a href="{{ route('social.index') }}" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Social') }}</span>
                    </a>
                    <!--<a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a> -->
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Cerrar sesión') }}</span>
                    </a>
                </div>
            </li>
        </ul>
    </div>
</nav>
