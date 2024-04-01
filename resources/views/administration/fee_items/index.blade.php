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
                        <h4 class="mb-sm-0" id="page-title">{{$feeCategory->name}} fees</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">{{$feeCategory->name}} fees</li>
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

                                        <a href="{{route('fees-categories.index')}}"
                                           class="btn btn-info btn-sm add-btn">
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
                    <!-- Alerts for Messages -->
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
                                        <th>#</th>
                                        <th>Category</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th>Profession</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($feeItems as $feeItem)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $feeItem->feeCategory->name ?? 'N/A' }}</td>
                                            <td>{{ $feeItem->name }}</td>
                                            <td>
                                                @if ($feeItem->amount > 0)
                                                    {{-- Directly display feeItem->amount with currency symbol when amount is greater than 0 --}}
                                                    {{ $feeItem->currency->symbol ?? '' }} {{ number_format($feeItem->amount, 2) }}
                                                @else
                                                    {{-- When feeItem->amount is less than or equal to 0, attempt to get the amount from the related professions pivot table --}}
                                                    @php
                                                        $pivotAmount = $feeItem->professions()->where('fee_item_id', $feeItem->id)->first()->pivot->amount ?? 0;
                                                    @endphp
                                                    {{ $feeItem->currency->symbol ?? '' }} {{ number_format($pivotAmount, 2) }}
                                                @endif

                                            </td>
                                            <td>
                                                @if ($feeItem->amount > 0)
                                                    {{ 'N/A' }}
                                                @else
                                                    @php
                                                        $relatedProfession = $feeItem->professions()
                                                                                     ->where('fee_item_id', $feeItem->id)
                                                                                     ->first();
                                                        $professionName = $relatedProfession ? $relatedProfession->name : 'N/A';
                                                    @endphp
                                                    {{ $professionName }}
                                                @endif
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary"
                                                   data-category-name="{{ $feeCategory->name }}"
                                                   data-category-slug="{{ $feeCategory->slug }}"
                                                   data-name="{{ $feeItem->name }}"
                                                   data-amount="{{ $feeItem->amount > 0 ? $feeItem->amount : $feeItem->professions()->where('fee_item_id', $feeItem->id)->first()->pivot->amount ?? 0 }}"
                                                   data-slug="{{ $feeItem->slug }}"
                                                   data-currency="{{ $feeItem->currency_id }}"
                                                   data-description="{{ $feeItem->description }}"
                                                   data-for-profession-checked="{{ $feeItem->professions()->where('fee_item_id', $feeItem->id)->exists() ? 'true' : 'false' }}"
                                                   data-profession-id="{{ optional($feeItem->professions()->where('fee_item_id', $feeItem->id)->first())->id }}"
                                                   title="Edit"><i class="fa fa-pencil"></i></a>
                                                <form action="{{ route('fees-categories.items.destroy', [$feeCategory->slug,$feeItem->slug]) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
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
                                <h6 id="card-title" class="card-title mb-0">Add {{$feeCategory->name}} fees</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="{{ route('fees-categories.items.store', $feeCategory->slug) }}"
                                      method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="currency_id" class="form-label">Currency (Optional)</label>
                                        <select name="currency_id" class="form-control" id="currency_id">
                                            <option value="">Select Currency</option>
                                            @foreach(\App\Models\Currency::all() as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="name" class="form-label">Fee Item Name</label>
                                        <input type="text" name="name" class="form-control" id="name"
                                               placeholder="E.g., EHT Registration Fee">
                                    </div>

                                    <!-- Profession Checkbox -->
                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   id="forProfessionCheckbox" name="for_profession">
                                            <label class="form-check-label" for="forProfessionCheckbox">
                                                For Profession
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Profession Dropdown, initially hidden -->
                                    <div class="mb-3" id="professionDropdown" style="display: none;">
                                        <label for="profession_id" class="form-label">Profession</label>
                                        <select name="profession_id" class="form-control" id="profession_id">
                                            <option value="">Select Profession</option>
                                            @foreach(\App\Models\Profession::all() as $profession)
                                                <option value="{{ $profession->id }}">{{ $profession->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="number" step="0.01" name="amount" class="form-control"
                                               id="amount" placeholder="Enter amount" value="0.00">
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description"
                                                  placeholder="Enter description"></textarea>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" id="submit-button" class="btn btn-primary">Submit</button>
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


        $(document).ready(function () {
            // Handle the change event for the "For Profession" checkbox
            $('#forProfessionCheckbox').change(function () {
                if ($(this).is(':checked')) {
                    $('#professionDropdown').show();
                } else {
                    $('#professionDropdown').hide();
                    $('#profession_id').val(''); // Reset the profession selection
                }
            });

            // Click event for the edit button
            $('.edit-button').on('click', function () {
                // Extract data attributes from the clicked edit button
                var name = $(this).data('name');
                var amount = $(this).data('amount');
                var currencyId = $(this).data('currency');
                var description = $(this).data('description');
                var forProfessionChecked = $(this).data('for-profession-checked');
                var professionId = $(this).data('profession-id');
                var slug = $(this).data('slug');
                var categorySlug = $(this).data('category-slug');


                // Populate form fields with extracted data
                $('#name').val(name);
                $('#amount').val(amount);
                $('#currency_id').val(currencyId);
                $('#description').val(description);

                // Update the submit button text to 'Update'
                $('#submit-button').text('Update');

                // Check or uncheck the "For Profession" checkbox and show/hide the profession dropdown accordingly
                if (forProfessionChecked === true) {
                    // Check the "For Profession" checkbox and show the profession dropdown
                    $('#forProfessionCheckbox').prop('checked',true);
                    $('#professionDropdown').show();

                    // Pre-select the profession in the dropdown if a profession ID is provided
                    if (professionId) {
                        $('#profession_id').val(professionId);
                    }
                } else {
                    // Uncheck the "For Profession" checkbox and hide the profession dropdown
                    $('#forProfessionCheckbox').prop('checked',false);
                    $('#professionDropdown').hide();
                }

                // Set the form action for the update operation, adjusting the URL to your application's routing
                $('#edit-form').attr('action', '/fees-categories/' + categorySlug + '/items/' + slug + '/update');
                // Change form method to PATCH for the update operation
                $('input[name="_method"]').val('PATCH');
            });
        });


    </script>


@endpush
