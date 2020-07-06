<!-- delete menu modal -->
<div class="modal fade" id="deleteMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header  alert alert-warning">
                <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Borrar menú') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="alert alert-warning">
                    {{ __('Esta acción no puede deshacerse, ¿estás seguro?') }}
                </p>
                <div class="col text-center">
                    <input type="button" id="btn_delete_menu" class="btn btn-warning" value="{{ __('Aceptar') }}" />
                </div>
            </div>
        </div>
    </div>
</div>
