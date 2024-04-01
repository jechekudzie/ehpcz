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
    <div class="col-xxl-12">
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
                                    href="{{route('practitioner-professional-qualifications.index',$professionalQualification->practitionerProfession->slug)}}"
                                    class="btn btn-success fw-medium">
                                     <i class="fa fa-arrow-left"></i> Back To Qualifications
                                 </a>

                            </span>
                                <h6 class="card-title mb-0">{{$professionalQualification->practitionerProfession->profession->name}}
                                    - {{$professionalQualification->qualificationCategory->id == 1 ? $professionalQualification->qualification->name : $professionalQualification->qualification_name}}</h6>
                                <br/>
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th class="sorting sorting_asc" tabindex="0"
                                            aria-controls="buttons-datatables" rowspan="1" colspan="1"
                                            aria-sort="ascending"
                                            aria-label="Name: activate to sort column descending"
                                        >#
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                        >Required Document
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                            >File
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                        >Status
                                        </th>
                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Position: activate to sort column ascending"
                                        >Upload File
                                        </th>

                                        <th class="sorting" tabindex="0" aria-controls="buttons-datatables"
                                            rowspan="1" colspan="1"
                                            aria-label="Salary: activate to sort column ascending"
                                            >Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($qualificationFiles as $qualificationFile)
                                        <tr class="even">
                                            <td class="sorting_1">{{$loop->iteration}}</td>
                                            <td style="font-weight: normal;">{{$qualificationFile->requirement->name}}</td>
                                            <!-- Check if the qualification category is 'Local' or 'Foreign' and display accordingly -->
                                            <td style="font-weight: normal;">
                                                @if($qualificationFile->file)
                                                    <a href="{{asset($qualificationFile->file)}}"
                                                       target="_blank" class="btn btn-success btn-sm">
                                                        View {{$qualificationFile->requirement->name}} <i style="font-size: 15px;" class="fa fa-file-text-o  me-2 text-black"> </i>

                                                    </a>
                                                @else
                                                    <span class="btn btn-danger btn-sm">No {{$qualificationFile->requirement->name}} Uploaded</span>
                                                @endif
                                            </td>
                                            <td style="font-weight: normal;">
                                                @if($qualificationFile->status == 1)
                                                    <span class="btn btn-success btn-sm">Approved</span>
                                                @else
                                                    <span class="btn btn-warning btn-sm">Pending</span>
                                                @endif
                                            </td>
                                            <td style="font-weight: normal;">
                                                <a class="dropdown-item upload-requirement"
                                                   href="#"
                                                   data-id="{{ $qualificationFile->id }}"
                                                   data-requirement-id="{{ $qualificationFile->requirement->id }}"
                                                   data-requirement-name="{{ $qualificationFile->requirement->name }}"
                                                   data-bs-toggle="modal"
                                                   data-bs-target="#editDocument">
                                                    <i class="fa fa-upload align-bottom me-2 text-black"></i>
                                                    Upload New {{$qualificationFile->requirement->name}}
                                                </a>
                                            </td>

                                            <td style="font-weight: normal;">
                                                <!-- Delete Button -->
                                                <form
                                                    action="{{ route('practitioner-professional-qualifications.files.destroy', $professionalQualification->slug) }}"
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
                                <!-- Edit Document Modal -->
                                <div class="modal fade" id="editDocument" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="requirement_name">Upload </h5>
                                            </div>
                                            <!-- Warning Alert -->
                                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                <p style="font-weight: normal;"> Please! Make sure your file is either in PDF, PNG, JPEG,
                                                JPG, or GIF format. The maximum file size is 2MB.</p>
                                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post"
                                                      action="{{route('practitioner-professional-qualifications.files.update',$professionalQualification->slug)}}"
                                                      enctype="multipart/form-data">
                                                    @method('PATCH')
                                                    @csrf
                                                    <div class="row">
                                                        <!-- Title Dropdown -->
                                                        <!-- First Name Input -->
                                                        <input type="hidden" id="qualification_file_id" name="id">

                                                        <!-- Middle Name Input -->
                                                        <div class="col-lg-8">
                                                            <div class="mb-3">
                                                                <label for="identification_file" class="form-label">Upload
                                                                    Document</label>
                                                                <input type="file" class="form-control" id="file" name="file"
                                                                       placeholder="Upload file">
                                                            </div>
                                                        </div>

                                                        <!-- Form Submission Buttons -->
                                                        <div class="col-lg-12">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success">
                                                                    Submit Upload
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
                                <!--end modal-->
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
        document.addEventListener('DOMContentLoaded', function () {
            // When an edit link is clicked
            document.querySelectorAll('.upload-requirement').forEach(function (element) {
                element.addEventListener('click', function () {
                    var id = this.getAttribute('data-id'); //id for the requirement file
                    var requirement_id = this.getAttribute('data-requirement-id');
                    var requirement_name = this.getAttribute('data-requirement-name');

                    // Select form elements and populate them
                    var modal = document.querySelector('#editDocument');
                    modal.querySelector('#requirement_name').textContent = 'Upload ' + requirement_name;
                    modal.querySelector('#qualification_file_id').value = id;
                });
            });
        });
    </script>

@endpush

