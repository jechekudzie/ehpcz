@extends('layouts.admin_practitioner')
@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">

@endpush
@section('content')
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4">
                <div class="tab-content">
                    @if(session()->has('errors'))
                        @if($errors->any())
                            <div class="row">
                                <div class="toast fade show col-8" role="alert" aria-live="assertive"
                                     data-bs-autohide="false" aria-atomic="true">
                                    <div class="toast-header">
                                        <span class="fw-semibold me-auto">Validation Errors</span>
                                        <small>Just now</small>
                                        <button type="button" class="btn-close" data-bs-dismiss="toast"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="toast-body">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif

                    @if(session('success'))
                        <div class="col-8 alert alert-message alert-secondary alert-dismissible fade show"
                             role="alert">
                            <strong>Message!</strong> {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">
                        <div class="card border card-border-primary">
                            <div class="card-header">
                            <span class="float-end fs-10">
                                 <a style="font-size: 12px; color: white;" href="{{route('practitioner-professions.index',$practitioner->slug)}}" class="btn btn-success fw-medium">
                                     <i class="fa fa-arrow-left"></i> Back To Professions
                                 </a>
                                <a style="font-size: 12px; color: white;" href="#" class="btn btn-primary fw-medium" data-bs-toggle="modal" data-bs-target="#addProfession">
                                    <i class="fa fa-plus"></i> Add Professional Qualification
                                </a>

                            </span>
                                <h6 class="card-title mb-0">{{$practitionerProfession->profession->name}}
                                    Qualifications
                                </h6><br/>
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
                                            style="width: 336.4px;">Category
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Qualification
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Institution
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Register
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            style="width: 336.4px;">Level
                                        </th>


                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            style="width: 112.4px;">Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($practitionerProfession->professionalQualifications as $professionalQualification)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td>{{$professionalQualification->qualificationCategory->name}}</td>
                                            <!-- Check if the qualification category is 'Local' or 'Foreign' and display accordingly -->
                                            <td>
                                                @if($professionalQualification->qualificationCategory->name == 'Local')
                                                    {{$professionalQualification->qualification->name }}
                                                @else
                                                    {{$professionalQualification->qualification_name}}
                                                @endif
                                            </td>
                                            <td>
                                                @if($professionalQualification->qualificationCategory->name == 'Local')
                                                    {{$professionalQualification->institution->name}}
                                                @else
                                                    {{$professionalQualification->institution_name}}
                                                @endif
                                            </td>

                                            <td>{{$professionalQualification->register->name}}</td>
                                            <td>{{$professionalQualification->qualificationLevel->name}}</td>
                                            <td>
                                                <!-- Edit Button -->
                                                <a href="{{route('practitioner-professional-qualifications.edit',$professionalQualification->slug)}}"
                                                   class="edit-button btn btn-sm btn-primary" title="Edit">
                                                    <i class="fa fa-pencil"></i>
                                                </a>
                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('practitioner-professional-qualifications.destroy', $professionalQualification->slug) }}"
                                                    method="POST" onsubmit="return confirm('Are you sure?');"
                                                    style="display: inline-block;">
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

                    <!-- Add Modal -->
                    <div class="modal fade" id="addProfession" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Add Professional Qualification</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form method="post"
                                          action="{{ route('practitioner-professional-qualifications.store', $practitionerProfession->slug) }}"
                                          enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">

                                            <!-- Qualification Category Dropdown -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="qualification_category_id" class="form-label">Qualification
                                                        Category</label>
                                                    <select class="form-control" id="qualification_category_id"
                                                            name="qualification_category_id">
                                                        <option value="">Select Category</option>
                                                        @foreach(\App\Models\QualificationCategory::all() as $category)
                                                            <option value="{{$category->id}}"
                                                                    data-category-name="{{$category->name}}">{{$category->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Qualification Level Dropdown -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="qualification_level_id" class="form-label">Qualification
                                                        Level</label>
                                                    <select class="form-control" id="qualification_level_id"
                                                            name="qualification_level_id">
                                                        <option value="">Select Level</option>
                                                        @foreach(\App\Models\QualificationLevel::all() as $level)
                                                            <option value="{{$level->id}}">{{$level->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Local Fields -->
                                        <div id="localFields" class="row" style="display: none;">
                                            <!-- Qualification Dropdown -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="qualificationLabel"
                                                           class="form-label">Qualification</label>
                                                    <select class="form-control" id="qualification_id"
                                                            name="qualification_id">
                                                        <option value="">Select Qualification</option>
                                                        @foreach(\App\Models\Qualification::where('profession_id',$practitionerProfession->profession_id)->get() as $qualification)
                                                            <option
                                                                value="{{$qualification->id}}">{{$qualification->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Institution Dropdown -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="institution_id"
                                                           class="form-label">Institution</label>
                                                    <select class="form-control" id="institution_id"
                                                            name="institution_id">
                                                        <option value="">Select Institution</option>
                                                        @foreach(\App\Models\Institution::all() as $institution)
                                                            <option
                                                                value="{{$institution->id}}">{{$institution->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Foreign Fields -->
                                        <div id="foreignFields" class="row" style="display: none;">
                                            <!-- Qualification Text Input -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="qualification" class="form-label">Qualification</label>
                                                    <input type="text" class="form-control" id="qualification_name"
                                                           name="qualification_name" placeholder="Enter Qualification">
                                                </div>
                                            </div>

                                            <!-- Institution Text Input -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="institution" class="form-label">Institution</label>
                                                    <input type="text" class="form-control" id="institution_name"
                                                           name="institution_name" placeholder="Enter Institution">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Register Dropdown -->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="register_id" class="form-label">Register</label>
                                                    <select class="form-control" id="register_id"
                                                            name="register_id">
                                                        <option value="">Select Register</option>
                                                        @foreach(\App\Models\Register::all() as $register)
                                                            <option
                                                                value="{{$register->id}}">{{$register->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Start and Completion Dates -->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">Start Date</label>
                                                    <input type="text" class="form-control datepicker"
                                                           id="start_date" name="start_date"
                                                           placeholder="Enter Start Date">
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="completion_date" class="form-label">Completion
                                                        Date</label>
                                                    <input type="text" class="form-control datepicker"
                                                           id="completion_date" name="completion_date"
                                                           placeholder="Enter Completion Date">
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Form Submission Buttons -->
                                        <div class="col-lg-12">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="submit" class="btn btn-primary">Submit Qualification
                                                    Details
                                                </button>
                                                <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <script>
                                        // JavaScript to handle dynamic field display
                                        document.addEventListener('DOMContentLoaded', function () {
                                            // Function to clear fields
                                            function clearFields(fieldsContainer) {
                                                var inputs = fieldsContainer.querySelectorAll('input');
                                                var selects = fieldsContainer.querySelectorAll('select');

                                                inputs.forEach(function (input) {
                                                    input.value = '';
                                                });

                                                selects.forEach(function (select) {
                                                    select.selectedIndex = 0;
                                                });
                                            }

                                            // Function to toggle the display of fields based on the selected qualification category
                                            function toggleQualificationFields() {
                                                var categorySelect = document.getElementById('qualification_category_id');
                                                var localFields = document.getElementById('localFields');
                                                var foreignFields = document.getElementById('foreignFields');
                                                var selectedCategory = categorySelect.options[categorySelect.selectedIndex].dataset.categoryName.toLowerCase();

                                                if (selectedCategory === 'local') {
                                                    localFields.style.display = 'flex';
                                                    foreignFields.style.display = 'none';
                                                    clearFields(foreignFields); // Clear fields in the foreignFields container
                                                } else if (selectedCategory === 'foreign') {
                                                    localFields.style.display = 'none';
                                                    foreignFields.style.display = 'flex';
                                                    clearFields(localFields); // Clear fields in the localFields container
                                                } else {
                                                    localFields.style.display = 'none';
                                                    foreignFields.style.display = 'none';
                                                    clearFields(localFields); // Clear fields in both containers
                                                    clearFields(foreignFields);
                                                }
                                            }

                                            // Event listener for change on the qualification category dropdown
                                            document.getElementById('qualification_category_id').addEventListener('change', toggleQualificationFields);

                                            // Call the function to set the correct display on page load in case there is a pre-selected category
                                            toggleQualificationFields();
                                        });

                                    </script>


                                </div>
                            </div>
                            <!--end modal-content-->
                        </div>
                        <!--end modal-dialog-->
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!--end col-->
@endsection

@push('scripts')

    <script src="{{asset('administration/assets/js/pages/profile-setting.init.js')}}"></script>
    <!-- Ensure Date Picker-->
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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
    </script>

    <script>
        $(function () {
            $("#start_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });

            $("#completion_date").datepicker({
                dateFormat: "yy-mm-dd",
                changeMonth: true,
                changeYear: true,
            });
        });
    </script>
    <script>
        //get cities for city_id select based on province_id select using /api/cities/{province_id} route get method
        $(document).ready(function () {
            $('#province_id').on('change', function () {
                var province_id = this.value;
                $("#city_id").html('');
                $.ajax({
                    url: "{{url('api/cities')}}/" + province_id,
                    type: "GET",
                    dataType: "json",
                    success: function (result) {
                        if (result.success) {
                            $('#city_id').html('<option value="">Select City</option>');
                            $.each(result.cities, function (key, value) {
                                $("#city_id").append('<option value="' + key + '">' + value + '</option>');
                            });
                        }
                    }
                });
            });
        });


    </script>

@endpush

