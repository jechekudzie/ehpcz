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

            <div class="card-body p-4" style="font-weight: bold;color: black;!important;">
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
                                 <a style="font-size: 12px; color: white;"
                                    href="{{route('practitioner-professions.index',$practitioner->slug)}}"
                                    class="btn btn-success fw-medium">
                                     <i class="fa fa-arrow-left"></i> Back To Professions
                                 </a>
                                <a style="font-size: 12px; color: white;" href="#" class="btn btn-primary fw-medium"
                                   data-bs-toggle="modal" data-bs-target="#addProfession">
                                    <i class="fa fa-plus"></i> Record Renewal & Registration Payments
                                </a>


                            </span>
                                <h6 class="card-title mb-0">{{$practitioner->first_name. ' '. $practitioner->last_name}}
                                    Renewals
                                </h6><br/>
                                <table {{--style="width: 100%;"--}} id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Duration</th>
                                        <th>Practitioner Profession</th>
                                        <th>Balances
                                        <th>Approval</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($practitioner->renewals as $renewal)
                                        <tr class="even">
                                            <td style="font-weight: normal;">{{$renewal->period}}</td>
                                            <td>
                                                <div style="display: flex; justify-content: space-between;">
                                                    <div class="alert alert-success"
                                                         style="flex: 1; margin-right: 10px;">{{$renewal->start_date}}</div>
                                                    <div class="alert alert-danger"
                                                         style="flex: 1;">{{$renewal->end_date}}</div>
                                                </div>
                                            </td>

                                            <td style="font-weight: normal;">{{$renewal->practitionerProfession->profession->name}}</td>
                                            <td style="font-weight: normal;">{{$renewal->payments->sum('balance')}}</td>

                                            <td style="font-weight: normal;">
                                                <a href=""
                                                   class="btn btn-sm btn-block btn-outline-primary d-flex justify-content-between align-items-center"
                                                   title="Edit">
                                                    <div style="text-align: center;">
                                                        <i class="fa fa-check text-success"></i> or <i
                                                            class="fa fa-times text-danger"></i>
                                                    </div>
                                                </a>
                                            <td>

                                                <!-- renewal certificates -->
                                                <a href="{{route('renewal.certificate.show',$renewal->id)}}"
                                                   class="edit-button" title="Certificates" target="_blank">
                                                    Certificates <i style="font-size: 15px;"
                                                                    class="fa fa-certificate"></i>
                                                </a>
                                                |
                                                <!-- Payments Button -->
                                                <a href="{{route('renewal.cpd.index',$renewal->id)}}"
                                                   class="edit-button" title="Payments">
                                                    CPD Points <i style="font-size: 15px;"
                                                                  class="fa fa-graduation-cap"></i>
                                                </a>
                                                |
                                                <!-- Payments Button -->
                                                <a href="{{route('renewal.payments.index',$renewal->id)}}"
                                                   class="edit-button" title="Payments">
                                                    Payments <i style="font-size: 15px;" class="fa fa-money"></i>
                                                </a>

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
                                    <h5 class="modal-title" id="myModalLabel">Record Payments</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <form method="post" action="{{ route('renewals.store',$practitioner->slug) }}"
                                          enctype="multipart/form-data">
                                        @csrf

                                        <div class="row">
                                            <!-- Period Input -->
                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="period" class="form-label">Period</label>
                                                    <select class="form-control" id="period" name="period" required>
                                                        <option value="">Select Period</option>
                                                        @php
                                                            $currentYear = now()->year;
                                                            $startYear = $currentYear - 5;
                                                            $endYear = $currentYear + 2;
                                                        @endphp

                                                        @for ($year = $startYear; $year <= $endYear; $year++)
                                                            <option value="{{ $year }}">{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-lg-12">
                                                <div class="mb-3">
                                                    <label for="practitioner_profession_id" class="form-label">Practitioner
                                                        Profession</label>
                                                    <select class="form-control" id="practitioner_profession_id"
                                                            name="practitioner_profession_id" required>
                                                        <option value="">Select Profession</option>

                                                        @foreach($practitioner->practitionerProfessions as $practitionerProfession)
                                                            <option
                                                                value="{{ $practitionerProfession->id }}">{{ $practitionerProfession->profession->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Form Submission Buttons -->
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="submit" class="btn btn-primary">Submit Renewal Details
                                            </button>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancel
                                            </button>
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

