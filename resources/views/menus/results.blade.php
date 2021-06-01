@extends('layouts.app')
@section('title')
    {{ __('Resultados') }} | {{ __('¿Cómo como?') }}
@endsection
@section('content')
    @include('layouts.headers.results_card')
    <style>
        .table tr {
            height: 0% !important;
            width: 0% !important;
        }

        .table th {
            width: 10px;
            padding-right: 0px !important;
        }

        .card .table td {
            padding-right: 0% !important;
        }

        .tooltip {
            display: inline-block;
            width: 250px;
            padding: 15px;
            font-size: 12px;
            overflow: auto !important;

        }

    </style>
    <div class="container-fluid mt--7">
        <input type="hidden" id="menu_id" value="{!! $menu_data->id !!}">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="text-center">
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="col-xl-12">
                            <div class="card card-stats mb-4 mb-xl-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            @include('menus.results_partials.macronutrients')
                                            @include('menus.results_partials.others')
                                        </div><!-- end class col-6 macronutrients -->
                                        <div class="col-6">
                                            @include('menus.results_partials.micronutrients')
                                        </div><!-- end class col -->
                                    </div><!-- end class row -->
                                </div>
                            </div>
                        </div>
                        <div class="mb-4"></div>
                    </div>
                </div><!-- end card -->
            </div>
        </div>
        <!-- Modal to Display recomendations -->
        <div class="modal fade" id="recomendationsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-bg modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal_title"></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" id="modal_body">
                        <textarea class="form-control" name="" id="modal_text_area" cols="60" rows="15"></textarea>
                    </div>
                    <div class="modal-footer">
                        <div class="row">
                            <div class="col-12">
                                <div id="text_copied_alert" class="alert alert-success" role="alert" style="display:none;">
                                    {{ __('Texto copiado correctamente') }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ __('Cerrar') }}</button>
                            <button id="copy_to_clipboard" type="button"
                                class="btn btn-primary">{{ __('Copiar al portapapeles') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection
@section('javascript')
    <script src="{{ asset('js/menus/results.js') }}"></script>
    <script src="{{ asset('js/alerts.js') }}"></script>
@endsection
