@if($identificationErrors->any())
    @foreach($identificationErrors->all() as $error)
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong> Errors! </strong> {{ $error }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"
                    aria-label="Close"></button>
        </div>
    @endforeach
@endif
