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

            <h2>Verify OTP for Your Details Update</h2>

        <!-- Success or error messages -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <form action="{{ route('practitioner.verify.otp', $practitioner->slug) }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="otp" class="form-label">Enter OTP</label>
                <input type="text" id="otp" name="otp" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="mobile_number" class="form-label">Mobile Number</label>
                <input type="text" id="mobile_number" name="mobile_number" class="form-control" value="{{ old('mobile_number', $practitioner->contacts->where('contact_type_id', 1)->first()->contact ?? '') }}" readonly>
            </div>

            <button type="submit" class="btn btn-primary">Verify OTP</button>
        </form>
    </div>
</div>
@endsection
