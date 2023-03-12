@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            @if ($ownPosts->count() != 0)
                @foreach ($ownPosts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media mb-5">
                                <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                    style="height: 50px; width: 50px">
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
                                    <form method="POST"
                                        action="{{ route('staff.posts.like.dislike', [$post->post_id, 'liked']) }}">
                                        @csrf
                                        @if (collect($post->like_dislike)->where('status', 'liked')->where('post_id', $post->post_id)->where('user_id', auth()->user()->user_id)->count() > 0)
                                            <button type="submit"
                                                class="btn btn-primary btn-sm d-flex justify-content-center align-items-center">
                                                <i class="mdi mdi-thumb-up"></i>
                                                &nbsp;&nbsp;{{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                                Like
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center">
                                                <i class="mdi mdi-thumb-up"></i>
                                                &nbsp;&nbsp;{{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                                Like
                                            </button>
                                        @endif
                                    </form>
                                    <form method="POST"
                                        action="{{ route('staff.posts.like.dislike', [$post->post_id, 'disliked']) }}">
                                        @csrf
                                        @if (collect($post->like_dislike)->where('status', 'disliked')->where('post_id', $post->post_id)->where('user_id', auth()->user()->user_id)->count() > 0)
                                            <button type="submit"
                                                class="btn btn-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                                <i class="mdi mdi-thumb-down"></i>
                                                &nbsp;&nbsp;{{ collect($post->like_dislike)->where('status', 'disliked')->count() }}
                                                Dislike
                                            </button>
                                        @else
                                            <button type="submit"
                                                class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                                <i class="mdi mdi-thumb-down"></i>
                                                &nbsp;&nbsp;{{ collect($post->like_dislike)->where('status', 'disliked')->count() }}
                                                Dislike
                                            </button>
                                        @endif

                                    </form>
                                    <button
                                        class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                        data-toggle="collapse" data-target="#post-comment{{ $post->post_id }}">
                                        <i class="mdi mdi-comment"></i>
                                        &nbsp;&nbsp;{{ $post->comments->count() }} Comment
                                    </button>
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
                                                    <img src="{{ asset('img/default-avt.jpg') }}"
                                                        style="width: 30px; height: 30px" class="mr-3"
                                                        alt="Profile Image">
                                                    <div class="media-body">
                                                        <p class="card-text">{{ $comment->comment_content }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <form method="POST" id="comment-form-{{ $post->post_id }}"
                                        action="{{ route('staff.posts.comments.submit', $post->post_id) }}">
                                        @csrf
                                        <div class="form-group">
                                            <label for="comment-text">Add a comment:</label>
                                            <textarea class="form-control" id="comment-text" name="commentContent" rows="3"></textarea>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-sm-2">
                                    <h6>Attachments:</h6>
                                </div>
                                <div class="col-sm-8">
                                    <ul class="list-unstyled d-flex flex-row">
                                        <li class="mr-3">
                                            <a href="#">File 1</a>
                                            {{-- <button class="btn btn-sm btn-outline-primary ml-2 ">
                                    <i class="mdi mdi-download"></i>
                                    Download
                                </button> --}}
                                        </li>
                                        <li class="mr-3">
                                            <a href="#">File 2</a>
                                            {{-- <button class="btn btn-sm btn-outline-primary ml-2 ">
                                    <i class="mdi mdi-download"></i>
                                    Download
                                </button> --}}
                                        </li>
                                        <li><a href="#">File 3</a>
                                            {{-- <button class="btn btn-sm btn-outline-primary ml-2 ">
                                    <i class="mdi mdi-download"></i>
                                    Download
                                </button> --}}
                                        </li>
                                    </ul>
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
