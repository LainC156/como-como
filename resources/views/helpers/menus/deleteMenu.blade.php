<!-- delete menu modal -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header  alert alert-warning">
                <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Borrar menú') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">{{ __('Nombre') }}: <span class="text-primary" id="menu_name_del"></span></p>
                <p class="text-muted">{{ __('Descripción') }}: <span class="text-primary" id="menu_description_del"></span></p>
                <p class="alert alert-warning">
                    <span id="menu_name_del"></span>
                    {{ __('Esta acción no puede deshacerse, ¿estás seguro?') }}
                </p>
                <div class="col text-center">
                    <button id="delete_menu_btn" class="btn btn-warning"><i class="far fa-trash-alt"></i> {{ __('Aceptar') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
