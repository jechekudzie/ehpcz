@extends('layouts.elections')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Manage Professions for {{ $group->name }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('elections.index') }}">Elections</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('elections.groups.index', $election->id) }}">Groups</a></li>
                                <li class="breadcrumb-item active">Manage Professions</li>
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

            <!-- Form to Add Profession -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Add Profession to {{ $group->name }}</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('elections.groups.professions.store', [$election->id, $group->id]) }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="profession_id" class="form-label">Select Profession</label>
                                    <select name="profession_id" id="profession_id" class="form-control">
                                        <option value="" disabled selected>Select a profession</option>
                                        @foreach($allProfessions as $profession)
                                            <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Profession</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- List of Assigned Professions -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title">Professions in {{ $group->name }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Profession Name</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($assignedProfessions as $profession)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $profession->name }}</td>
                                        <td>
                                            <!-- Delete Button -->
                                            <form action="{{ route('elections.groups.professions.destroy', [$election->id, $group->id, $profession->id]) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this profession from the group?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center">No professions assigned to this group.</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
