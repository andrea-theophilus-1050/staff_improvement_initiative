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
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 d-flex">
                                    <div class="mr-3" style="color: blue"><i class="mdi mdi-thumb-up"></i>
                                        {{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                        &nbsp;&nbsp;Like</div>
                                    <div class="mr-3" style="color: red"><i class="mdi mdi-thumb-down"></i>
                                        {{ collect($post->like_dislike)->where('status', 'disliked')->count() }}&nbsp;&nbsp;Dislike
                                    </div>
                                    <div class="mr-3" style="color: green"><i class="mdi mdi-comment"></i> <a
                                            href="javascript:;" data-toggle="collapse"
                                            data-target="#post-comment{{ $post->post_id }}">{{ $post->comments->count() }}&nbsp;&nbsp;Comment</a>
                                    </div>
                                    {{-- <button
                                        class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                        data-toggle="collapse" data-target="#post-comment{{ $post->post_id }}">
                                        <i class="mdi mdi-comment"></i>
                                        &nbsp;&nbsp;{{ $post->comments->count() }} Comment
                                    </button> --}}
                                </div>
                            </div>
                            <hr>
                            <div id="post-comment{{ $post->post_id }}" class="collapse">
                                <div id="comments-section">
                                    <h6>Comments:</h6>
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
@endsection
