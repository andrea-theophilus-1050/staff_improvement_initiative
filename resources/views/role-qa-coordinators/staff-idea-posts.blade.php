@extends('layouts.main')
@section('content')
    @php
        $now = \Carbon\Carbon::now();
        $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($onTopic->topicDeadline->finalClosureDate)));
        $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($onTopic->topicDeadline->firstClosureDate)));
    @endphp

    <div class="row">
        <div class="col-md-4 mb-4">
            @if ($deadline1->isFuture() && $deadline2->isFuture())
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="media mb-2">
                            <div class="media-body d-flex justify-content-between align-items-center">
                                <h5 class="card-title" style="text-transform: none">Send notification for staffs</h5>
                                <a href="{{ route('qa-coordinators.send.notify', $onTopic->topic_id) }}"
                                    class="btn btn-primary" title="Send notify for staff who has no submited ideas yet"><i
                                        class="mdi mdi-bell-alert"></i></a>
                            </div>
                        </div>
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <strong>Success!</strong> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-2">
                        <div class="media-body">
                            <a href="{{ route('qa-coordinators.view.all', $onTopic->topic_id) }}"
                                class="col-md-12 btn btn-outline-primary  btn-icon-text mb-1">
                                View all idea posts<i class="ti-files btn-icon-append"></i>
                            </a>

                            <a href="{{ route('qa-coordinators.topics.idea.posts', $onTopic->topic_id) }}"
                                class="col-md-12 btn btn-outline-success btn-icon-text mt-1">
                                View by deparment <i class="ti-menu-alt btn-icon-append"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="media mb-2">
                        <div class="media-body">
                            @if ($deadline1->isPast())
                                <div class="form-group">
                                    <h5 class="font-weight-bold text-center"
                                        style="background: red; color: white; padding: 10px; border-radius: 10px">
                                        The topic has closed for submission of ideas
                                    </h5>
                                </div>
                            @endif
                            <h5 class="card-title" style="text-transform: none; line-height: 1.5">Topic name:
                                {{ $onTopic->topic_name }}
                            </h5>
                            <p>Topic description: {{ $onTopic->topic_description }}</p>
                            <div class="template-demo">
                                <div style="font-size: 13px">
                                    <li>
                                        <b>Deadline for submit:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($onTopic->topicDeadline->firstClosureDate)) }}
                                        </span>
                                    </li>
                                    <li>
                                        <b>Final deadline:</b>
                                        <span>
                                            <i class="mdi mdi-calendar-clock"></i>
                                            {{ date('M-d-Y - h:i:s a', strtotime($onTopic->topicDeadline->finalClosureDate)) }}
                                        </span>
                                    </li>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if ($posts->count() != 0)
                @foreach ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media mb-4">
                                @if ($post->anonymous == 1 || $post->user->avatar == null)
                                    <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                        style="height: 50px; width: 50px">
                                @else
                                    <img src="{{ asset('img/avatar/' . $post->user->avatar) }}" class="mr-3"
                                        alt="Profile Image" style="height: 50px; width: 50px">
                                @endif
                                <div class="media-body">
                                    <h5 class="card-title">
                                        @if ($post->anonymous == 1)
                                            <i>(Anonymous)</i>
                                        @else
                                            {{ $post->user->fullName }}
                                        @endif


                                    </h5>
                                    <div class="mb-4" style="font-size: 12px">
                                        <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;Created on
                                        {{ date('F d, Y', strtotime($post->created_at)) }} at
                                        {{ date('h:i A', strtotime($post->created_at)) }}
                                    </div>
                                    <p class="card-text" style="font-size: 15px">{{ $post->content }}</p>

                                    @if ($post->documents->count() != 0)
                                        <a href="{{ route('download.idea.file', $post->post_id) }}"
                                            class="btn btn-info btn-icon-text  mt-3">
                                            <i class="ti-file btn-icon-append"></i>
                                            Download file (as .zip)
                                            <i class="ti-download btn-icon-append ml-5"></i>
                                        </a>
                                    @endif
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-3 d-flex">
                                    @include('components.like-dislike-btn')
                                </div>
                            </div>
                            <hr>
                            @include('components.comment')
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center align-items-center">
                    {{ $posts->links() }}
                </div>
            @else
                <div class="row mt-5">
                    <div class="col-12 grid-margin stretch-card">
                        <div class="card text-center h4 font-weight-bold">
                            <div class="card shadow">
                                <div class="card-body">There are no ideas yet</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        const checkbox = document.getElementById('checkbox-agree');
        const btnSubmitIdea = document.getElementById('btn-submit-idea');

        checkbox.addEventListener('change', function() {
            if (checkbox.checked) {
                btnSubmitIdea.disabled = false;
            } else {
                btnSubmitIdea.disabled = true;
            }
        });
    </script>

    <script src="{{ asset('javascript/handle-like-cmt.js') }}"></script>
@endsection
