@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-5">
                        @if ($post->user->avatar == null)
                            <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                style="height: 50px; width: 50px">
                        @else
                            <img src="{{ asset('img/avatar/' . $post->user->avatar) }}" class="mr-3" alt="Profile Image"
                                style="height: 50px; width: 50px">
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
                    @include('components.comment')
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('javascript/handle-like-cmt.js') }}"></script>
@endsection
