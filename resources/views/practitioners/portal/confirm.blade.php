@extends('layouts.portal')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    @if(session()->has('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Error!</strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                        @if(session()->has('errors'))
                            @if($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Errors:</strong>
                                    <ul>
                                        @foreach($errors->all() as $error)
                                            <li>{!! $error !!}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                        @endif


                        <!-- Success Message -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <h1>Confirm Practitioner Details</h1>
                    <div class="row g-2">
                        <div class="col-lg-8 col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="card-title">Practitioner Details</h4>
                                    <p><strong>First Name:</strong> {{ $practitioner->first_name }}</p>
                                    <p><strong>Last Name:</strong> {{ $practitioner->last_name }}</p>
                                    <p><strong>ID Number:</strong> {{ $identification_number }}</p>
                                    <p><strong>Registration Number:</strong> {{ $registration_number }}</p>
                                    <p><strong>Email:</strong> {{ $email }}</p>
                                    <p><strong>Profession:</strong> {{ $practitionerProfession->profession->name }}</p>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="confirmCheck" onchange="toggleRegisterSection()">
                                        <label class="form-check-label" for="confirmCheck">
                                            I hereby affirm that the information provided above is accurate and pertains to me personally.
                                        </label>
                                    </div>
                                    <div class="form-check mt-2">
                                        <input class="form-check-input" type="checkbox" id="notMyInfoCheck" onchange="toggleBackButton()">
                                        <label class="form-check-label" for="notMyInfoCheck">
                                            The information above is not mine.
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="card mt-4" id="registerSection" style="display: none;">
                                <div class="card-body">
                                    <h4 class="card-title">Register Portal Credentials</h4>
                                    <form method="post" action="{{ route('portal.register') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required
                                                   value="{{ $practitioner->first_name.' '.$practitioner->last_name }}" placeholder="Enter your name">
                                        </div>
                                        <input type="hidden" name="practitioner_id" value="{{ $practitioner->id }}">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" class="form-control" id="email" name="email" required
                                                   value="{{ $email }}" placeholder="Enter your Email">
                                        </div>

                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required
                                                   placeholder="Enter your Password">
                                        </div>

                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required
                                                   placeholder="Confirm your Password">
                                        </div>

                                        <button type="submit" class="btn btn-primary">Register</button>
                                        <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
                                    </form>
                                </div>
                            </div>

                            <div class="mt-4" id="backButtonSection" style="display: none;">
                                <a href="{{ url()->previous() }}" class="btn btn-secondary">Go Back</a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRegisterSection() {
            const confirmCheck = document.getElementById('confirmCheck');
            const registerSection = document.getElementById('registerSection');
            if (confirmCheck.checked) {
                registerSection.style.display = 'block';
                document.getElementById('notMyInfoCheck').checked = false;
                document.getElementById('backButtonSection').style.display = 'none';
            } else {
                registerSection.style.display = 'none';
            }
        }

        function toggleBackButton() {
            const notMyInfoCheck = document.getElementById('notMyInfoCheck');
            const backButtonSection = document.getElementById('backButtonSection');
            if (notMyInfoCheck.checked) {
                backButtonSection.style.display = 'block';
                document.getElementById('confirmCheck').checked = false;
                document.getElementById('registerSection').style.display = 'none';
            } else {
                backButtonSection.style.display = 'none';
            }
        }
    </script>
@stop
