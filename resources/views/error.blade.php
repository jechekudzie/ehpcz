@if(session()->has('errors'))
    @if($errors->any())

        @foreach($errors->all() as $error)
            <!-- Success Alert -->
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong> Errors! </strong> {{ $error }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"
                        aria-label="Close"></button>
            </div>
        @endforeach

    @endif
@endif
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Message!</strong> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"
                aria-label="Close"></button>
    </div>
@endif
