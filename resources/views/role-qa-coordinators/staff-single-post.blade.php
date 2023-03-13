@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card mb-4 shadow text-center h4 font-weight-bold">
                <div class="card-body">
                    Number of ideas: 200
                </div>
            </div>
            <div class="card mb-4 shadow text-center h4 font-weight-bold">
                <div class="card-body">
                    Number of ideas: 200
                </div>
            </div>
            <div class="card mb-4 shadow text-center h4 font-weight-bold">
                <div class="card-body">
                    Number of ideas: 200
                </div>
            </div>
        </div>

        <div class="col-md-9 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-4">
                        <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                            style="height: 50px; width: 50px">

                        <div class="media-body">
                            <h5 class="card-title">

                                <i>(Anonymous)</i>

                            </h5>
                            <div class="mb-2" style="font-size: 12px">
                                <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;Created on
                                {{ date('F d, Y', strtotime($post->created_at)) }} at
                                {{ date('h:i A', strtotime($post->created_at)) }}
                            </div>
                            <p class="card-text" style="font-size: 15px">{{ $post->content }}</p>
                            <a href="#" class="btn btn-outline-info btn-icon-text  mt-3">
                                {{-- {{ Illuminate\Support\Str::limit('testhelloworldblabla', 10, '...') . '.' . 'csv' }} --}}
                                <i class="ti-download btn-icon-append"></i>
                            </a>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-3 d-flex">
                            <form id="like-form-" data-post-id="" method="POST" action="">

                                <button type="submit" id="like-button-"
                                    class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center">
                                    <i class="mdi mdi-thumb-up"></i>
                                    &nbsp;&nbsp;
                                    <b id="like-count-">

                                    </b>&nbsp;&nbsp;Like
                                </button>

                            </form>
                            <form id="dislike-form-" data-post-id="" method="POST" action="">
                                @csrf

                                <button type="submit" id="dislike-button-"
                                    class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                    <i class="mdi mdi-thumb-down"></i>
                                    &nbsp;&nbsp;
                                    <b id="dislike-count-">
                                        {{ collect($post->like_dislike)->where('status', 'disliked')->count() }}
                                    </b>&nbsp;&nbsp;Dislike
                                </button>

                            </form>
                            <button
                                class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                data-toggle="collapse" data-target="#post-comment">
                                <i class="mdi mdi-comment"></i>
                                &nbsp;&nbsp;
                                <b id="comment-count-">

                                </b>&nbsp;&nbsp; Comment
                            </button>
                        </div>
                    </div>
                    <hr>
                    <div id="post-comment" class="collapse">
                        <h6>Comments:</h6>
                        <div id="comments-section">

                            <div class="card mb-2" style="background: #f5f7ff">
                                <div class="card-body">

                                    <div class="media">
                                        <img src="{{ asset('img/default-avt.jpg') }}" style="width: 30px; height: 30px"
                                            class="mr-3" alt="Profile Image">

                                        <div class="media-body">
                                            <p class="card-text"></p>
                                        </div>
                                    </div>
                                    <div class="media ml-5 mt-3">
                                        <div class="mb-2 pull-right" style="font-size: 10px">
                                            <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                        <hr>
                        <form method="POST" id="comment-form-" data-post-id="">
                            @csrf
                            <div class="form-group">
                                <label for="comment-text">Add a comment:</label>
                                <textarea class="form-control" id="comment-text-" name="commentContent" rows="3" required></textarea>
                            </div>
                            <div class="form-group row">
                                <button type="submit" class="btn btn-primary btn-sm ml-3">Submit</button>
                                <button class="btn btn-outline-success btn-sm ml-2" data-toggle="collapse"
                                    data-target="#post-comment">
                                    Hide
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
