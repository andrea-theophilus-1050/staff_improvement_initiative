@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Category management</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-dept">Add
                            new category</button>
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
                                    <th>Category name</th>
                                    <th>Description</th>
                                    <th>Topics used count</th>
                                    {{-- <th>Role</th>
                                    <th>Department</th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                    <tr></tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $category->category_name }}</td>
                                    <td style=" white-space: normal; line-height: 1.5; text-align: justify">
                                        {{ $category->description }}
                                    </td>
                                    <td class="text-center font-weight-bold">{{ collect($category->topics)->count() }}</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" id="btn-edit-category"
                                            data-toggle="modal" data-target="#modal-update-dept"
                                            data-category-id="{{ $category->category_id }}"
                                            data-category-name="{{ $category->category_name }}"
                                            data-description="{{ $category->description }}">Edit</button>
                                        @if (collect($category->topics)->count() == 0)
                                            <form
                                                action="{{ route('qa-leaders.category.delete', $category->category_id) }}"
                                                method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Are you sure to delete?')">Delete</button>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add new category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('qa-leaders.category.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Category name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="categoryName" id="categoryName"
                                            value="{{ old('categoryName') }}" required/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6"></div>
                            <div class="col-md-">
                                <button type="submit" class="btn btn-primary">Add category</button>
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
    <div class="modal fade" id="modal-update-category" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="" id="form-update-category">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Category name</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="categoryName"
                                            id="categoryName_edit" value="{{ old('categoryName') }}" required/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Description</label>
                                    <div class="col-sm-8">
                                        <textarea class="form-control" name="description" id="description_edit" cols="30" rows="10"></textarea>
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
            var editCategoryBtn = document.querySelectorAll('#btn-edit-category');
            editCategoryBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var id = e.getAttribute('data-category-id');
                    var categoryName = e.getAttribute('data-category-name');
                    var description = e.getAttribute('data-description');

                    var inputCategoryName = document.getElementById('categoryName_edit');
                    var inputDescription = document.getElementById('description_edit');
                    inputCategoryName.value = categoryName;
                    inputDescription.value = description;


                    var formUpdateCategory = document.getElementById('form-update-category');
                    formUpdateCategory.action = "{{ route('qa-leaders.category.update', ':id') }}"
                        .replace(':id', id);


                    // console.log(userID + fullName + email + deptID + roleID)
                    $('#modal-update-category').modal('show');
                });
            });
        });
    </script>
@endsection
