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
                        <h4 class="mb-sm-0" id="page-title">Exchange Rate Types</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Exchange Rate Types</li>
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

                                        <a href="{{route('exchange-rate-types.index')}}" class="btn btn-info btn-sm add-btn">
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
                    @if(session()->has('error'))
                        <!-- Error Alert -->
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong> Error! </strong> {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Message!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif
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
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Exchange rates
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Activate rate
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($exchangeRateTypes as $exchangeRateType)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$exchangeRateType->name}}</td>

                                            <!-- Exchange Rates -->
                                            <td>
                                                <a href="{{ route('exchange-rates.index', $exchangeRateType->id) }}" class="btn btn-sm btn-primary" title="View Exchange Rates">
                                                     View Exchange Rates
                                                </a>
                                            </td>

                                            <td>
                                                <!-- Activate Button -->
                                                @if($exchangeRateType->isActive())
                                                    <a href="javascript:void(0);" class="activate-button btn btn-sm btn-danger"
                                                       data-id="{{ $exchangeRateType->id }}"
                                                       data-name="{{ $exchangeRateType->name }}"
                                                       title="Deactivate">
                                                        <i class="fa fa-times"></i> Deactivate
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" class="activate-button btn btn-sm btn-success"
                                                       data-id="{{ $exchangeRateType->id }}"
                                                       data-name="{{ $exchangeRateType->name }}"
                                                       title="Activate">
                                                        <i class="fa fa-check"></i> Activate
                                                    </a>
                                                @endif
                                            </td>



                                            <td>

                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary" data-name="{{ $exchangeRateType->name }}" data-id="{{ $exchangeRateType->id }}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('exchange-rate-types.destroy', $exchangeRateType->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
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
                                <!-- Modal -->
                                <div class="modal fade" id="activateExchangeRateTypeModal" tabindex="-1" aria-labelledby="activateExchangeRateTypeLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content border-0">
                                            <div class="modal-header bg-soft-info p-3">
                                                <h5 class="modal-title" id="activateExchangeRateTypeLabel">Activate Exchange Rate Type</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="card border">
                                                <div class="card-header">
                                                    <h4 class="card-title mb-0" id="modalDetails"> Exchange Rate Type Details</h4>
                                                </div>
                                                <div class="card-body">
                                                    <form method="post" action="{{route('exchange-rate-types.activate')}}">
                                                        @csrf
                                                        <input type="hidden" name="exchange_rate_type_id" id="exchange_rate_type_id">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label for="exchange_rate_type_name" class="form-label">Exchange Rate Type Name</label>
                                                                <input type="text" class="form-control" id="exchange_rate_type_name" name="name" readonly>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="start_date" class="form-label">Start Date</label>
                                                                <input type="date" class="form-control" id="start_date" name="start_date" required>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="end_date" class="form-label">End Date</label>
                                                                <input type="date" class="form-control" id="end_date" name="end_date">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Activate</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--end col-->
                    <div class="col-xxl-3">
                        <div class="card border card-border-light">
                            <div class="card-header">
                                <h6 id="card-title" class="card-title mb-0">Add  Exchange Rate Type</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="{{route('exchange-rate-types.store')}}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Exchange Rate Type</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="Eg. Interbank, Allowance, Black market" value="">
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
                var id = $(this).data('id');

                // Set form action for update, method to PATCH, and button text to Update
                $('#edit-form').attr('action', '/exchange-rate-types/' + id + '/update');
                $('input[name="_method"]').val('PATCH');
                submitButton.text('Update');
                // Populate the form for editing
                $('#name').val(name);
                $('#card-title').text('Edit - ' + name );
                $('#page-title').text('Edit - ' + name );
            });

            // Click event for adding a new item
            $('#new-button').on('click', function() {
                // Clear the form, set action for creation, method to POST, and button text to Add New
                $('#edit-form').attr('action', '/exchange-rate-types');
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');
                $('#name').val('');
                $('#card-title').text('Add Exchange Rate Type');
                $('#page-title').text('Add New Exchange Rate Type');
            });
        });

        $(document).ready(function() {
            // Trigger the modal and populate form
            $('.activate-button').on('click', function() {
                var exchangeRateTypeId = $(this).data('id');
                var exchangeRateTypeName = $(this).data('name');

                // Set the form action and hidden input value
                $('#activateExchangeRateTypeModal form').attr('action', '{{ route('exchange-rate-types.activate') }}');
                $('#activateExchangeRateTypeModal #exchange_rate_type_id').val(exchangeRateTypeId);
                $('#activateExchangeRateTypeModal #exchange_rate_type_name').val(exchangeRateTypeName);
                $('#activateExchangeRateTypeModal #activateExchangeRateTypeLabel').text('Activate ' + exchangeRateTypeName);
                $('#activateExchangeRateTypeModal #modalDetails').text(exchangeRateTypeName + ' Activation Details');

                // Show the modal
                $('#activateExchangeRateTypeModal').modal('show');
            });
        });




    </script>

@endpush
