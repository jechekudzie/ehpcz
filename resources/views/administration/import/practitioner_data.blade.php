@extends('layouts.admin')

@push('head')

    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endpush
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0" id="page-title">Practitioners</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Practitioners</li>
                            </ol>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex align-items-center flex-wrap gap-2">
                                    <div class="flex-grow-1">

                                        <a href="{{route('contact-types.index')}}" class="btn btn-info btn-sm add-btn">
                                            <i class="fa fa-refresh"></i> Refresh
                                        </a>
                                        <button id="new-button" class="btn btn-success btn-sm add-btn">
                                            <i class="fa fa-plus"></i> Add new
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xxl-12">
                        <div class="card">
                            <div class="card-body">
                                <!-- Start table -->
                                <table style="width: 100%;" id="practitioner-datatable"
                                       class="display responsive nowrap table table-striped table-bordered dataTable no-footer"
                                       aria-describedby="practitioner-datatable_info">
                                    <thead>
                                    <tr>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Registration Number</th>
                                        <th>ID Number / Passport Number</th>
                                        <th>Profession</th>
                                        <th>Highest Qualification</th>
                                        <th>Qualification Institution</th>
                                        <th>Year of Registration</th>
                                        <th>Current Employment</th>
                                        <th>Current Employer</th>
                                        <th>Employment Sector</th>
                                        <th>Province</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Phone Number</th>
                                        <th>Date of Birth</th>
                                        <th>Gender/Sex</th>
                                        <th>Marital Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($practitioners as $practitioner)
                                        <tr>
                                            <td>{{ $practitioner->first_name }}</td>
                                            <td>{{ $practitioner->last_name }}</td>
                                            <td>{{ $practitioner->registration_number }}</td>
                                            <td>{{ $practitioner->identification_number }}</td>
                                            <td>{{ App\Models\Profession::find($practitioner->profession_id)->name ?? 'N/A' }}</td>
                                            <td>{{ App\Models\Qualification::find($practitioner->qualification_id)->name ?? 'N/A' }}</td>
                                            <td>{{ App\Models\Institution::find($practitioner->institution_id)->name ?? 'N/A' }}</td>
                                            <td>{{ $practitioner->registration_year }}</td>
                                            <td>{{ $practitioner->employment_status }}</td>
                                            <td>{{ $practitioner->current_employer }}</td>
                                            <td>{{ App\Models\EmploymentSector::find($practitioner->employment_sector_id)->name ?? 'N/A' }}</td>
                                            <td>{{ App\Models\Province::find($practitioner->province_id)->name ?? 'N/A' }}</td>
                                            <td>{{ $practitioner->email }}</td>
                                            <td>{{ $practitioner->address }}</td>
                                            <td>{{ $practitioner->phone_number }}</td>
                                            <td>{{ $practitioner->date_of_birth }}</td>
                                            <td>{{ App\Models\Gender::find($practitioner->gender_id)->name ?? 'N/A' }}</td>
                                            <td>{{ App\Models\MaritalStatus::find($practitioner->marital_status_id)->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <!-- End table -->
                            </div>
                        </div>
                    </div>

                    <!--end col-->
                    <!--end card-->
                </div>

            </div>
            <!--end row-->

        </div>
        <!-- container-fluid -->
    </div>
@stop
@push('scripts')
    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#practitioner-datatable').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });
        });
        <!-- datatable js -->
        document.addEventListener("DOMContentLoaded", function () {
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });
        });

        // Assuming you have jQuery available
        $(document).ready(function() {
            // Define the submit button
            var submitButton = $('#submit-button'); // Replace with your actual button ID or class
            submitButton.text('Add New');
            //on load by default name field to be empty
            $('#name').val('');

            // Click event for the edit button
            $('.edit-button').on('click', function() {
                var name = $(this).data('name');
                var slug = $(this).data('slug');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/contact-types/' + slug);
                $('input[name="_method"]').val('PATCH');
                submitButton.text('Update');
                // Populate the form for editing
                $('#name').val(name);
                $('#card-title').text('Edit - ' + name + ' Contact Type');
                $('#page-title').text('Edit - ' + name + ' Contact Type');
            });

            // Click event for adding a new item
            $('#new-button').on('click', function() {
                // Clear the form, set action for creation, method to POST, and button text to Add New
                $('#edit-form').attr('action', '/contact-types');
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');
                $('#name').val('');
                $('#card-title').text('Add Contact Type');
                $('#page-title').text('Add New Contact Type');
            });
        });



    </script>

@endpush
