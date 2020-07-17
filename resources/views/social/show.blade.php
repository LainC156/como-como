@extends('layouts.app', ['title' => __('User Management')])

@section('content')
    @include('users.partials.header', ['title' => __('Me gusta y comentarios')])

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col-xl-12 order-xl-1">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <strong>{{ __('¿A quién le gusta este menú?, ¿Quiénes lo han comentado?') }}</strong>
                            </div>
                            <div class="col-4 text-right">
                                <!-- <a href="" class="btn btn-sm btn-primary">{{ __('Alguna opción') }}</a> -->
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                            @if(session('error'))
                            <div class="alert alert-danger" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
                                <strong>¡Error!:</strong> {{ session('error') }}
                            </div>
                             @elseif(session('success'))
                             <div class="alert alert-success" role="alert">
                                <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
                                <strong>¡Listo!:</strong> {{ session('success') }}
                            </div>
                            @endif
                    <!-- search input -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="card color-primary" style="display: block">
                                    <div class="card-header" data-toggle="tooltip" data-placement="top" title="{{ __('Da clic sobre esta área para acceder al menú') }}" >
                                        <a href="{{ route('menu.show', ['id' => $menu->id]) }}" target="_blank">
                                        <div class="row">
                                            <div class="col-6">
                                                <h3 class="text-primary text-left">
                                                        <span class="avatar avatar rounded-circle">
                                                            <img alt="Image placeholder" src="{{ asset('img/avatar/'.$patient->avatar) }}">
                                                        </span>{!! $patient->name !!} {{ $patient->last_name }}
                                                </h3>
                                            </div>
                                            <div class="col-6 col-sm-6">
                                                    <p class="h5 text-right text-muted">{{ __('Creado') }}: {!! date('d-M-y\\, h:i:s A', strtotime($menu->created_at)) !!}. </p>
                                                    <p class="h5 text-muted text-right">{{ __('Actualizado') }}: {!! date('d-M-y\\, h:i:s A', strtotime($menu->updated_at)) !!}.</p>
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="card-body" data-toggle="tooltip" data-placement="bottom" title="{{ __('Da clic sobre esta área para acceder al menú') }}" >
                                        <a href="{{ route('menu.show', ['id' => $menu->id]) }}" target="_blank">
                                        <div class="row">
                                            <div class="col-auto">
                                                <p class="description text-muted text-default">{{ __('Nombre del menú') }}: <strong class="text-primary">{!! $menu->name !!}</strong></p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="description text-muted text-default">{{ __('Descripción') }}: <strong class="text-primary">{!! $menu->description !!}</strong></p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="description text-muted text-default">{{ __('Edad') }}: <strong class="text-primary">{!! $patient->age !!} {{ __('años') }}</strong></p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="description text-muted text-default">{{ __('Requerimiento calórico') }}: <strong class="text-primary">{!! $patient->caloric_requirement !!} {{ __('kcal') }}.</strong></p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="description text-muted text-default">{{ __('Peso') }}: <strong class="text-primary">{!! $patient->weight !!} {{ __('kg') }}.</strong></p>
                                            </div>
                                            <div class="col-auto">
                                                <p class="description text-muted text-default">{{ __('Estatura') }}: <strong class="text-primary">{!! $patient->height !!} {{ __('kg') }}.</strong></p>
                                            </div>
                                            <div class="col-auto">
                                                @if( $patient->psychical_activity == 0)
                                                    <p class="description text-muted text-default">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Reposo') }}</strong></p>
                                                @elseif( $patient->psychical_activity == 1)
                                                    <p class="description text-muted text-default">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Ligera') }}</strong></p>
                                                @elseif( $patient->psychical_activity == 2)
                                                    <p class="description text-muted text-default">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Moderada') }}</strong></p>
                                                @elseif( $patient->psychical_activity == 3)
                                                    <p class="description text-muted text-default">{{ __('Tipo de actividad física') }}: <strong class="text-primary">{{ __('Intensa') }}</strong></p>
                                                @endif
                                            </div>
                                        </div>
                                        </a>
                                    </div>
                                    <div class="card-footer">
                                        <div class="row bootstrap snippets">
                                            <div class="col-xl-12 col-md-6 col-md-offset-2 col-sm-12">
                                                <div class="comment-wrapper">
                                                    <div class="panel panel-info">
                                                        <div class="panel-heading">
                                                            <div class="col-xl-12">
                                                                <div class="row">
                                                                    <div class="col-4">
                                                                        <button style="display: none;" id="btn_like" class="btn text-default btn-block text-info" data-toggle="tooltip" data-placement="top" title="{{ __('Da clic para indicar que te gusta este menú') }}">

                                                                        </button>
                                                                        <button style="display: none;" id="btn_no_like" class="btn btn-block text-red" data-toggle="tooltip" data-placement="top" title="{{ __('Has indicado que te gusta este menú') }}">
                                                                            <i class="fas fa-heart "></i>
                                                                        </button>
                                                                    </div>
                                                                    <div class="col-8">
                                                                        <div class="btn btn-block text-primary" id="comment_button">
                                                                                <i class="far fa-comments"></i>{!! $comment_count !!} {{ __('Comentarios') }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="panel-body col-12">
                                                            <div class="row">
                                                                <div class="col-auto col-md-8 col-lg-8">
                                                                    <textarea class="form-control" id="input_comment" name="comment_input" placeholder="{{ __('¿Qué te pareció este menú?') }}" rows="2"></textarea>
                                                                </div>
                                                                <div class="col-auto col-md-4 col-lg-4">
                                                                    <br>
                                                                    <button id="btn_post_comment" class="btn btn-primary text-right">{{ __('Publicar comentario') }}</button>
                                                                </div>
                                                            </div>
                                                            <div class="clearfix"></div>
                                                            <hr>
                                                            <ul id="social_comments" class="media-list">
                                                            @forelse ($activities as $activity)
                                                                    <li class="media">
                                                                        <a href="#" class="pull-left">
                                                                            <span class="avatar avatar rounded-circle">
                                                                                <img src="{{ asset('img/avatar/'.$activity->avatar) }}" alt="" class="img-circle">
                                                                            <span class="avatar avatar rounded-circle">
                                                                        </a>
                                                                        <div class="media-body">
                                                                            <div class="col-6">
                                                                                <strong class="text-success">@ {!! $activity->name !!}</strong>
                                                                                <span class="text-muted pull-right">
                                                                                    <small class="text-muted"> {!! date('d-M-y\\, h:i:s A', strtotime($activity->updated_at)) !!}</small>
                                                                                </span>
                                                                                <p>{!! $activity->comment !!}</p>
                                                                            </div>
                                                                        </div>
                                                                    </li>

                                                            @empty
                                                                <h5 id="no_comments_header" class="description">{{ __('Sin comentarios disponibles') }}</h5>
                                                            @endforelse
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="mb-4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('layouts.footers.auth')
    </div>
@endsection

@section('javascript')
    <script>
        $( document ).ready( function() {
            /* tooltip settings */
            $('[data-toggle="tooltip"]').tooltip();
            let msg = '';
            let patient_id = {{ $patient->id }};
            let menu_id = {{ $menu->id }};
            let like = {{ $like_validation }};
            let like_count = {{ $like_count }};
            console.log('like_count:  ' + like_count);
            console.log('like: ' + like );
            /* checking for like button to display */
            if ( like == -1 || like == 0) {
                msg = '<i class="fas fa-heart text-info"></i>' + " " + like_count + " " + "{{ __('Me gusta') }}";
                $("#btn_like").html(msg);
                $("#btn_like").show();
            }
            if( like == 1 ) {
                msg = '<i class="fas fa-heart text-red"></i>' + " " + like_count + " " + "{{ __('Ya no me gusta') }}";
                $("#btn_no_like").html(msg);
                $("#btn_no_like").show();
            }
            console.log(`patient_id: ${patient_id}, menu_id: ${menu_id}`);
            console.log('like del usuario: ' + like);
            /* tooltip */
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
            /* ajax setup */
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            /* click on btn_like_default */
            $("#btn_like").click( function() {
                console.log('btn_like_default clic');
                let data= {
                    patient_id: patient_id,
                    menu_id: menu_id,
                    like: like == -1 ? 1 : like
                };
                console.log('data a enviar: ' + JSON.stringify(data));
                $.ajax({
                    data: data,
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('social.like') }}",
                    success: function(data) {
                        console.log('data: ' + JSON.stringify(data));
                        msg = data.msg;
                        /* update like value and like styles */
                        like = 1;
                        like_count += 1;
                        msg = '<i class="fas fa-heart text-red"></i>' + " " + like_count + " " + "{{ __('Ya no me gusta') }}";
                        $("#btn_no_like").html(msg);
                        $("#btn_no_like").show();
                        $("#btn_like").hide();

                    },
                    error: function(data) {
                        console.log('data: ' + JSON.stringify(data));
                    }
                });
            });
            /* btn_no_like action */
            $("#btn_no_like").click( function() {
                console.log('btn_no_like');
                let data= {
                    patient_id: patient_id,
                    menu_id: menu_id,
                    like: like
                };
                console.log('data a enviar: ' + JSON.stringify(data));
                $.ajax({
                    data: data,
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('social.like') }}",
                    success: function(data) {
                        console.log('success: ' + JSON.stringify(data));
                        like= 0;
                        like_count -= 1;
                        $("#btn_no_like").hide();
                        msg = '<i class="fas fa-heart text-info"></i>' + " " + like_count + " " + "{{ __('Me gusta') }}";
                        $("#btn_like").html(msg);
                        $("#btn_like").show();
                    },
                    error: function(data) {
                        console.log('error: ' + JSON.stringify(data));
                    }
                });
            });
            $("#btn_post_comment").click( function() {
                console.log('boton publicar');
                msg = $("#input_comment").val();
                /* validations */
                if( msg == '' && msg.length == 0 ) {
                    msg = "{{ __('Debes ingresar un mensaje para poder publicarlo') }}";
                    console.log('mensaje: ' + msg);
                    return;
                }
                let data= {
                    owner_id: patient_id,
                    menu_id: menu_id,
                    comment: msg
                };
                $.ajax({
                    data: data,
                    dataType: 'json',
                    type: 'POST',
                    url: "{{ route('social.comment') }}",
                    success: function(data) {
                        console.log('success: ' + JSON.stringify(data));
                        let user_name = data.user_name;
                        let last_name = data.last_name;
                        let av = data.avatar;
                        console.log('avatar:', av);
                        let date = data.date;
                        let comment = data.comment;
                        $("#input_comment").val('');
                        if( data.kind_of_comment == 'new' || data.kind_of_comment == 'updated' ) {
                            $("#social_comments")
                                .append(' <li class="media"> ' +
                                        '<a href="#" class="pull-left">' +
                                            ' <span class="avatar avatar rounded-circle"> ' +
                                                ' <img id="avatar_img" src="{{ asset('img/avatar') }}/'+ av +'" alt="" class="img-circle"> ' +
                                            ' <span class="avatar avatar rounded-circle">'  +
                                        '</a>' +
                                        ' <div class="media-body">'  +
                                            '<div class="col-6">' +
                                                '<strong class="text-success">@ '+ user_name + ' ' + last_name +'</strong>' +
                                                '<span class="text-muted pull-right">' +
                                                    '<small class="text-muted">{{ __('Fecha y hora') }}: {!! date('d-M-y\\, h:i:s A', strtotime('+ date +')) !!}</small>' +
                                                '</span>' +
                                                '<p>' + comment + '</p>' +
                                            '</div>' +
                                        '</div>' +
                                    '</li>');
                            /* hide no_comments_header */
                            $("#no_comments_header").hide();
                            /* set src image */
                        }

                    },
                    error: function(data) {
                        console.log('error: ' + JSON.stringify(data));
                    }
                });
            });
        });
    </script>

@endsection
