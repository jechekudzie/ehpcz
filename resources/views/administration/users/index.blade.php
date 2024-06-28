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
                        <h4 class="mb-sm-0" id="page-title">System Users</h4>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">System Users</li>
                            </ol>
                        </div>
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
                                    <button id="new-button" class="btn btn-success btn-sm add-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">
                                        <i class="fa fa-plus"></i> Add New User
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <!-- Alerts for Messages -->
                            @if(session()->has('errors'))
                                @if($errors->any())
                                    @foreach($errors->all() as $error)
                                        <!-- Error Alert -->
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> Errors! </strong> {{ $error }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                    @endforeach
                                @endif
                            @endif

                            @if(session('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Message!</strong> {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif

                            <!--start table-->
                            <table style="width: 100%;" id="buttons-datatables" class="display table table-bordered dataTable no-footer" aria-describedby="buttons-datatables_info">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Roles</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            @foreach($user->roles as $role)
                                                <span class="badge bg-secondary">{{ $role->name }}</span>
                                            @endforeach
                                        </td>
                                        <td>
                                            <!-- Edit Button -->
                                            <a href="javascript:void(0);" class="edit-button btn btn-sm btn-primary"
                                               data-id="{{ $user->id }}"  data-slug="{{ $user->slug }}" data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                               data-roles="{{ $user->roles->pluck('name')->implode(', ') }}" title="Edit">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                            <!-- Delete Form -->
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');" style="display: inline-block;">
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
                            <!--end table-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add User Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">Add New User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm" method="post" action="{{ route('admin.users.store') }}">
                        @csrf
                        <input type="hidden" name="_method" value="POST">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select class="form-control" id="role" name="role" required>
                                <option value="">Select Role</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

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
        document.addEventListener("DOMContentLoaded", function () {
            $('#buttons-datatables').DataTable({
                dom: 'Bfrtip',
                buttons: ['copy', 'csv', 'excel', 'print', 'pdf']
            });
        });

        // JavaScript for handling modal and form
        document.addEventListener('DOMContentLoaded', function () {
            var addUserModal = new bootstrap.Modal(document.getElementById('addUserModal'));

            document.querySelectorAll('.edit-button').forEach(function (button) {
                button.addEventListener('click', function () {
                    var userId = this.getAttribute('data-id');
                    var userSlug = this.getAttribute('data-slug');
                    var userName = this.getAttribute('data-name');
                    var userEmail = this.getAttribute('data-email');
                    var userRoles = this.getAttribute('data-roles').split(', ');

                    // Populate the form with user data
                    document.getElementById('name').value = userName;
                    document.getElementById('email').value = userEmail;
                    document.getElementById('password').value = ''; // Clear password field

                    // Select roles in dropdown
                    var roleSelect = document.getElementById('role');
                    Array.from(roleSelect.options).forEach(function (option) {
                        option.selected = userRoles.includes(option.value);
                    });

                    // Change form action to update user
                    var form = document.getElementById('userForm');
                    form.action = '/admin/users/' + userSlug + '/update';
                    form.method = 'POST';
                    form.querySelector('input[name="_method"]').value = 'PATCH';

                    // Change button text to Update User
                    form.querySelector('button[type="submit"]').textContent = 'Update User';

                    // Show the modal
                    addUserModal.show();
                });
            });

            // Reset form when modal is closed
            document.getElementById('addUserModal').addEventListener('hidden.bs.modal', function () {
                var form = document.getElementById('userForm');
                form.reset();
                form.action = '{{ route('admin.users.store') }}';
                form.querySelector('input[name="_method"]').value = 'POST';
                form.querySelector('button[type="submit"]').textContent = 'Add User';
            });
        });
    </script>
@endpush
