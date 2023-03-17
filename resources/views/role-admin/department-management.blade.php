@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Department management</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-dept">Add
                            new department</button>
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
                                    <th>Department name</th>
                                    <th>Account count</th>
                                    {{-- <th>Role</th>
                                    <th>Department</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($depts as $dept)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $dept->dept_name }}</td>
                                        <td>
                                            {{ collect($accounts)->where('dept_id', $dept->dept_id)->count() }}
                                        </td>
                                        {{-- <td>{{ $account->email }}</td>
                                        <td>{{ $account->role->role_name }}</td>
                                        <td>{{ $account->department->dept_name }}</td> --}}
                                        <td class="d-flex">
                                            <button type="button" class="btn btn-primary btn-sm mr-1" id="btn-edit-dept"
                                                data-ID="{{ $dept->dept_id }}"
                                                data-deptName="{{ $dept->dept_name }}">Edit</button>
                                            @if (collect($accounts)->where('dept_id', $dept->dept_id)->count() == 0)
                                                <form action="{{ route('admin.department.delete', $dept->dept_id) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure to delete this department?')">Delete</button>
                                                </form>
                                            @endif
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

    {{-- SECTION-START: modal add department --}}
    <div class="modal fade" id="modal-add-dept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('admin.department.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Department name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="department"
                                            value="{{ old('department') }}" required/>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-">
                                <button type="submit" class="btn btn-primary">Add department</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- SECTION-END: modal add department --}}

    {{-- SECTION-START: modal update department --}}
    <div class="modal fade" id="modal-update-dept" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update department</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-update-dept">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Department name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="department" id="dept-name"
                                            value="{{ old('department') }}" required/>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-">
                                <button type="submit" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- SECTION-END: modal update department --}}

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //NOTE: passing value to update house modal
            var editDeptBtn = document.querySelectorAll('#btn-edit-dept');
            editDeptBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var id = e.getAttribute('data-ID');
                    var deptName = e.getAttribute('data-deptName');

                    var inputDeptName = document.getElementById('dept-name');
                    inputDeptName.value = deptName;


                    var formUpdateAccount = document.getElementById('form-update-dept');
                    formUpdateAccount.action = "{{ route('admin.department.update', ':id') }}"
                        .replace(':id', id);


                    // console.log(userID + fullName + email + deptID + roleID)
                    $('#modal-update-dept').modal('show');
                });
            });
        });
    </script>
@endsection
