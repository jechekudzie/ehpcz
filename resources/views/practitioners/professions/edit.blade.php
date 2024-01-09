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
                                                <span class="float-end badge bg-primary align-middle fs-10">
                                                    <a style="font-size: 14px;color:white;"
                                                       href="{{route('practitioner-professions.index',$practitioner->slug)}}"
                                                       class="link-primary fw-medium">
                                                        <i class="fa fa-arrow-left"></i> Back To Professions
                                                    </a>
                                                </span>
                                <h6 class="card-title mb-0">Practitioner Profession</h6><br/>
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
                                        <form method="post"
                                              action="{{ route('practitioner-professions.update', $practitionerProfession->slug) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            @method('PATCH')
                                            <div class="row">
                                                <!-- Profession Dropdown -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="profession_id" class="form-label">Profession</label>
                                                        <select class="form-control" id="profession_id" name="profession_id">
                                                            <option value="">Select Profession</option>
                                                            @foreach(\App\Models\Profession::all() as $profession)
                                                                <option value="{{$profession->id}}"
                                                                    {{ $practitionerProfession->profession_id == $profession->id ? 'selected' : '' }}>
                                                                    {{$profession->name}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Registration Number Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="registration_number" class="form-label">Registration Number</label>
                                                        <input type="text" class="form-control" id="registration_number"
                                                               name="registration_number" placeholder="Enter Registration Number"
                                                               value="{{ $practitionerProfession->registration_number }}">
                                                    </div>
                                                </div>

                                                <!-- Registration Date Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="registration_date" class="form-label">Registration Date</label>
                                                        <input type="text" class="form-control datepicker" id="registration_date"
                                                               name="registration_date" placeholder="Enter Registration Date"
                                                               value="{{ $practitionerProfession->registration_date }}">
                                                    </div>
                                                </div>

                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Submit Profession Details</button>
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

