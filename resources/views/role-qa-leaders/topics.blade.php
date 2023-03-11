@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Topics management</h4>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#topic-add-modal">Create
                            new topic</button>
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
                                    <th style="position: sticky; left: 0; z-index: 1; background: white">Action</th>

                                    <th>Category</th>
                                    <th>Topic name</th>
                                    <th>Topic Description</th>
                                    <th>First closure date</th>
                                    <th>Final closure date</th>
                                    {{-- <th>Ideas count</th> --}}

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($topics as $topic)
                                    <tr>
                                        <td style="position: sticky; left: 0; z-index: 1; background: white">
                                            <button type="button" class="btn btn-primary btn-sm" id="topic-edit-modal"
                                                data-id="{{ $topic->topic_id }}" data-topicName="{{ $topic->topic_name }}"
                                                data-description="{{ $topic->topic_description }}"
                                                data-firstClosureDate="{{ $topic->firstClosureDate }}"
                                                data-finalClosureDate="{{ $topic->finalClosureDate }}"
                                                data-categoryID="category{{ $topic->category->category_id }}">Edit</button>

                                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                                data-target="#topic-delete-modal">Delete</button>
                                        </td>

                                        <td title="{{ $topic->category->category_name }}"
                                            style="white-space: no-wrap; overflow: hidden; text-overflow:ellipsis; max-width: 150px; line-height: 1.5; text-align: justify">
                                            {{ $topic->category->category_name }}</td>
                                        <td>
                                            {{ $topic->topic_name }}</td>
                                        <td title="{{ $topic->topic_description }}"
                                            style=" white-space: no-wrap; overflow: hidden; text-overflow:ellipsis; max-width: 150px; line-height: 1.5; text-align: justify">
                                            {{ $topic->topic_description }}</td>
                                        <td class="font-weight-bold">
                                            {{ date('M-d-Y h:i:s a', strtotime($topic->firstClosureDate)) }}</td>
                                        <td class="font-weight-bold">
                                            {{ date('M-d-Y h:i:s a', strtotime($topic->finalClosureDate)) }}</td>
                                        {{-- <td class="text-center font-weight-bold">{{ $topic->ideas_count }}</td> --}}

                                    </tr>
                                @endforeach
                                {{-- <tr>
                                    <td>1</td>
                                    <td>Category name</td>
                                    <td>Topic name</td>
                                    <td style=" white-space: normal; line-height: 1.5; text-align: justify">
                                        Lorem ipsum, dolor sit amet consectetur adipisicing elit. Voluptatibus ipsam
                                        recusandae beatae accusantium quibusdam temporibus ab repellendus natus ut tempora,
                                        qui minus dicta dolor quo? Ab beatae fugit necessitatibus porro!</td>
                                    <td class="text-center font-weight-bold">March 20, 2023</td>
                                    <td class="text-center font-weight-bold">March 20, 2023</td>
                                    <td class="text-center font-weight-bold">100</td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#topic-edit-modal">Edit</button>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                            data-target="#topic-delete-modal">Delete</button>
                                    </td>
                                </tr> --}}
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-center align-items-center">
                            {{ $topics->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- NOTE: Add topic modal --}}
    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="topic-add-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-sample" method="POST" action="{{ route('qa-leaders.topics.store') }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Category name</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="category" id="category"
                                                        style="color: black">
                                                        <option value="" selected>
                                                            ---Choose a category---
                                                        </option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->category_id }}">
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">First closure date</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" id="firstClosureDate"
                                                        name="firstClosureDate" class="form-control"
                                                        value="{{ old('firstClosureDate') }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Topic name</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="topicName"
                                                        id="topicName" value="{{ old('topicName') }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Final closure date</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="datetime-local"
                                                        name="finalClosureDate" id="finalClosureDate"
                                                        value="{{ old('finalClosureDate') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Topic description</label>
                                                <div class="col-sm-9">
                                                    <textarea name="description" id="description" value="{{ old('description') }}" class="form-control" cols="30"
                                                        rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <button type="submit" class="btn btn-primary mr-2">Create the
                                                    topic</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
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


    {{-- NOTE: Edit topic modal --}}

    <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true" id="topic-update-modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Update topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="col-12 grid-margin">
                        <div class="card">
                            <div class="card-body">
                                <form class="form-sample" id="form-update-topic" method="POST" action="">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Category name</label>
                                                <div class="col-sm-9">
                                                    <select class="form-control" name="category" id="category_edit"
                                                        style="color: black">
                                                        <option value="" selected>
                                                            ---Choose a category---
                                                        </option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->category_id }}"
                                                                id="category{{ $category->category_id }}">
                                                                {{ $category->category_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">First closure date</label>
                                                <div class="col-sm-9">
                                                    <input type="datetime-local" id="firstClosureDate_edit"
                                                        name="firstClosureDate" class="form-control"
                                                        value="{{ old('firstClosureDate') }}">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Topic name</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="text" name="topicName"
                                                        id="topicName_edit" value="{{ old('topicName') }}" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Final closure date</label>
                                                <div class="col-sm-9">
                                                    <input class="form-control" type="datetime-local"
                                                        name="finalClosureDate" id="finalClosureDate_edit"
                                                        value="{{ old('finalClosureDate') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Topic description</label>
                                                <div class="col-sm-9">
                                                    <textarea name="description" id="description_edit" value="{{ old('description') }}" class="form-control"
                                                        cols="30" rows="10"></textarea>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label"></label>
                                                <button type="submit" class="btn btn-primary mr-2">Update the
                                                    topic</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
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



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //NOTE: passing value to update house modal
            var editTopicBtn = document.querySelectorAll('#topic-edit-modal');
            editTopicBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var topicID = e.getAttribute('data-id');
                    var topicName = e.getAttribute('data-topicName');
                    var description = e.getAttribute('data-description');
                    var firstClosureDate = e.getAttribute('data-firstClosureDate');
                    var finalClosureDate = e.getAttribute('data-finalClosureDate');
                    var categoryID = e.getAttribute('data-categoryID');

                    var inputTopicName = document.getElementById('topicName_edit');
                    var inputDescription = document.getElementById('description_edit');
                    var inputFirstClosureDate = document.getElementById('firstClosureDate_edit');
                    var inputFinalClosureDate = document.getElementById('finalClosureDate_edit');

                    inputTopicName.value = topicName;
                    inputDescription.value = description;
                    inputFirstClosureDate.value = firstClosureDate;
                    inputFinalClosureDate.value = finalClosureDate;

                    document.getElementById(categoryID).selected = true;

                    var formUpdateTopic = document.getElementById('form-update-topic');
                    formUpdateTopic.action = "{{ route('qa-leaders.topics.update', ':id') }}"
                        .replace(':id', topicID);


                    // console.log(userID + fullName + email + deptID + roleID)
                    $('#topic-update-modal').modal('show');
                });
            });
        });
    </script>


@endsection
