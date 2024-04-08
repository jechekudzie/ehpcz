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
                        <h4 class="mb-sm-0" id="page-title">{{$exchangeRateType->name}} - Exchange Rates</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{$exchangeRateType->name}} - Exchange Rates/li>
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
                                            <i class="fa fa-arrow-left"></i> Back
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
                    @if(session()->has('errors'))
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <!-- Success Alert -->
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong> Errors! </strong> {{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                </div>
                            @endforeach

                        @endif
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
                                            style="width: 336.4px;">Base Currency
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Exchange Currency
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Rate
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Effective Date
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($exchangeRates as $exchangeRate)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$exchangeRate->baseCurrency->symbol.' '.$exchangeRate->baseCurrency->name}}</td>
                                            <td>{{$exchangeRate->exchangeCurrency->symbol.' '.$exchangeRate->exchangeCurrency->name}}</td>
                                            <td>{{$exchangeRate->exchangeCurrency->symbol}} {{$exchangeRate->rate}}</td>
                                            <td>{{$exchangeRate->effective_date}} </td>
                                            <!-- Exchange Rates -->

                                            <td>
                                                <!-- Edit Button -->
                                                <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary"
                                                   data-id="{{ $exchangeRate->id }}"
                                                   data-base="{{ $exchangeRate->baseCurrency->id }}"
                                                   data-exchange="{{ $exchangeRate->exchangeCurrency->id }}"
                                                   data-rate="{{$exchangeRate->rate}}"
                                                   data-effective="{{$exchangeRate->effective_date}}" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('exchange-rates.destroy', $exchangeRate->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
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
                                <h6 id="card-title" class="card-title mb-0">{{$exchangeRateType->name}} Rates</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="{{ route('exchange-rates.store',$exchangeRateType->id) }}" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="base_currency_id" class="form-label">Base Currency</label>
                                        <select name="base_currency_id" class="form-control" id="base_currency_id" readonly>
                                            <option value="{{ $currencies->first()->id }}">{{ $currencies->first()->symbol }} - {{ $currencies->first()->name }}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="exchange_currency_id" class="form-label">Exchange Currency</label>
                                        <select name="exchange_currency_id" class="form-control" id="exchange_currency_id">
                                            @foreach($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->symbol }} - {{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="rate" class="form-label">Rate</label>
                                        <input type="text" name="rate" class="form-control" id="rate" placeholder="Enter exchange rate" value="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="effective_date" class="form-label">Effective Date</label>
                                        <input type="date" name="effective_date" class="form-control" id="effective_date" value="">
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
            var submitButton = $('#submit-button');
            submitButton.text('Add New');

            $('.edit-button').on('click', function() {
                var base = $(this).data('base');
                var exchange = $(this).data('exchange'); // Adjusted to match the HTML
                var rate = $(this).data('rate');
                var effective = $(this).data('effective');
                var id = $(this).data('id');

                // Debugging: Check if baseCurrencyId and exchangeCurrencyId are correctly retrieved
                console.log("Base Currency ID: ", base);
                console.log("Exchange Currency ID: ", exchange);

                // Set the form action, method, and button text for editing
                $('#edit-form').attr('action', '/exchange-rates/' + id + '/update') ;
                $('input[name="_method"]').val('PATCH');
                $('#submit-button').text('Update');

                // Populate the form fields with the data from the button
                $('#base_currency_id').val(base);
                $('#exchange_currency_id').val(exchange);
                $('#rate').val(rate);
                $('#effective_date').val(effective);

                // Update titles or other elements as needed
                $('#card-title, #page-title').text('Edit Exchange Rate');
            });
            $('#new-button').on('click', function() {
                // Reset form for adding a new exchange rate
                $('#edit-form').attr('action', '/exchange-rates').trigger("reset");
                $('input[name="_method"]').val('POST');
                submitButton.text('Add New');

                // Clear form fields and reset titles
                $('#base_currency_id').val(''); // Make sure this ID matches your form field's ID
                $('#exchange_currency_id').val(''); // Make sure this ID matches your form field's ID
                $('#rate').val('');
                $('#effective_date').val('');
                $('#card-title, #page-title').text('Add New Exchange Rate');
            });
        });




    </script>

@endpush
