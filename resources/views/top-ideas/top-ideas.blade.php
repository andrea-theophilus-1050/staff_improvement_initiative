@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-6 grid-margin stretch-card">
            <div class="card text-center h5 font-weight-bold">
                <div class="card shadow">
                    <div class="card-body">Top 5 most liked idea</div>
                </div>
            </div>
        </div>
        <div class="col-6 grid-margin stretch-card">
            <div class="card text-center h5 font-weight-bold">
                <div class="card shadow">
                    <div class="card-body">Top 5 ideas received the most comments</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- SECTION-START: TOP 5 Most liked ideas section --}}
        <div class="col-md-6">
            @foreach ($topLikedPosts as $post)
                <div class="card mb-4 shadow">
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
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">
                                        @if ($post->anonymous == 1)
                                            <i>(Anonymous)</i>
                                        @else
                                            {{ $post->user->fullName }}
                                        @endif
                                    </h5>
                                    <button class="btn btn-outline-primary btn-icon-text" disabled>
                                        <i class="mdi mdi-thumb-up"></i>

                                        <b id="like-count-{{ $post->post_id }}">
                                            {{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                        </b>&nbsp;&nbsp;Like
                                    </button>
                                </div>
                                <div class="mb-2" style="font-size: 12px">
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
                    </div>
                </div>
            @endforeach
        </div>
        {{-- SECTION-END:  TOP 5 Most liked ideas section --}}

        {{-- SECTION-START: Top 5 ideas received the most comments --}}
        <div class="col-md-6">
            @foreach ($topCommentPosts as $post)
                <div class="card mb-4 shadow">
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
                                <div class="d-flex justify-content-between">
                                    <h5 class="card-title">
                                        @if ($post->anonymous == 1)
                                            <i>(Anonymous)</i>
                                        @else
                                            {{ $post->user->fullName }}
                                        @endif
                                    </h5>

                                    <button class="btn btn-outline-success btn-icon-text" data-toggle="collapse"
                                        data-target="#post-comment{{ $post->post_id }}">
                                        <i class="mdi mdi-comment"></i>
                                        &nbsp;&nbsp;
                                        <b id="comment-count-{{ $post->post_id }}">
                                            {{ $post->comments->count() }}
                                        </b>&nbsp;&nbsp; Comments
                                    </button>
                                </div>
                                <div class="mb-2" style="font-size: 12px">
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
                        <div id="post-comment{{ $post->post_id }}" class="collapse">
                            <h6>Comments:</h6>
                            @foreach (collect($post->comments) as $comment)
                                <div class="card mb-2" style="background: #f5f7ff">
                                    <div class="card-body">
                                        <div class="media">
                                            @if ($comment->anonymous == 1 || $comment->user->avatar == null)
                                                <img src="{{ asset('img/default-avt.jpg') }}"
                                                    style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
                                            @else
                                                <img src="{{ asset('img/avatar/' . $comment->user->avatar) }}"
                                                    style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
                                            @endif

                                            <div class="media-body">
                                                <p class="card-text">
                                                    <b>
                                                        @if ($comment->anonymous == 1)
                                                            <i>(Anonymous):</i>
                                                        @else
                                                            {{ $comment->user->fullName }}:
                                                        @endif
                                                    </b>
                                                    &nbsp;&nbsp;{{ $comment->comment_content }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="media ml-5 mt-3">
                                            <div class="mb-2 pull-right" style="font-size: 10px">
                                                <i
                                                    class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;{{ \Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                            <button class="btn btn-outline-success btn-icon-text" data-toggle="collapse"
                                data-target="#post-comment{{ $post->post_id }}">
                                Hide
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{-- SECTION-END: Top 5 ideas received the most comments --}}
    </div>
@endsection
