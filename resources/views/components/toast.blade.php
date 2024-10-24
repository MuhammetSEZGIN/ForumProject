<div id="element" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <img src="{{asset("images/logo.png")}}" class="rounded mr-2" alt="logo">
        <strong class="mr-auto">Dikbıyık Forum</strong>
        <small class="text-muted"></small>
        <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
       {{$message}}
    </div>
</div>
