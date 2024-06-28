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
                                    href="{{route('renewals.index',$renewal->practitioner->slug)}}"
                                    class="btn btn-success fw-medium">
                                     <i class="fa fa-arrow-left"></i> Back To Renewals
                                 </a>
                                <a style="font-size: 12px; color: white;" href="#"
                                   class="add-button btn btn-primary fw-medium"
                                   data-bs-toggle="modal" data-bs-target="#addProfession">
                                    <i class="fa fa-plus"></i> Update CPD Points
                                </a>

                            </span>
                                <h6 class="card-title mb-0">{{$renewal->practitioner->first_name. ' '. $renewal->practitioner->last_name}}
                                    -
                                    Record {{$renewal->start_date }} to {{ $renewal->end_date }} CPD Points
                                </h6><br/>
                                <table style="width: 100%;" id="buttons-datatables"
                                       class="display table table-bordered dataTable no-footer"
                                       aria-describedby="buttons-datatables_info">
                                    <thead>
                                    <tr>
                                        <th>Period</th>
                                        <th>Points</th>
                                        <th>CPD Booklet</th>
                                        <th>Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($renewal->continuousProfessionalDevelopments as $cpd)
                                        <tr class="even">
                                            <td style="font-weight: normal;">{{$renewal->period}}</td>
                                            <td style="font-weight: normal;">{{$cpd->points}}</td>
                                            <td style="font-weight: normal;">
                                                <a href="{{asset($cpd->file)}}"
                                                   class="btn btn-sm btn-primary" title="Edit"
                                                   target="_blank">
                                                    <i class="fa fa-file"></i> View CPD Booklet
                                                </a>
                                            </td>

                                            <td style="font-weight: normal;">
                                                <!-- Edit Button -->
                                                <a href="#" class="edit-button btn btn-sm btn-primary" title="Edit"
                                                   data-id="{{ $cpd->id }}"
                                                   data-renewal-id="{{ $cpd->renewal_id }}"
                                                   data-points="{{ $cpd->points }}"
                                                   data-file="{{ $cpd->file }}">
                                                    <i class="fa fa-pencil"></i> Edit
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="" method="POST"
                                                      onsubmit="return confirm('Are you sure?');"
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

                </div>
            </div>
            <div class="modal fade" id="addProfession" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel">Record CPD Points</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="{{ route('renewal.cpd.store', $renewal->id) }}"
                                  enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="_method" id="formMethod" value="POST">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="points" class="form-label">Points Obtained</label>
                                            <input type="text" class="form-control" id="points" name="points" required
                                                   placeholder="Enter Points Obtained">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="file" class="form-label">Upload CPD Points file</label>
                                            <input type="file" class="form-control" id="file" name="file" required
                                                   placeholder="Upload">
                                        </div>
                                    </div>
                                    <input type="hidden" name="practitioner_id" value="{{$practitioner->id}}">
                                </div>
                                <button type="submit" class="btn btn-primary">Submit CPD Points</button>
                            </form>
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
        document.addEventListener('DOMContentLoaded', function () {
            // Get all add and edit buttons
            var addButton = document.querySelector('.add-button');
            var editButtons = document.querySelectorAll('.edit-button');

            // Handle add button click
            addButton.addEventListener('click', function (event) {
                event.preventDefault();

                // Set form action URL for add
                var form = document.querySelector('#addProfession form');
                form.action = "{{ route('renewal.cpd.store', $renewal->id) }}";
                document.querySelector('#formMethod').value = 'POST';

                // Clear form fields
                document.querySelector('#addProfession #points').value = '';
                document.querySelector('#addProfession #file').value = '';

                // Open the modal
                var modal = new bootstrap.Modal(document.getElementById('addProfession'));
                modal.show();
            });

            // Handle edit button clicks
            editButtons.forEach(function (button) {
                button.addEventListener('click', function (event) {
                    event.preventDefault();

                    // Get data attributes
                    var id = this.getAttribute('data-id');
                    var renewalId = this.getAttribute('data-renewal-id');
                    var points = this.getAttribute('data-points');
                    var file = this.getAttribute('data-file');

                    // Set form action URL for edit
                    var form = document.querySelector('#addProfession form');
                    form.action = `/renewals/${renewalId}/cpd/${id}/update`;
                    document.querySelector('#formMethod').value = 'PATCH';

                    // Prefill form fields
                    document.querySelector('#addProfession #points').value = points;
                    // Note: You can't prefill a file input for security reasons

                    // Open the modal
                    var modal = new bootstrap.Modal(document.getElementById('addProfession'));
                    modal.show();
                });
            });

            // Ensure modal backdrop is removed when modal is hidden
            $('#addProfession').on('hidden.bs.modal', function () {
                $('.modal-backdrop').remove();
            });
        });
    </script>

@endpush

