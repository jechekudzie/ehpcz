@extends('layouts.elections')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">EHPCZ - Elections</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">EHPCZ - Elections</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <h3 class="mb-4">Update Practitioner Details</h3>
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('practitioner.update.submit', $practitioner->slug) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control"
                           value="{{ old('first_name', $practitioner->first_name) }}" required readonly>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control"
                           value="{{ old('last_name', $practitioner->last_name) }}" required readonly>
                </div>
                <div class="mb-3">
                    <label for="id_number" class="form-label">ID Number</label>
                    <input type="text" name="id_number" class="form-control"
                           value="{{ old('id_number', $practitioner->practitionerIdentifications->first()->identification_number ?? '') }}"
                           required>
                </div>
                <div class="mb-3">
                    <label for="mobile_number" class="form-label">Mobile Number</label>
                    <input type="text" name="mobile_number" class="form-control"
                           value="{{ old('mobile_number', $practitioner->contacts->firstWhere('contact_type_id', 1)?->contact ?? '') }}"
                           required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>

        </div>
    </div>
@endsection
