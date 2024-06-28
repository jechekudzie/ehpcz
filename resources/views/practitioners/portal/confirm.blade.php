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
                                        <li>{{ $error }}</li>
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
                                    <p><strong>Email:</strong> {{ $email}}</p>
                                    <p><strong>Profession:</strong> {{ $practitionerProfession->profession->name }}</p>
                                </div>
                            </div>

                            <div class="card mt-4">
                                <div class="card-body">
                                    <h4 class="card-title">Register Portal Credentials</h4>
                                    <form method="post" action="{{ route('portal.register') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="email" name="name" required
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
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
