@extends('layouts.elections')

@section('content')
    <div class="container-fluid">
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0" id="page-title">Add/Update Bio for {{ $candidate->practitioner->first_name.' '.$candidate->practitioner->last_name }}</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="#">Elections</a></li>
                            <li class="breadcrumb-item active">Manage Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="row mb-3">
            <div class="col-12">
                <a href="{{ route('elections.categories.candidates.index', [$candidate->election->id, $candidate->profession_category_id]) }}" class="btn btn-sm btn-info" title="Manage Candidates">
                    <i class="fa fa-users"></i> Back To Candidates
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('elections.categories.candidates.bio.store', [$election,$category,$candidate->id]) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="bio" class="form-label">Candidate Bio</label>
                        <textarea name="bio" id="bio" class="form-control" rows="5" required>{{ old('bio', $candidate->bio) }}</textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Save Bio</button>
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Cancel</a>
                </form>

            </div>
        </div>


    </div>
@endsection
