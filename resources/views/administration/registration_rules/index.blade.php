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
                        <h4 class="mb-sm-0" id="page-title">Registration Rules fees</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">CRM</a></li>
                                <li class="breadcrumb-item active">Registration Rules fees</li>
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
                                        <a href="{{route('registration-rules.index')}}" id="new-button" class="btn btn-success btn-sm add-btn">
                                            <i class="fa fa-plus"></i> Add new
                                        </a>
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
                                       class="display table table-striped table-bordered dt-responsive"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>Register</th>
                                        <th class="col-auto">Is Zimbabwean</th>
                                        <th class="col-auto">Category</th>
                                        <th>Fee Item</th>
                                        <th>Fee</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($registrationRules as $rule)
                                        <tr>
                                            <td>{{ $rule->register->name }}</td>
                                            <td class="col-auto">{{ $rule->is_zimbabwean ? 'Yes' : 'No' }}</td>
                                            <td class="col-auto">{{ $rule->qualificationCategory->name }}</td>
                                            <td>{{ $rule->feeItem->name }} - {{$rule->feeItem->feeCategory->name}}</td>
                                            <td>
                                                @if ($rule->feeItem->amount > 0)
                                                    {{-- Directly display feeItem->amount with currency symbol when amount is greater than 0 --}}
                                                    {{ $rule->feeItem->currency->symbol ?? '' }} {{ number_format($rule->feeItem->amount, 2) }}
                                                @else
                                                    {{-- When feeItem->amount is less than or equal to 0, attempt to get the amount from the related professions pivot table --}}
                                                    @php
                                                        $pivotAmount = $rule->feeItem->professions()->where('fee_item_id', $rule->feeItem->id)->first()->pivot->amount ?? 0;
                                                    @endphp
                                                    {{ $rule->feeItem->currency->symbol ?? '' }} {{ number_format($pivotAmount, 2) }}
                                                @endif
                                            </td>
                                            <td>
                                                <!-- Example actions -->
                                                <a href="javascript:void(0);" class="edit-rule-button btn btn-sm btn-primary"
                                                   data-register-id="{{ $rule->register_id }}"
                                                   data-is-zimbabwean="{{ $rule->is_zimbabwean ? 'true' : 'false' }}"
                                                   data-qualification-category-id="{{ $rule->qualification_category_id }}"
                                                   data-fee-item-id="{{ $rule->fee_item_id }}"
                                                   data-rule-id="{{ $rule->id }}"
                                                   title="Edit"><i class="fa fa-pencil"></i></a>

                                                <form action="{{ route('registration-rules.destroy', $rule->id) }}" method="POST" style="display:inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
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
                                <h6 id="card-title" class="card-title mb-0">Add Registration Rules</h6>
                            </div>
                            <div class="card-body">
                                <form id="edit-form" action="{{ route('registration-rules.store') }}" method="POST">
                                    <input type="hidden" name="_method" value="POST">
                                    @csrf

                                    <!-- Register Dropdown -->
                                    <div class="form-group  mb-3">
                                        <label for="register_id">Register</label>
                                        <select name="register_id" id="register_id" class="form-control">
                                            <option value="">Select Register</option>
                                            @foreach(\App\Models\Register::all() as $register)
                                                <option value="{{ $register->id }}">{{ $register->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Is Zimbabwean Checkbox -->
                                    <input type="hidden" name="is_zimbabwean" value="0">

                                    <div class="form-check mb-3">
                                        <input type="checkbox" class="form-check-input" id="is_zimbabwean" name="is_zimbabwean" value="1">
                                        <label class="form-check-label" for="is_zimbabwean">Is Zimbabwean</label>
                                    </div>

                                    <!-- Qualification Category Dropdown -->
                                    <div class="form-group  mb-3">
                                        <label for="qualification_category_id">Qualification Category</label>
                                        <select name="qualification_category_id" id="qualification_category_id" class="form-control">
                                            <option value="">Select Qualification Category</option>
                                            @foreach(\App\Models\QualificationCategory::all() as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Fee Item Dropdown -->
                                    <div class="form-group  mb-3">
                                        <label for="fee_item_id">Fee Item</label>
                                        <select name="fee_item_id" id="fee_item_id" class="form-control">
                                            <option value="">Select Fee Item</option>
                                            @foreach(\App\Models\FeeItem::where('fee_category_id', 1)->get() as $feeItem)
                                                <option value="{{ $feeItem->id }}">{{ $feeItem->name }} - {{$feeItem->feeCategory->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Submit Button -->
                                    <button id="submit-button" type="submit" class="btn btn-primary">Save Rule</button>
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
            $('.edit-rule-button').on('click', function () {
                // Extract data attributes from the clicked edit button
                var registerId = $(this).data('register-id');
                var isZimbabwean = $(this).data('is-zimbabwean');
                var qualificationCategoryId = $(this).data('qualification-category-id');
                var feeItemId = $(this).data('fee-item-id');
                var ruleId = $(this).data('rule-id');

                // Populate form fields with extracted data
                $('#register_id').val(registerId);
                $('#qualification_category_id').val(qualificationCategoryId);
                $('#fee_item_id').val(feeItemId);

                if (isZimbabwean === true) {
                    $('#is_zimbabwean').prop('checked', true);
                } else {
                    $('#is_zimbabwean').prop('checked', false);
                }

                // Update the submit button text to 'Update'
                $('#submit-button').text('Update');

                // Set the form action for the update operation, adjusting the URL to your application's routing
                $('#edit-form').attr('action', '/registration-rules/' + ruleId + '/update');

                // Change form method to PATCH for the update operation
                $('input[name="_method"]').val('PATCH');
            });
        });


    </script>


@endpush
