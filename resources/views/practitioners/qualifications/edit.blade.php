@extends('layouts.admin_practitioner')
@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <div class="card border card-border-primary">
                            <div class="card-header">
                                                <span class="float-end align-middle fs-10">
                                                    <a style="color:white;"
                                                       href="{{route('practitioner-professional-qualifications.index',$practitionerProfession->slug)}}"
                                                       class="btn btn-primary fw-medium">
                                                        <i class="fa fa-arrow-left"></i> Back To Qualifications
                                                    </a>
                                                </span>
                                <h6 class="card-title mb-0">{{$professionalQualification->qualification->name}}</h6><br/>
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

                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <!--start col-->
                                    <div class="col-12 col-md-12">

                                        <form method="post" action="{{ route('practitioner-professional-qualifications.update', $professionalQualification->slug) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')

                                            <div class="row">
                                                <!-- Qualification Category Dropdown -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="qualification_category_id" class="form-label">Qualification Category</label>
                                                        <select class="form-control" id="qualification_category_id" name="qualification_category_id">
                                                            <option value="">Select Category</option>
                                                            @foreach(\App\Models\QualificationCategory::all() as $category)
                                                                <option value="{{$category->id}}"
                                                                        data-category-name="{{$category->name}}"
                                                                    {{ $professionalQualification->qualification_category_id == $category->id ? 'selected' : '' }}>
                                                                    {{$category->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Qualification Level Dropdown -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="qualification_level_id" class="form-label">Qualification Level</label>
                                                        <select class="form-control" id="qualification_level_id" name="qualification_level_id">
                                                            <option value="">Select Level</option>
                                                            @foreach(\App\Models\QualificationLevel::all() as $level)
                                                                <option value="{{$level->id}}"
                                                                    {{ $professionalQualification->qualification_level_id == $level->id ? 'selected' : '' }}>
                                                                    {{$level->name}}
                                                                </option>
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
                                                        <label for="qualification_id" class="form-label">Qualification</label>
                                                        <select class="form-control" id="qualification_id" name="qualification_id">
                                                            <option value="">Select Qualification</option>
                                                            @foreach(\App\Models\Qualification::where('profession_id', $professionalQualification->practitionerProfession->profession_id)->get() as $qualification)
                                                                <option value="{{$qualification->id}}"
                                                                    {{ $professionalQualification->qualification_id == $qualification->id ? 'selected' : '' }}>
                                                                    {{$qualification->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Institution Dropdown -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="institution_id" class="form-label">Institution</label>
                                                        <select class="form-control" id="institution_id" name="institution_id">
                                                            <option value="">Select Institution</option>
                                                            @foreach(\App\Models\Institution::all() as $institution)
                                                                <option value="{{$institution->id}}"
                                                                    {{ $professionalQualification->institution_id == $institution->id ? 'selected' : '' }}>
                                                                    {{$institution->name}}
                                                                </option>
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
                                                        <input type="text" class="form-control" id="qualification" name="qualification"
                                                               placeholder="Enter Qualification" value="{{ $professionalQualification->qualification }}">
                                                    </div>
                                                </div>

                                                <!-- Institution Text Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="institution" class="form-label">Institution</label>
                                                        <input type="text" class="form-control" id="institution" name="institution"
                                                               placeholder="Enter Institution" value="{{ $professionalQualification->institution }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <!-- Register Dropdown -->
                                                <div class="col-lg-12">
                                                    <div class="mb-3">
                                                        <label for="register_id" class="form-label">Register</label>
                                                        <select class="form-control" id="register_id" name="register_id">
                                                            <option value="">Select Register</option>
                                                            @foreach(\App\Models\Register::all() as $register)
                                                                <option value="{{$register->id}}"
                                                                    {{ $professionalQualification->register_id == $register->id ? 'selected' : '' }}>
                                                                    {{$register->name}}
                                                                </option>
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
                                                        <input type="text" class="form-control" id="start_date" name="start_date"
                                                               placeholder="Enter Start Date" value="{{ $professionalQualification->start_date }}">
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="completion_date" class="form-label">Completion Date</label>
                                                        <input type="text" class="form-control datepicker" id="completion_date" name="completion_date"
                                                               placeholder="Enter Completion Date" value="{{ $professionalQualification->completion_date }}">
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Form Submission Buttons -->
                                            <div class="col-lg-12">
                                                <div class="hstack gap-2 justify-content-start">
                                                    <button type="submit" class="btn btn-primary">Update Qualification Details</button>

                                                </div>
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
        @endsection

        @push('scripts')

            <script src="{{asset('administration/assets/js/pages/profile-setting.init.js')}}"></script>
            <!-- Ensure Date Picker-->

            <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>

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

                document.addEventListener('DOMContentLoaded', function () {
                    // Define the clearFields function
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

                    // Function to toggle the display of fields
                    function toggleQualificationFields() {
                        var categorySelect = document.getElementById('qualification_category_id');
                        var localFields = document.getElementById('localFields');
                        var foreignFields = document.getElementById('foreignFields');
                        var selectedCategory = categorySelect.options[categorySelect.selectedIndex].dataset.categoryName.toLowerCase();

                        if (selectedCategory === 'local') {
                            localFields.style.display = 'flex';
                            foreignFields.style.display = 'none';
                        } else if (selectedCategory === 'foreign') {
                            localFields.style.display = 'none';
                            foreignFields.style.display = 'flex';
                        } else {
                            localFields.style.display = 'none';
                            foreignFields.style.display = 'none';
                        }
                    }

                    // Event listener for change on the dropdown
                    document.getElementById('qualification_category_id').addEventListener('change', function() {
                        clearFields(localFields);
                        clearFields(foreignFields);
                        toggleQualificationFields();
                    });

                    // Initialize form based on the pre-selected category
                    toggleQualificationFields();
                });


            </script>

    @endpush

