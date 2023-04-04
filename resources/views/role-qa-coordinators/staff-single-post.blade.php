@extends('layouts.main')
@section('content')
    @php
        $now = \Carbon\Carbon::now();
        $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($onTopic->topicDeadline->finalClosureDate)));
        $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($onTopic->topicDeadline->firstClosureDate)));
    @endphp
    <div class="row">
        <div class="col-md-12 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-4">
                        @if ($post->user->avatar == null || $post->anonymous == 1)
                            <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                style="height: 50px; width: 50px">
                        @else
                            <img src="{{ asset('img/avatar/' . $post->user->avatar) }}" class="mr-3" alt="Profile Image"
                                style="height: 50px; width: 50px">
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
                        <div class="col-sm-9 d-flex">
                            @include('components.like-dislike-btn')
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
