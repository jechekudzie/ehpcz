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
                                                    <a style="font-size: 14px;color:white;"
                                                       href="{{route('practitioner-employments.index',$practitioner->slug)}}"
                                                       class="btn btn-primary fw-medium">
                                                        <i class="fa fa-arrow-left"></i> Back To Employments
                                                    </a>
                                                </span>
                                <h6 class="card-title mb-0">Practitioner Employment</h6><br/>
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
                                        <form method="post" action="{{ route('practitioner-employments.update',  $employment->slug) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="row">
                                                <!-- Employment Sector Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="employment_sector_id" class="form-label">Employment Sector</label>
                                                        <select class="form-control" id="employment_sector_id" name="employment_sector_id">
                                                            <option value="">Select Employment Sector</option>
                                                            @foreach(\App\Models\EmploymentSector::all() as $employmentSector)
                                                                <option value="{{$employmentSector->id}}" {{$employment->employment_sector_id == $employmentSector->id ? 'selected' : ''}}>{{$employmentSector->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Employment Status Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="is_current" class="form-label">Employment Status</label>
                                                        <select class="form-control" id="is_current" name="is_current">
                                                            <option value="0" {{$employment->is_current == 0 ? 'selected' : ''}}>Previous Employer</option>
                                                            <option value="1" {{$employment->is_current == 1 ? 'selected' : ''}}>Current Employer</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Employer Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="employer" class="form-label">Employer Name</label>
                                                        <input type="text" class="form-control" id="employer" name="employer" placeholder="Enter your employer" value="{{ $employment->employer }}">
                                                    </div>
                                                </div>

                                                <!-- Position Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="positionInput" class="form-label">Position</label>
                                                        <input type="text" class="form-control" id="positionInput" name="position" placeholder="Enter your position" value="{{ $employment->position }}">
                                                    </div>
                                                </div>

                                                <!-- Start Date Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="start_date" class="form-label">Start Date</label>
                                                        <input type="text" class="form-control datepicker" id="start_date" name="start_date" placeholder="Enter your start date" value="{{ $employment->start_date }}">
                                                    </div>
                                                </div>

                                                <!-- End Date Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="end_date" class="form-label">End Date</label>
                                                        <input type="text" class="form-control datepicker" id="end_date" name="end_date" placeholder="Enter resignation date" value="{{ $employment->end_date }}">
                                                    </div>
                                                </div>

                                                <!-- Province Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="province_id" class="form-label">Province</label>
                                                        <select class="form-control" id="province_id" name="province_id">
                                                            <option value="">Select Province</option>
                                                            @foreach(\App\Models\Province::all() as $province)
                                                                <option value="{{$province->id}}" {{$employment->province_id == $province->id ? 'selected' : ''}}>{{$province->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- City Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="city_id" class="form-label">City</label>
                                                        <select class="form-control" id="city_id" name="city_id">
                                                            <!-- Options will be added based on selected province -->
                                                            <option value="">Select City</option>
                                                            @foreach(\App\Models\City::all() as $city)
                                                                <option value="{{$city->id}}" {{$employment->city_id == $city->id ? 'selected' : ''}}>{{$city->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Update Employment</button>
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    </div>
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

                    $("#end_date").datepicker({
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

