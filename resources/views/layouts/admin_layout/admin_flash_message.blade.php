@if(Session::has('flash_message_error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session('flash_message_error') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
@if(Session::has('flash_message_success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>{{ session('flash_message_success') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif