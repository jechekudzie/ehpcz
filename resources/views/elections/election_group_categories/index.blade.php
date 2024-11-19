@extends('layouts.elections')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Manage Categories for {{ $group->name }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('elections.index') }}">Elections</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('elections.groups.index', $election->id) }}">Groups</a></li>
                                <li class="breadcrumb-item active">Manage Categories</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('elections.groups.index', $election->id) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Groups
                    </a>
                </div>
            </div>

            <!-- Notifications -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Message!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
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

            <!-- Form to Add Category -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Category to {{ $group->name }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('elections.groups.categories.store', [$election->id, $group->id]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">Select Category</label>
                                    <select name="name" id="name" class="form-control">
                                        <option value="" disabled selected>Select a category</option>
                                        <option value="Local Authority">Local Authority</option>
                                        <option value="Non-Local Authority">Non-Local Authority</option>
                                        <option value="General">General</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List of Assigned Categories -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Categories in {{ $group->name }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>
                                            <!-- Link to Manage Candidates -->
                                            <a href="{{ route('elections.categories.candidates.index', [$election->id, $category->id]) }}" class="btn btn-sm btn-info" title="Manage Candidates">
                                                <i class="fa fa-users"></i> Manage Candidates
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($categories->isEmpty())
                                    <tr>
                                        <td colspan="2" class="text-center">No categories assigned to this group.</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
