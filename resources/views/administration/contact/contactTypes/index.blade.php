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
                        <h4 class="mb-sm-0" id="page-title">Contact Types</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Contact Types</li>
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
                    <!--end col-->
                    <div class="col-xxl-9">
                        <div class="card">
                            <div class="card-body">
                                <!--start table-->
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0"
                                            aria-controls="buttons-datatables" rowspan="1" colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                            style="width: 224.4px;">#
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Type
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($contactTypes as $contactType)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$contactType->name}}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary" data-name="{{ $contactType->name }}" data-slug="{{ $contactType->slug }}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('contact-types.destroy', $contactType->slug) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
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
                                <!--end table-->
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-3">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add  Contact Type</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Contact Type</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Enter address type" value="">
                                    </div>
                                    <div class="text-end">
                                        <button id="submit-button" type="submit" class="btn btn-primary">Add New</button>
                                    </div>
                                </form>


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
