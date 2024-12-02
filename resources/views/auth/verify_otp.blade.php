@extends('layouts.elections')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Voting Log In</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">EHPCZ - Elections</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notifications -->
            @if(session()->has('errors'))
                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errors!</strong> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                @endif
            @endif
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Message!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->has('otp'))
                <div class="alert alert-danger">
                    {{ $errors->first('otp') }}
                </div>
            @endif


            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Verify OTP sent to {{$mobile_number}}</div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('otp.verify.post') }}">

                                @csrf
                                <input type="hidden" name="practitioner_id" value="{{ $practitioner_id }}">
                                <input type="hidden" name="election_id" value="{{ $election_id }}">
                                <input type="hidden" name="mobile_number" value="{{ $mobile_number }}">
                                <input type="hidden" name="id_number" value="{{ $id_number }}">

                                <div class="form-group">
                                    <label for="otp">Enter OTP</label>
                                    <input type="text" class="form-control" id="otp" name="otp" required>
                                    @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div class="mt-3">
                                    <button type="submit" class="btn btn-primary">Verify OTP</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
