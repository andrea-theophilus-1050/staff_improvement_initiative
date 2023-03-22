@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4 shadow ">
                <div class="card-body">
                    <div class="media mb-2">
                        <div class="media-body">
                            @if (date('M-d-Y h:i:s a') > date('M-d-Y h:i:s a', strtotime($onTopic->topicDeadline->firstClosureDate)))
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

            <div class="card mb-4 shadow text-center h4 font-weight-bold">
                <div class="card-body">
                    <b style="font-weight: normal">Number of ideas:</b> {{ $posts->count() }}
                </div>
            </div>

            @if ($posts->count() != 0)
                <div class="card mb-4 shadow text-center h4 font-weight-bold">
                    {{-- alert --}}
                    {{-- @if (session('errorDownload'))
                    <script>
                        alert('No files to download');
                    </script>
                @endif --}}
                    <div class="card-body">
                        {{-- alert --}}

                        @if (session('errorDownload'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> {{ session('errorDownload') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <a class="btn btn-primary btn-icon-text"
                            href="{{ route('qa-leaders.download.all.files', $onTopic->topic_id) }}">Download all files
                            (.zip)
                            <i class="ti-download btn-icon-append ml-3"></i></a>
                        <a class="btn btn-success btn-icon-text mt-2"
                            href="{{ route('qa-leaders.export.csv', $onTopic->topic_id) }}">Export ideas (.csv) <i
                                class="ti-file btn-icon-append ml-3"></i></a>


                    </div>
                </div>

                <div class="card mb-4 shadow text-center h4 font-weight-bold">
                    <div class="card-body">
                        <a class="btn btn-success btn-icon-text"
                            href="{{ route('list.of.top-ideas', $onTopic->topic_id) }}">List of TOP Ideas
                            <i class="ti-stats-up btn-icon-append ml-3"></i></a>
                    </div>
                </div>
            @endif
        </div>



        <div class="col-md-8">
            @if ($posts->count() != 0)
                @foreach ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media mb-5">
                                @if ($post->anonymous == 1 || $post->user->avatar == null)
                                    <img src="{{ asset('img/default-avt.jpg') }}" style="width: 30px; height: 30px"
                                        class="mr-3" alt="Profile Image">
                                @else
                                    <img src="{{ asset('img/avatar/' . $post->user->avatar) }}"
                                        style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
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
                                            Download {{ $post->documents->count() }} files (as .zip)
                                            <i class="ti-download btn-icon-append ml-5"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 d-flex">
                                    {{-- NOTE: Like/Dislike button --}}
                                    @include('components.like-dislike-btn')

                                </div>
                            </div>
                            <hr>
                            {{-- NOTE: Comment section --}}
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

    <script src="{{ asset('javascript/handle-like-cmt.js') }}"></script>
@endsection
