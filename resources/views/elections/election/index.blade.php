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

            <!-- Table for Elections -->
            <div class="row">
                <div class="col-xxl-9">
                    <div class="card">
                        <div class="card-body">
                            <table style="width: 100%;" id="buttons-datatables" class="display table table-bordered dataTable no-footer" aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Election Period</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Election Group</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($elections as $election)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $election->name }}</td>
                                        <td>{{ $election->start_date }}</td>
                                        <td>{{ $election->end_date }}</td>
                                        <td>{{ $election->status }}</td>
                                        <td>
                                            <a href="{{route('elections.groups.index',$election->id)}}" class="btn btn-sm btn-primary">
                                                Election Groups
                                            </a>
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="#" class="edit-button btn btn-sm btn-primary"
                                               data-id="{{ $election->id }}"
                                               data-name="{{ $election->name }}"
                                               data-start="{{ $election->start_date }}"
                                               data-end="{{ $election->end_date }}"
                                               data-status="{{ $election->status }}"
                                               title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>

                                            <!-- Update Status Button -->
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-toggle="modal"
                                                    data-bs-target="#statusModal" data-id="{{ $election->id }}"
                                                    data-status="{{ $election->status }}" title="Update Status">
                                                <i class="fa fa-sync"></i> Status
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('elections.destroy', $election->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
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

                <!-- Form for Adding and Editing Elections -->
                <div class="col-xxl-3">
                    <div class="card border card-border-light">
                        <div class="card-header">
                            <h6 id="card-title" class="card-title mb-0">Add New Election</h6>
                        </div>
                        <div class="card-body">
                            <form id="election-form" action="{{ route('elections.store') }}" method="post">
                                @csrf
                                <input type="hidden" name="_method" value="POST">

                                <!-- Election Period -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Election Period</label>
                                    <input
                                        type="text"
                                        name="name"
                                        class="form-control"
                                        id="name"
                                        placeholder="e.g., 2025 to 2029 Board Elections"
                                        value="{{ old('name') }}"
                                    >
                                </div>

                                <!-- Start Date -->
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <div class="input-group">
                                        <input
                                            type="date"
                                            name="start_date"
                                            class="form-control election_date"
                                            id="start_date"
                                            value="{{ old('start_date') }}"
                                        >
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <!-- End Date -->
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <div class="input-group">
                                        <input
                                            type="date"
                                            name="end_date"
                                            class="form-control election_date"
                                            id="end_date"
                                            value="{{ old('end_date') }}"
                                        >
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary" id="submit-button">Add Election</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <!-- Update Status Modal -->
    <div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="statusModalLabel">Update Election Status</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="statusForm" method="POST" action="">
                        @csrf
                        @method('PATCH')

                        <!-- Status Selection -->
                        <div class="mb-3">
                            <label for="status" class="form-label">Select Status</label>
                            <select name="status" id="status" class="form-select">
                                <option value="Pending">Pending</option>
                                <option value="Ongoing">Ongoing</option>
                                <option value="Completed">Completed</option>
                            </select>
                        </div>

                        <!-- Hidden field to store election ID -->
                        <input type="hidden" id="electionId" name="election_id" value="">

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Update Status</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@push('scripts')
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

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Event listener for the Update Status button to open the modal with data
            $('#statusModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget); // Button that triggered the modal
                var electionId = button.data('id'); // Extract election ID from data-* attributes
                var status = button.data('status'); // Extract current status

                // Update the modal's form action with the election ID
                var formAction = '/elections/' + electionId + '/status-update';
                $('#statusForm').attr('action', formAction);

                // Set the selected status in the dropdown
                $('#status').val(status);
                $('#electionId').val(electionId); // Update hidden input with election ID
            });
        });
    </script>

   <script>

       document.addEventListener("DOMContentLoaded", function () {
           // Initialize DataTable with export buttons
           $('#buttons-datatables').DataTable({
               dom: 'Bfrtip',
               buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
           });
       });

       $(document).ready(function() {
           var submitButton = $('#submit-button');
           var electionForm = $('#election-form');

           // Default: Set the button to "Add Election"
           submitButton.text('Add Election');

           // Edit Button Click Handler
           $('.edit-button').on('click', function() {
               // Get data attributes from the clicked edit button
               var name = $(this).data('name');
               var start = $(this).data('start');
               var end = $(this).data('end');
               var status = $(this).data('status');
               var id = $(this).data('id');

               // Update form action to the update route
               electionForm.attr('action', '/elections/' + id);
               $('input[name="_method"]').val('PATCH'); // Set the method to PATCH for updating
               submitButton.text('Update Election'); // Change button text to "Update Election"

               // Prefill the form fields with the existing election data
               $('#name').val(name);
               $('#start_date').val(start);
               $('#end_date').val(end);
               $('#status').val(status);

               // Update titles or other elements if needed
               $('#card-title').text('Edit Election');
               $('#page-title').text('Edit Election');
           });

           // Add New Button Click Handler
           $('#new-button').on('click', function() {
               // Reset the form for a new entry
               electionForm.attr('action', '/elections').trigger("reset"); // Reset the form fields
               $('input[name="_method"]').val('POST'); // Set method to POST for creating a new entry
               submitButton.text('Add Election'); // Set button text to "Add Election"

               // Reset titles and fields
               $('#card-title').text('Add New Election');
               $('#page-title').text('Add New Election');
           });
       });


   </script>

@endpush
