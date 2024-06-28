@extends('layouts.admin_practitioner')
@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
    {{--@include('partials.admin_practitioner.profile')
--}}
    <!--end col-->
    <div class="col-xxl-9">
        <div class="card mt-xxl-n5">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4" style="font-weight: bold;color: black;!important;">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <div class="card border card-border-primary">
                            <div class="card-header">
                                                <span class="float-end align-middle fs-10">
                                                    <a style="font-size: 12px;color:white;"
                                                       href="{{route('practitioners.edit',$practitioner->slug)}}"
                                                       class="btn btn-primary fw-medium" data-bs-toggle="modal"
                                                       data-bs-target="#addEmployment">
                                                        <i class="fa fa-plus"></i> Add Employment
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
                            @if($practitioner->employments->isEmpty())
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="text-center">
                                                <h4>No Employment Details Found</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif(!$practitioner->employments->isEmpty())
                                @foreach($practitioner->employments as $employment)
                                    <div class="card-body">
                                        <div class="row">
                                            <!--start col-->
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Employer :</p>
                                                        <h6 class="text-truncate mb-0">
                                                            {{$employment->employer}}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--start col-->
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Employment Position :</p>
                                                        <h6 class="text-truncate mb-0">
                                                            {{$employment->position}}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--start col-->
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Employment Sector :</p>
                                                        <h6 class="text-truncate mb-0">
                                                            @if($employment->employmentSector)
                                                                {{$employment->employmentSector->name}}
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <div class="row">
                                            <!--start col-->
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Province :</p>
                                                        <h6 class="text-truncate mb-0">
                                                            @if($employment->province)
                                                                {{$employment->province->name}}
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--start col-->
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">City :</p>
                                                        <h6 class="text-truncate mb-0">
                                                            @if($employment->city)
                                                                {{$employment->city->name}}
                                                            @endif
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--start col-->
                                            <div class="col-6 col-md-4">
                                                <div class="d-flex mt-4">
                                                    <div class="flex-grow-1 overflow-hidden">
                                                        <p class="mb-1">Employment Status :</p>
                                                        <h6 class="text-truncate mb-0">
                                                            {{$employment->is_current == 1 ? 'Current Employer' : 'Previous Employer'}}
                                                        </h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <div style="margin-top:3%">
                                            <a href="{{route('practitioner-employments.edit',$employment->slug)}}"> <i
                                                    class="fa fa-pencil"></i> Edit Employment Details</a>
                                        </div>
                                        <hr/>

                                    </div>
                                @endforeach
                            @endif
                        </div>


                        <!-- Edit Modal -->
                        <div class="modal fade" id="addEmployment" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Add Employment Details</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post"
                                              action="{{ route('practitioner-employments.store', $practitioner->slug) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Title Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="employment_sector_id" class="form-label">Employment
                                                            Sector</label>
                                                        <select class="form-control" id="employment_sector_id"
                                                                name="employment_sector_id">
                                                            <option value="">Select Employment Sector</option>
                                                            @foreach(\App\Models\EmploymentSector::all() as $employmentSector)
                                                                <option
                                                                    value="{{$employmentSector->id}}">{{$employmentSector->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <!-- Employment Status Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="is_current" class="form-label">Employment
                                                            Status</label>
                                                        <select class="form-control" id="is_current"
                                                                name="is_current">
                                                            <option value="">Select Employment Status</option>
                                                            <option value="0">Previous Employer</option>
                                                            <option value="1">Current Employer</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- First Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="employer" class="form-label">Employer Name</label>
                                                        <input type="text" class="form-control" id="employer"
                                                               name="employer" placeholder="Enter your employer"
                                                               value="">
                                                    </div>
                                                </div>

                                                <!-- Middle Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="middlenameInput" class="form-label">Position</label>
                                                        <input type="text" class="form-control" id="middlenameInput"
                                                               name="position" placeholder="Enter your position"
                                                               value="">
                                                    </div>
                                                </div>

                                                <!-- Last Name Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="start_date" class="form-label">Start Date</label>
                                                        <input type="text" class="form-control" id="start_date"
                                                               name="start_date" placeholder="Enter your start date"
                                                               value="">
                                                    </div>
                                                </div>

                                                <!-- Date of Birth Input -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="end_date" class="form-label">Resignation
                                                            date</label>
                                                        <input type="text" id="end_date" class="form-control"
                                                               name="end_date" placeholder="Enter resignation date"
                                                               value="">
                                                    </div>
                                                </div>

                                                <!-- Province Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="province_id" class="form-label">Province</label>
                                                        <select class="form-control" id="province_id"
                                                                name="province_id">
                                                            <option value="">Select Province</option>
                                                            @foreach(\App\Models\Province::all() as $province)
                                                                <option
                                                                    value="{{$province->id}}">{{$province->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>


                                                <!-- City Dropdown -->
                                                <div class="col-lg-4">
                                                    <div class="mb-3">
                                                        <label for="city_id" class="form-label">City</label>
                                                        <select class="form-control" id="city_id"
                                                                name="city_id">

                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Add
                                                            Employment
                                                        </button>
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>


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

