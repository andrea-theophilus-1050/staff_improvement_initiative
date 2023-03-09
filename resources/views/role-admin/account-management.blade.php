@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div style="display: flex; justify-content: space-between; align-items:center">
                        <h4 class="card-title">Account management</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#account-add-modal">Add
                            new account</button>
                    </div>
                    <div class="table-responsive">

                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show col-md-5" role="alert">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show col-md-5" role="alert">
                                <strong>Error!</strong> {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif(session('success'))
                            <div class="alert alert-success alert-dismissible fade show col-md-5" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fullname</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $account->fullName }}</td>
                                        <td>{{ $account->email }}</td>
                                        <td>{{ $account->role->role_name }}</td>
                                        <td>{{ $account->department->dept_name }}</td>
                                        <td class="d-flex">
                                            <button type="button" class="btn btn-primary btn-sm" id="btn-edit-account"
                                                data-ID="{{ $account->user_id }}" data-fullName="{{ $account->fullName }}"
                                                data-email="{{ $account->email }}" data-role="role{{ $account->role_id }}"
                                                data-dept="dept{{ $account->dept_id }}">Edit</button>
                                            <form action="{{ route('account.delete', $account->user_id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure to delete account?')">Delete</button>
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

    {{-- SECTION-START: Add new account modal start --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="account-add-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-sample" id="form-add-account" method="POST"
                                    action="{{ route('account.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Full name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="fullname"
                                                        value="{{ old('fullname') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="email"
                                                        value="{{ old('email') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Department</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="department" style="color: black">
                                                        <option value="" selected>
                                                            ---Choose a department---
                                                        </option>
                                                        @foreach ($depts as $dept)
                                                            <option value="{{ $dept->dept_id }}">
                                                                {{ $dept->dept_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="password"
                                                        value="{{ old('password') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Account role</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="role" style="color: black">
                                                        <option value="" selected>
                                                            ---Choose account role---
                                                        </option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->role_id }}">
                                                                {{ $role->role_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Create account</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit()">Create account</button>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- SECTION-END: Add new account modal end --}}

    {{-- SECTION-START: Update account modal start --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="account-update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update account</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-sample" id="form-update-account" method="POST"
                                    action="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Full name</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="fullname"
                                                        id="fullname_edit" value="{{ old('fullname') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Email</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="form-control" name="email"
                                                        id="email_edit" value="{{ old('email') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Department</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="department" id="department_edit"
                                                        style="color: black">
                                                        <option value="" selected>
                                                            ---Choose a department---
                                                        </option>
                                                        @foreach ($depts as $dept)
                                                            <option value="{{ $dept->dept_id }}"
                                                                id="dept{{ $dept->dept_id }}">
                                                                {{ $dept->dept_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Password</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="password"
                                                        value="{{ old('password') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Account role</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="role" id="role_edit"
                                                        style="color: black">
                                                        <option value="" selected>
                                                            ---Choose account role---
                                                        </option>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->role_id }}"
                                                                id="role{{ $role->role_id }}">
                                                                {{ $role->role_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <button type="submit" class="btn btn-primary">Update account</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                {{-- <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="submit()">Create account</button>
                </div> --}}
            </div>
        </div>
    </div>
    {{-- SECTION-END: Update account modal end --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //NOTE: passing value to update house modal
            var editAccountBtn = document.querySelectorAll('#btn-edit-account');
            editAccountBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var userID = e.getAttribute('data-ID');
                    var fullName = e.getAttribute('data-fullName');
                    var email = e.getAttribute('data-email');
                    var deptID = e.getAttribute('data-dept');
                    var roleID = e.getAttribute('data-role');

                    var inputFullName = document.getElementById('fullname_edit');
                    var inputEmail = document.getElementById('email_edit');
                    var selectDept = document.getElementById('department_edit');
                    var selectRole = document.getElementById('role_edit');

                    inputFullName.value = fullName;
                    inputEmail.value = email;
                    document.getElementById(deptID).selected = true;
                    document.getElementById(roleID).selected = true;

                    var formUpdateAccount = document.getElementById('form-update-account');
                    formUpdateAccount.action = "{{ route('account.update', ':id') }}"
                        .replace(':id', userID);
                    

                    // console.log(userID + fullName + email + deptID + roleID)
                    $('#account-update-modal').modal('show');
                });
            });
        });
    </script>
@endsection
