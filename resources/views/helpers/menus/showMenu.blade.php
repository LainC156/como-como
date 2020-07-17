<!-- delete menu modal -->
<div class="modal fade" id="showMenuModal" tabindex="-1" role="dialog" aria-labelledby="deleteMenuModal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header  alert alert-info">
                <h3 class="modal-title mb-0" id="exampleModalLabel">{{ __('Ver menú') }}</h3>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="text-muted">{{ __('Nombre') }}: <span class="text-primary" id="menu_name_show"></span></p>
                <p class="text-muted">{{ __('Descripción') }}: <span class="text-primary" id="menu_description_show"></span></p>
                <div class="col text-center">
                    <button id="show_menu_btn" class="btn btn-info"><i class="ni ni-folder-17"></i> {{ __('Ver menú') }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
