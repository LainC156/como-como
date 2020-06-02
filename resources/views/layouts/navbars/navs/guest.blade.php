<nav class="navbar navbar-top navbar-horizontal navbar-expand-md navbar-dark">
    <div class="container px-4">
        <a class="navbar-brand" href="{{ route('index') }}">
            <img src="argon/img/brand/favicon1.png" />
            {{ __('¿Cómo como?') }}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbar-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="argon/img/brand/favicon1.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbar-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Navbar items -->
            <ul class="navbar-nav ml-auto">
                <!-- language -->
                <li class="nav-item dropdown">
                    <a class="nav-link pr-0" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <div class="media align-items-bottom">
                            @if(App::getLocale() == 'en')
                            <img src="img/flags/us.png" alt="" >
                            @elseif(App::getLocale() == 'es')
                            <img src="img/flags/mx.png" alt="" >
                            @elseif(App::getLocale() == 'fr')
                            <img src="img/flags/fr.png" alt="" >
                            @endif
                        </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-left">
                        <div class=" dropdown-header noti-title">
                            <h6 class="text-overflow m-0">{{ __('Escoge tu idioma') }}</h6>
                        </div>
                        <a href="{{ route('set_language', ['es']) }}" class="dropdown-item">
                            <img src="img/flags/mx.png" alt="">
                            <span>{{ __('Español') }}</span>
                        </a>
                        <a href="{{ route('set_language', ['en']) }}" class="dropdown-item">
                            <img src="img/flags/us.png" alt="">
                            <span>{{ __('English') }}</span>
                        </a>
                        <a href="{{ route('set_language', ['fr']) }}" class="dropdown-item">
                            <img src="img/flags/fr.png" alt="">
                            <span>{{ __('Francais') }}</span>
                        </a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('register') }}">
                        <i class="ni ni-circle-08"></i>
                        <span class="nav-link-inner--text">{{ __('Registro') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('login') }}">
                        <i class="ni ni-key-25"></i>
                        <span class="nav-link-inner--text">{{ __('Iniciar sesión') }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-icon" href="{{ route('about') }}">
                        <i class="ni ni-app"></i>
                        <span class="nav-link-inner--text">{{ __('Acerca de') }}</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
