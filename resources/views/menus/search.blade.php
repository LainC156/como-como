@extends('layouts.app')
@section('title')
    {{ __('Búsqueda de menús') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('users.partials.header', ['title' => __('Búsqueda en menús')])
    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <form method="GET" class="form text-center" action="{{ route('menu.searchresults') }}"
                            autocomplete="off">
                            @csrf
                            <div id="search_form_group" class="form-group">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span id="search_success_span" class="input-group-text"><i
                                                class="fas fa-search"></i></span>
                                    </div>
                                    <input type="text" id="search_success_input" data-toggle="tooltip" data-placement="top"
                                        title="{{ __('Simplemente presiona Enter para ver todo') }}" name="search_menu"
                                        class="form-control" placeholder="{{ __('Buscar en menús') }}" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card bg-secondary shadow">
                    <div class="card-body">
                        <div class="nav-wrapper">
                            <ul class="nav nav-pills nav-fill flex-column flex-md-row" id="tabs-icons-text" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0 active" id="tabs-icons-text-1-tab" data-toggle="tab"
                                        href="#tabs-icons-text-1" role="tab" aria-controls="tabs-icons-text-1"
                                        aria-selected="true"><i class="fa fa-users mr-2"></i>{{ __('Usuarios') }}</a>
                                </li>
                                @if ($role_id == 2)
                                    <li class="nav-item">
                                        <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-2-tab" data-toggle="tab"
                                            href="#tabs-icons-text-2" role="tab" aria-controls="tabs-icons-text-2"
                                            aria-selected="true"><i class="fa fa-users mr-2"></i>{{ __('Pacientes') }}</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-3-tab" data-toggle="tab"
                                        href="#tabs-icons-text-3" role="tab" aria-controls="tabs-icons-text-3"
                                        aria-selected="false"><i
                                            class="fas fa-utensils mr-2"></i>{{ __('Alimentos en menú') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-4-tab" data-toggle="tab"
                                        href="#tabs-icons-text-4" role="tab" aria-controls="tabs-icons-text-4"
                                        aria-selected="false"><i
                                            class="ni ni-calendar-grid-58 mr-2"></i>{{ __('Menús por nombre') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link mb-sm-3 mb-md-0" id="tabs-icons-text-5-tab" data-toggle="tab"
                                        href="#tabs-icons-text-5" role="tab" aria-controls="tabs-icons-text-5"
                                        aria-selected="false"><i
                                            class="ni ni-calendar-grid-58 mr-2"></i>{{ __('Menús por descripción') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card shadow">
                            @if (isset($usernames) || isset($patients) || isset($foods) || isset($menuByName) || isset($menuByDescription))
                                <div class="card-body">
                                    <div class="tab-content" id="myTabContent">
                                        <div class="tab-pane fade show active" id="tabs-icons-text-1" role="tabpanel"
                                            aria-labelledby="tabs-icons-text-1-tab">
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="nav nav-pills nav-pills-circle" role="tablist">
                                                        {{ $usernames->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @include('menus.searchesults_partials.users')
                                            </div>
                                        </div>
                                        @if ($role_id == 2)
                                            <div class="tab-pane fade" id="tabs-icons-text-2" role="tabpanel"
                                                aria-labelledby="tabs-icons-text-2-tab">
                                                <!-- show all patients(of nutriologist) in cards -->
                                                <div class="row align-items-center">
                                                    <div class="col-auto">
                                                        <div class="nav nav-pills nav-pills-circle" role="tablist">
                                                            {{ $patients->links() }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    @include('menus.searchesults_partials.patients')
                                                </div>
                                            </div>
                                        @endif
                                        <div class="tab-pane fade" id="tabs-icons-text-3" role="tabpanel"
                                            aria-labelledby="tabs-icons-text-3-tab">
                                            <!-- show all results in cards -->
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="nav nav-pills nav-pills-circle" role="tablist">
                                                        {{ $foods->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @include('menus.searchesults_partials.foods')
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-4" role="tabpanel"
                                            aria-labelledby="tabs-icons-text-4-tab">
                                            <!-- show all results by name in cards -->
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="nav nav-pills nav-pills-circle" role="tablist">
                                                        {{ $menusByName->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @include('menus.searchesults_partials.menuByName')
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="tabs-icons-text-5" role="tabpanel"
                                            aria-labelledby="tabs-icons-text-5-tab">
                                            <!-- show all results by description in cards -->
                                            <div class="row align-items-center">
                                                <div class="col-auto">
                                                    <div class="nav nav-pills nav-pills-circle" role="tablist">
                                                        {{ $menusByDescription->links() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                @include('menus.searchesults_partials.menuByDescription')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
