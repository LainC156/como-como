@if(session('error'))
<div id="session_error_alert" class="alert alert-danger" role="alert">
    <span class="alert-inner--icon"><i class="ni ni-fat-remove"></i></span>
    <strong>¡{{ __('Error') }}!:</strong> {{ session('error') }}
</div>
    @elseif(session('success'))
    <div id="session_success_alert" class="alert alert-success" role="alert">
    <span class="alert-inner--icon"><i class="ni ni-check-bold"></i></span>
    <strong>¡{{ __('Listo') }}!:</strong> {{ session('success') }}
</div>
@endif
