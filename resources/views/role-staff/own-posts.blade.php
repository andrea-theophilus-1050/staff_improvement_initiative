@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($ownPosts->count() != 0)
                @foreach ($ownPosts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media mb-5">
                                @if (auth()->user()->avatar == null)
                                    <img src="{{ asset('img/default-avt.jpg') }}" style="width: 30px; height: 30px"
                                        class="mr-3" alt="Profile Image">
                                @else
                                    <img src="{{ asset('img/avatar/' . auth()->user()->avatar) }}"
                                        style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
                                @endif
                                <div class="media-body">
                                    <h5 class="card-title">You</h5>
                                    <div class="mb-2" style="font-size: 12px">
                                        <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;Created on
                                        {{ date('F d, Y', strtotime($post->created_at)) }} at
                                        {{ date('h:i A', strtotime($post->created_at)) }}
                                    </div>

                                    <h5 style="font-weight: bold; font-size: 13px"><u>Topic name:</u>
                                        {{ $post->topic->topic_name }}</h5>
                                    <p class="card-text" style="font-size: 13px; text-align: justify"><u
                                            class="font-weight-bold">Topic description:</u>
                                        {{ $post->topic->topic_description }}</p>
                                    <hr>
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
                                <div class="col-sm-9 d-flex">
                                    @include('components.like-dislike-btn')
                                    {{-- <button
                                        class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                        data-toggle="collapse" data-target="#post-comment{{ $post->post_id }}">
                                        <i class="mdi mdi-comment"></i>
                                        &nbsp;&nbsp;{{ $post->comments->count() }} Comment
                                    </button> --}}
                                </div>
                            </div>
                            <hr>
                            <div id="post-comment{{ $post->post_id }}" class="collapse"
                                style="transition: height 0.5s ease-out; overflow: hidden">
                                <h6>Comments:</h6>
                                <div id="comments-section-{{ $post->post_id }}">
                                    @foreach (collect($post->comments) as $comment)
                                        <div class="card mb-2" style="background: #f5f7ff">
                                            <div class="card-body">
                                                <div class="media">
                                                    @if ($comment->anonymous == 1 || $comment->user->avatar == null)
                                                        <img src="{{ asset('img/default-avt.jpg') }}"
                                                            style="width: 30px; height: 30px" class="mr-3"
                                                            alt="Profile Image">
                                                    @else
                                                        <img src="{{ asset('img/avatar/' . $comment->user->avatar) }}"
                                                            style="width: 30px; height: 30px" class="mr-3"
                                                            alt="Profile Image">
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
                                </div>
                                @if (date('M-d-Y h:i:s a') < date('M-d-Y h:i:s a', strtotime($post->topic->finalClosureDate)))
                                    <hr>
                                    <form method="POST" id="comment-form-{{ $post->post_id }}"
                                        data-post-id="{{ $post->post_id }}"
                                        action="{{ route('staff.posts.comments.submit', [$post->post_id]) }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="comment-text">Add a comment:</label>
                                            <input class="form-control" id="comment-text-{{ $post->post_id }}"
                                                name="commentContent" rows="3" required>
                                        </div>
                                        <div
                                            class="form-group col-md-4 col-sm-12 d-flex justify-content-between align-items-center">
                                            <label for=""><b>Anonymous</b></label>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="commentAnonymous"
                                                        id="commentAnonymous" value="1">
                                                    Yes
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <label class="form-check-label">
                                                    <input type="radio" class="form-check-input" name="commentAnonymous"
                                                        id="commentAnonymous" value="0" checked>
                                                    No
                                                </label>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <button type="submit" class="btn btn-primary btn-sm ml-3">Submit</button>
                                            <button class="btn btn-outline-success btn-sm ml-2" data-toggle="collapse"
                                                data-target="#post-comment{{ $post->post_id }}">
                                                Hide
                                            </button>
                                        </div>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex justify-content-center align-items-center">
                    {{ $ownPosts->links() }}
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
