<!-- delete menu modal -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModal"
    aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header  alert alert-warning">
                <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Limpiar menú') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @isset($menu)
                    @if ($menu->name && $menu->description)
                        <p class="text-muted">{{ __('Nombre') }}: <b class="text-primary" id="menu_name_del">{!! $menu->name !!}</b>
                        </p>
                        <p class="text-muted">{{ __('Descripción') }}: <b class="text-primary"
                                id="menu_description_del">{!! $menu->description !!}</b></p>
                    @else
                    <b class="text-center mb-1">{{ __('Menú nuevo sin guardar') }}</b>
                    @endif
                @endisset
                <p class="alert alert-warning" style="color: black">
                    <span id="menu_name_del"></span>
                    {{ __('Esta acción borrará todos los elementos ya agregados a tu menú') }}
                </p>
                <div class="col text-center">
                    <button id="delete_menu_btn" class="btn btn-warning"><i class="far fa-trash-alt"></i>
                        {{ __('Aceptar') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
