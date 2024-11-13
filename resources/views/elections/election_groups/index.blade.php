@extends('layouts.elections')

@push('head')
    <!-- DataTable CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- Page Title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">EHPCZ - Election Groups for {{ $election->name }}</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{ route('elections.index') }}">Elections</a></li>
                                <li class="breadcrumb-item active">Election Groups</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button -->
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('elections.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to Elections
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

            <!-- Table for Election Groups -->
            <div class="row">
                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Groups for {{ $election->name }}</h5>
                            <table style="width: 100%;" id="buttons-datatables" class="display table table-bordered dataTable no-footer" aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Group Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($groups as $group)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $group->name }}</td>
                                        <td>
                                            <!-- Manage Categories Button -->
                                            <a href="{{ route('elections.groups.categories.index', [$election->id, $group->id]) }}" class="btn btn-sm btn-warning" title="Manage Categories">
                                                <i class="fa fa-tags"></i> Manage Categories
                                            </a>

                                            <!-- Manage Professions Button -->
                                            <a href="{{ route('elections.groups.professions.index', [$election->id, $group->id]) }}" class="btn btn-sm btn-info" title="Manage Professions">
                                                <i class="fa fa-cogs"></i> Manage Professions
                                            </a>

                                            <!-- Edit Button -->
                                            <a href="#" class="edit-button btn btn-sm btn-primary"
                                               data-id="{{ $group->id }}"
                                               data-name="{{ $group->name }}"
                                               title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <!-- Delete Button -->
                                            <form action="{{ route('groups.destroy', $group->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                    <i class="fa fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Form for Adding and Editing Groups -->
                <div class="col-xxl-3">
                    <div class="card border card-border-light">
                        <div class="card-header">
                            <h6 id="card-title" class="card-title mb-0">Add New Group</h6>
                        </div>
                        <div class="card-body">
                            <form id="group-form" action="{{ route('elections.groups.store', $election->id) }}" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="POST">

                                <!-- Group Name -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Group Name</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        id="name"
                                        placeholder="e.g., Group A"
                                        value="{{ old('name') }}"
                                    >
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="submit-button">Add Group</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@push('scripts')
    <!-- Load jQuery First -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTable JS and other plugin scripts after jQuery -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <!-- Custom Script -->
    <script>
        $(document).ready(function() {
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });

            var submitButton = $('#submit-button');
            var groupForm = $('#group-form');

            // Edit Button Click Handler
            $(document).on('click', '.edit-button', function(event) {
                event.preventDefault(); // Prevent default anchor behavior

                var name = $(this).data('name');
                var id = $(this).data('id');

                // Update form action to the update route for the group
                groupForm.attr('action', '/groups/' + id); // Use shallow route with only the group ID
                $('input[name="_method"]').val('PATCH'); // Set the method to PATCH for updating
                submitButton.text('Update Group'); // Change button text to "Update Group"

                // Prefill the form fields with the existing group data
                $('#name').val(name);

                // Update titles if needed
                $('#card-title').text('Edit Group');
                $('#page-title').text('Edit Group');
            });

            // Reset form when switching back to "Add" mode
            groupForm.on('reset', function() {
                groupForm.attr('action', '{{ route("elections.groups.store", $election->id) }}');
                $('input[name="_method"]').val('POST');
                submitButton.text('Add Group');
                $('#card-title').text('Add New Group');
                $('#page-title').text('Add New Group');
            });
        });
    </script>
@endpush
