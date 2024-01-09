<div class="row">
    <div class="toast fade show col-8" role="alert" aria-live="assertive" data-bs-autohide="false"
         aria-atomic="true">
        <div class="toast-header">
            <span class="fw-semibold me-auto">Validation Errors</span>
            <small>Just now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
        <div class="toast-body">
            <ul>
                @foreach(session('identificationErrors')->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

