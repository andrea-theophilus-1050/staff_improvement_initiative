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
                </div>
            </div>
        </div>
    </div>

    @if ($nonDeadline_topics->count() > 0)
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="card-title" style="text-transform: none">Topics that have not been set deadlines</h4>
                            <button type="button" data-toggle="modal" data-target="#topic-deadline-modal"
                                class="btn btn-primary" id="assignBtn" disabled>Assign deadline</button>
                        </div>
                        <div class="table-responsive">
                            <table class="table" id="nonDeadlineTopic_table">
                                <thead>
                                    <tr>
                                        <th style="width: 100px">Action</th>
                                        <th></th>
                                        <th hidden>Topic ID</th>
                                        <th>Topic name</th>
                                        <th>Topic Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($nonDeadline_topics as $topic)
                                        <tr data-href="{{ route('qa-leaders.idea.posts', $topic->topic_id) }}">
                                            <td>
                                                <form method="POST"
                                                    action="{{ route('qa-leaders.delete.topic', $topic->topic_id) }}">
                                                    @csrf
                                                    <button type="submit" type="button" class="btn btn-danger btn-sm"
                                                        onclick="return confirm('Are you sure to delete this topic?')">Delete</button>
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        id="topic-edit-modal" data-id="{{ $topic->topic_id }}"
                                                        data-topicName="{{ $topic->topic_name }}"
                                                        data-description="{{ $topic->topic_description }}">Edit</button>
                                                </form>
                                            </td>
                                            <td>
                                                <input type="checkbox" class="form-control" style="width: 20px"
                                                    id="checkbox{{ $topic->topic_id }}">
                                            </td>
                                            <td hidden>{{ $topic->topic_id }}</td>
                                            <td>{{ $topic->topic_name }}</td>
                                            <td title="{{ $topic->topic_description }}"
                                                style=" white-space: no-wrap; overflow: hidden; text-overflow:ellipsis; max-width: 300px; line-height: 1.5; text-align: justify">
                                                {{ $topic->topic_description }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @foreach ($deadlines as $topicDeadline)
        @if ($topicDeadline->topics->count() > 0)
            {{-- @php
                $now = \Carbon\Carbon::now();
                $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topicDeadline->firstClosureDate)));
                $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topicDeadline->finalClosureDate)));
                $diffFirstClosureDate = $now->diff($deadline1, false);
                $diffFinalClosureDate = $now->diff($deadline2, false);
            @endphp --}}
            @php
                $now = \Carbon\Carbon::now();
                $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topicDeadline->firstClosureDate)));
                $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($topicDeadline->finalClosureDate)));
                
                $diffFirstClosureDate = $deadline1->diffForHumans($now, [
                    'parts' => 2,
                    'join' => true,
                    'short' => false,
                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                ]);
                
                $diffFinalClosureDate = $deadline2->diffForHumans($now, [
                    'parts' => 2,
                    'join' => true,
                    'short' => false,
                    'syntax' => \Carbon\CarbonInterface::DIFF_ABSOLUTE,
                ]);
            @endphp

            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="ml-3">
                                        <li class="mb-1"style="font-weight: normal; text-transform:none">
                                            Deadline for idea submition: &nbsp;
                                            <b>
                                                {{ date('F d, Y - h:i A', strtotime($topicDeadline->firstClosureDate)) }}

                                                @if ($deadline1->isPast())
                                                    <span class="badge badge-warning">The deadline has passed</span>
                                                @else
                                                    <span class="badge badge-info">{{ $diffFirstClosureDate }} left</span>
                                                @endif

                                            </b>
                                        </li>

                                        <li class="mb-2" style="font-weight: normal; text-transform:none">
                                            Deadline to close comments: &nbsp;
                                            <b>
                                                {{ date('F d, Y - h:i A', strtotime($topicDeadline->finalClosureDate)) }}

                                                @if ($deadline2->isPast())
                                                    <span class="badge badge-warning">The deadline has passed</span>
                                                @else
                                                    <span class="badge badge-info">{{ $diffFinalClosureDate }} left</span>
                                                @endif
                                            </b>
                                        </li>
                                    </div>

                                    <div>
                                        <button type="button" class="btn btn-primary btn-icon-text btn-sm"
                                            id="edit-deadline-btn" data-id="{{ $topicDeadline->deadline_id }}"
                                            data-firstClosureDate="{{ $topicDeadline->firstClosureDate }}"
                                            data-finalClosureDate="{{ $topicDeadline->finalClosureDate }}">
                                            <i class="ti-pencil btn-icon-append mr-2"></i>Change deadline</button>
                                    </div>
                                </div>
                                <table class="table table-hover table-bordered" id="topic-table">
                                    <thead>
                                        <tr>
                                            <th style="width: 100px">Action</th>
                                            <th class="text-center" style="width: 100px">Status</th>
                                            <th>Topic name</th>
                                            <th>Topic Description</th>
                                            <th class="text-center" style="width: 80px">Ideas count</th>
                                            {{-- <th>Deadline for idea submission</th>
                                            <th>Deadline for close comments</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($topicDeadline->topics as $topic)
                                            <tr data-href="{{ route('qa-leaders.idea.posts', $topic->topic_id) }}">
                                                <td style="width: 100px">
                                                    <form method="POST"
                                                        action="{{ route('qa-leaders.delete.topic', $topic->topic_id) }}">
                                                        @csrf
                                                        @if ($topic->ideaPosts->count() == 0)
                                                            <button type="submit" type="button"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Are you sure to delete this topic?')">Delete</button>
                                                        @endif

                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            id="topic-edit-btn" data-id="{{ $topic->topic_id }}"
                                                            data-topicName="{{ $topic->topic_name }}"
                                                            data-description="{{ $topic->topic_description }}"
                                                            data-firstClosureDate="{{ $topic->topicDeadline->firstClosureDate }}"
                                                            data-finalClosureDate="{{ $topic->topicDeadline->finalClosureDate }}">Edit</button>
                                                    </form>
                                                </td>

                                                <td class="text-center font-weight-bold">
                                                    @if (date('M-d-Y h:i:s a') > date('M-d-Y h:i:s a', strtotime($topic->topicDeadline->firstClosureDate)))
                                                        @if (date('M-d-Y h:i:s a') > date('M-d-Y h:i:s a', strtotime($topic->topicDeadline->finalClosureDate)))
                                                            <span
                                                                class="badge badge-danger text-black font-weight-bold">Completely
                                                                closed</span>
                                                        @else
                                                            <span class="badge badge-danger font-weight-bold">Closed
                                                                submision</span>
                                                        @endif
                                                    @else
                                                        <span class="badge badge-success">Opening</span>
                                                    @endif
                                                </td>
                                                <td>{{ $topic->topic_name }}</td>
                                                <td title="{{ $topic->topic_description }}"
                                                    style=" white-space: no-wrap; overflow: hidden; text-overflow:ellipsis; max-width: 150px; line-height: 1.5; text-align: justify">
                                                    {{ $topic->topic_description }}</td>
                                                <td class="text-center font-weight-bold">{{ $topic->ideaPosts->count() }}
                                                </td>
                                                {{-- <td>{{ date('F d, Y - h:i A', strtotime($topic->topicDeadline->firstClosureDate)) }}
                                                </td>
                                                <td>{{ date('F d, Y - h:i A', strtotime($topic->topicDeadline->finalClosureDate)) }}
                                                </td> --}}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
    {{-- <div class="d-flex justify-content-center align-items-center">
        {{ $deadlines->links() }}
    </div> --}}

    {{-- NOTE: Add topic modal --}}
    <div class="modal fade" id="topic-add-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create new topic</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('qa-leaders.topics.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Topic name</label>
                                    <div class="col-sm-8">
                                        <input class="form-control" type="text" name="topicName" id="topicName"
                                            value="{{ old('topicName') }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label">Topic description</label>
                                    <div class="col-sm-8">
                                        <textarea name="description" id="description" class="form-control" cols="30" rows="10"
                                            style="line-height: 1.5">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row modal-footer">
                            <button type="submit" class="btn btn-primary">Create the topic</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="topic-deadline-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Assign deadline to topics</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('qa-leaders.assign.deadline.topic') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">First closure
                                        date</label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" id="firstClosureDate" name="firstClosureDate"
                                            class="form-control" value="{{ old('firstClosureDate') }}" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Final closure
                                        date</label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" id="finalClosureDate" name="finalClosureDate"
                                            class="form-control" value="{{ old('finalClosureDate') }}" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Topics</label>
                                    <div class="col-sm-7" id="section_topicID">
                                        {{-- Topic ID - hidden --}}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row modal-footer">
                            <button type="submit" class="btn btn-primary">Assign</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    {{-- NOTE: edit deadline modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true"
        id="edit-deadline-modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change deadline</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="formEditDeadline" method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">First closure
                                        date</label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" id="firstDeadline_edit" name="firstClosureDate"
                                            class="form-control" value="{{ old('firstClosureDate') }}" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group row">
                                    <label class="col-sm-5 col-form-label">Final closure
                                        date</label>
                                    <div class="col-sm-7">
                                        <input type="datetime-local" id="finalDeadline_edit" name="finalClosureDate"
                                            class="form-control" value="{{ old('finalClosureDate') }}" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row modal-footer">
                            <button type="submit" class="btn btn-primary">Change</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
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
                    <form class="form-sample" id="form-update-topic" method="POST" action="">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Topic
                                        name</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="text" name="topicName" id="topicName_edit"
                                            value="{{ old('topicName') }}" required />
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">First closure
                                        date</label>
                                    <div class="col-sm-9">
                                        <input type="datetime-local" id="firstClosureDate_edit" name="firstClosureDate"
                                            class="form-control" value="{{ old('firstClosureDate') }}" required>

                                    </div>
                                </div>
                            </div>


                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Topic
                                        description</label>
                                    <div class="col-sm-9">
                                        <textarea name="description" id="description_edit" value="{{ old('description') }}" class="form-control"
                                            cols="30" rows="10" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Final closure
                                        date</label>
                                    <div class="col-sm-9">
                                        <input class="form-control" type="datetime-local" name="finalClosureDate"
                                            id="finalClosureDate_edit" value="{{ old('finalClosureDate') }}" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row modal-footer">
                            <button type="submit" class="btn btn-primary">Update topic</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // NOTE: check there is at least one checkbox checked to enable assign button
        const checkboxes = document.querySelectorAll('#nonDeadlineTopic_table input[type="checkbox"]');
        const assignBtn = document.querySelector('#assignBtn');


        function checkboxAssignButton() {
            const checked = Array.from(checkboxes).some(checkbox => checkbox.checked);
            assignBtn.disabled = !checked;
        }

        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('click', checkboxAssignButton);
        });

        assignBtn.addEventListener('click', () => {
            const sectionTopicID = document.getElementById('section_topicID');
            sectionTopicID.innerHTML = '';

            Array.from(checkboxes).forEach(checkbox => {
                if (checkbox.checked) {
                    const row = checkbox.closest('tr');
                    const topicID = row.querySelector('td:nth-child(3)').innerText;
                    const topicName = row.querySelector('td:nth-child(4)').innerText;

                    sectionTopicID.innerHTML += `<input type="hidden" name="topicID[]" value="${topicID}"> 
                                                <li style="word-break: break-all">${topicName}</li>`;

                }
            });

            $('#topic-deadline-modal').modal('show');
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            //NOTE: passing value to update house modal
            var editDeadlineBtn = document.querySelectorAll('#edit-deadline-btn');
            editDeadlineBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var id = e.getAttribute('data-id');
                    var firstClosureDate = e.getAttribute('data-firstClosureDate');
                    var finalClosureDate = e.getAttribute('data-finalClosureDate');

                    var inputFirstClosureDate = document.getElementById('firstDeadline_edit');
                    var inputFinalClosureDate = document.getElementById('finalDeadline_edit');

                    inputFirstClosureDate.value = firstClosureDate;
                    inputFinalClosureDate.value = finalClosureDate;

                    var formUpdateDeadline = document.getElementById('formEditDeadline');
                    formUpdateDeadline.action = "{{ route('qa-leaders.update.deadline', ':id') }}"
                        .replace(':id', id);


                    // console.log(userID + fullName + email + deptID + roleID)
                    $('#edit-deadline-modal').modal('show');
                });
            });

            var editTopicBtn = document.querySelectorAll('#topic-edit-btn');
            editTopicBtn.forEach(function(e) {
                e.addEventListener('click', function() {
                    var id = e.getAttribute('data-id');
                    var topicName = e.getAttribute('data-topicName');
                    var description = e.getAttribute('data-description');
                    var firstClosureDate = e.getAttribute('data-firstClosureDate');
                    var finalClosureDate = e.getAttribute('data-finalClosureDate');

                    var inputTopicName = document.getElementById('topicName_edit');
                    var inputDescription = document.getElementById('description_edit');
                    var inputFirstClosureDate = document.getElementById('firstClosureDate_edit');
                    var inputFinalClosureDate = document.getElementById('finalClosureDate_edit');

                    inputTopicName.value = topicName;
                    inputFirstClosureDate.value = firstClosureDate;
                    inputFinalClosureDate.value = finalClosureDate;
                    inputDescription.value = description;

                    var formUpdateTopic = document.getElementById('form-update-topic');
                    formUpdateTopic.action = "{{ route('qa-leaders.topics.update', ':id') }}"
                        .replace(':id', id);

                    $('#topic-update-modal').modal('show');
                });
            });
        });
    </script>


    <script>
        var rows = document.querySelectorAll('#topic-table tbody tr');
        rows.forEach(function(row) {
            // NOTE: Add a mouseover event listener to change the background color and cursor style
            row.addEventListener('mouseover', function() {
                row.style.backgroundColor = '#f2f2f2';
                row.style.cursor = 'pointer';
            });
            // NOTE: Add a mouseout event listener to reset the background color
            row.addEventListener('mouseout', function() {
                row.style.backgroundColor = '';
            });
            // NOTE: Add a click event listener to redirect to the URL in the data-href attribute
            var cells = row.querySelectorAll('td');
            var href = row.getAttribute('data-href');
            cells.forEach(function(cell) {
                if (!cell.querySelector('button')) {
                    cell.addEventListener('click', function() {
                        window.location.href = href;
                    });
                }
            });
        });
    </script>
@endsection
