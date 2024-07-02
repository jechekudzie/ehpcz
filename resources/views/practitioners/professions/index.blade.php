@extends('layouts.admin_practitioner')
@push('head')
    <!--datepicker css-->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
@endpush
@section('content')
   {{-- @include('partials.admin_practitioner.profile')--}}

    <!--end col-->
    <div class="col-xxl-9">
        <div class="card">
            @include('partials.admin_practitioner.profile_nav')

            <div class="card-body p-4" style="font-weight: bold;color: black;!important;">
                <div class="tab-content">
                    <div class="tab-pane active" id="personalDetails" role="tabpanel">

                        <div class="card border card-border-primary">
                            <div class="card-header">
                                @hasanyrole('reception|admin|accountant|accounts-clerk|procurement|registrar|super-admin')
                                <span class="float-end align-middle fs-10">
                                    <a style="font-size: 12px;color:white;"
                                       href="{{route('practitioner-professions.index',$practitioner->slug)}}"
                                       class="btn btn-primary fw-medium" data-bs-toggle="modal"
                                       data-bs-target="#addProfession">
                                        <i class="fa fa-plus"></i> Add Profession
                                    </a>
                                </span>
                                @endhasanyrole
                                <h6 class="card-title mb-0 text-black w-75">Practitioner Professions</h6><br/>
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
                            <div style="margin-top: 2%;" class="row mb-0">
                                @if($practitioner->practitionerProfessions->isEmpty())
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-center">
                                                    <h4>No Profession Details Found</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif(!$practitioner->practitionerProfessions->isEmpty())

                                    @foreach($practitioner->practitionerProfessions as $practitionerProfession)
                                        <!-- start profession col -->
                                        <div class="col-xxl-6 col-lg-6">
                                            <div class="card border-1 m-4">
                                                <div class="card-header">
                                                    <a href="{{route('practitioner-professions.edit',$practitionerProfession->slug)}}"
                                                       class="float-end fs-11" aria-label="Edit"><i
                                                            class="fa fa-pencil"></i> Edit
                                                    </a>
                                                    <h6 style="font-size: 14px;" class="card-title mb-0">Registration
                                                        number
                                                        <span
                                                            class="text-secondary">#{{$practitionerProfession->registration_number}}</span>
                                                    </h6>
                                                </div>
                                                <div class="card-body">
                                                    <h6 class="card-title text-center">{{$practitionerProfession->profession->name}}</h6>
                                                    <p class="text-muted mb-0 text-center">
                                               <span
                                                   class="badge {{ $practitionerProfession->is_active ? 'bg-success' : 'bg-danger' }} font-size-12">
                                                    <i class="fa {{ $practitionerProfession->is_active ? 'fa-check' : 'fa-times' }}"></i>
                                                    {{ $practitionerProfession->is_active ? 'Active' : 'Inactive' }}
                                               </span>

                                                    </p>
                                                </div>
                                                <div class="card-footer">
                                                    <a style="font-size: 14px;"
                                                       href="{{route('practitioner-professional-qualifications.index',$practitionerProfession->slug)}}"
                                                       class="link-success float-left">
                                                        Qualifications
                                                        <i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                                    </a>

                                                    {{--<a style="font-size: 14px;" href="javascript:void(0);"
                                                       class="link-success float-end">Renewals
                                                        <i class="ri-arrow-right-s-line align-middle ms-1 lh-1"></i>
                                                    </a>--}}

                                                </div>
                                            </div>
                                        </div>
                                        <!-- end col -->
                                    @endforeach
                                @endif
                            </div>
                        </div>


                        <!-- Add Modal -->
                        <div class="modal fade" id="addProfession" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="myModalLabel">Add Profession</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">

                                        <form method="post"
                                              action="{{ route('practitioner-professions.store', $practitioner->slug) }}"
                                              enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <!-- Profession Dropdown -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="profession_id" class="form-label">Profession</label>
                                                        <select class="form-control" id="profession_id"
                                                                name="profession_id">
                                                            <option value="">Select Profession</option>
                                                            @foreach(\App\Models\Profession::all() as $profession)
                                                                <option
                                                                    value="{{$profession->id}}">{{$profession->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <!-- Registration Number Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="registration_number" class="form-label">Registration
                                                            Number</label>
                                                        <input type="text" class="form-control" id="registration_number"
                                                               name="registration_number"
                                                               placeholder="Enter Registration Number">
                                                    </div>
                                                </div>

                                                <!-- Registration Date Input -->
                                                <div class="col-lg-6">
                                                    <div class="mb-3">
                                                        <label for="registration_date" class="form-label">Registration
                                                            Date</label>
                                                        <input type="text" class="form-control datepicker"
                                                               id="registration_date" name="registration_date"
                                                               placeholder="Enter Registration Date">
                                                    </div>
                                                </div>
                                                <!-- Form Submission Buttons -->
                                                <div class="col-lg-12">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="submit" class="btn btn-primary">Submit Profession
                                                            Details
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
            $("#registration_date").datepicker({
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

