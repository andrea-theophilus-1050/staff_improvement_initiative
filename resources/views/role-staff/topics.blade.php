@extends('layouts.main')
@section('content')
    @php
        $now = \Carbon\Carbon::now();
        $deadline2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($onTopic->topicDeadline->finalClosureDate)));
        $deadline1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime($onTopic->topicDeadline->firstClosureDate)));
    @endphp
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-2">
                        @if (auth()->user()->avatar == null)
                            <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                style="height: 30px; width: 30px">
                        @else
                            <img src="{{ asset('img/avatar/' . auth()->user()->avatar) }}" class="mr-3" alt="Profile Image"
                                style="height: 30px; width: 30px">
                        @endif
                        <div class="media-body">
                            <h5 class="card-title" style="text-transform: none">Submit your idea here</h5>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('staff.posts.submit.idea', $id) }}" enctype="multipart/form-data">
                        @csrf
                        @if ($deadline1->isPast())
                            <div class="form-group">
                                <h5 class="font-weight-bold text-center"
                                    style="background: red; color: white; padding: 10px; border-radius: 10px">
                                    The topic has closed for submission of ideas
                                </h5>
                            </div>
                        @endif
                        <div class="form-group">
                            <label for="topicName" class="font-weight-bold">Topic:</label>
                            <textarea class="form-control" rows="3" id="topicName" placeholder="Enter title" readonly
                                style="line-height: 1.5">{{ $onTopic->topic_name }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="topicDesc" class="font-weight-bold">Topic description:</label>
                            <textarea class="form-control" rows="10" id="topicDesc" placeholder="Enter title" readonly
                                style="line-height: 1.5">{{ $onTopic->topic_description }}</textarea>
                        </div>
                        @if ($deadline1->isFuture())
                            <div class="form-group">
                                {{-- alert --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong>Error! </strong>{{ $errors->first() }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <label for="idea-description">Your idea:</label>
                                <textarea class="form-control" id="content" name="content" rows="10" name="idea_content"
                                    placeholder="Enter description" style="line-height:1.5" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="idea-description">Your supported files:
                                    <i style="color: blue; font-size: 12px">
                                        (Not required)
                                    </i></label>
                                <input type="file" class="form-control" id="idea-file" name="idea_file[]"
                                    placeholder="Enter description" multiple>
                            </div>
                            <div class="form-group d-flex align-items-center justify-content-between">
                                <label for=""><b>Anonymous</b></label>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="anonymous" id="anonymous"
                                            value="1">
                                        Yes
                                    </label>
                                </div>
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input type="radio" class="form-check-input" name="anonymous" id="anonymous"
                                            value="0" checked>
                                        No
                                    </label>
                                </div>
                            </div>
                            <div class="form-check form-check-flat form-check-primary d-flex">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" id="checkbox-agree">
                                    I agree to the
                                </label>
                                <a href="javasript:;" data-target="#terms-conditions" data-toggle="modal"
                                    class="form-check-label">terms and conditions</a>
                            </div>

                            <div class="form-group mt-3">
                                <button type="submit" class="btn btn-primary" id="btn-submit-idea" disabled>Submit</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6>Other Topics:</h6>
                    <ul class="list-styled">
                        @foreach ($relatedTopic as $topic)
                            <li><a
                                    href="{{ route('staff.topics.idea.posts', $topic->topic_id) }}">{{ $topic->topic_name }}</a>
                            </li>
                        @endforeach

                    </ul>
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

    {{-- NOTE: terms and conditions modal --}}
    <div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="terms-conditions"
        id="terms-conditions" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Terms and Conditions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="text-align: justify">
                    <div class="h4 font-weight-bold">1. Introduction</div>
                    <div>This document outlines the terms and conditions that govern the submission of ideas for system
                        improvement by staff of the organization. By submitting an idea, you agree to these terms and
                        conditions. </div>

                    <div class="h4 font-weight-bold mt-3">2. Eligibility</div>
                    <div>All staff members are eligible to submit ideas for system improvement.</div>

                    <div class="h4 font-weight-bold mt-3">3. Idea Submission</div>
                    <div>To submit an idea, staff members must complete the idea submission form provided by the
                        organization. The form must include a description of the idea and any supporting materials.
                        Staff
                        members may submit multiple ideas.
                    </div>

                    <div class="h4 font-weight-bold mt-3">4. Idea Ownership</div>
                    <div>All submitted ideas remain the property of the organization. By submitting an idea, staff
                        members
                        acknowledge that they are not entitled to any compensation or recognition for the idea.
                    </div>

                    <div class="h4 font-weight-bold mt-3">5. Idea Evaluation</div>
                    <div>All ideas will be evaluated by a designated team within the organization. The team will assess
                        the
                        feasibility, cost-effectiveness, and potential impact of each idea. Staff members will not be
                        provided with feedback on the evaluation of their idea.
                    </div>

                    <div class="h4 font-weight-bold mt-3">6. Idea Implementation</div>
                    <div>The organization reserves the right to implement any submitted idea at its discretion. The
                        organization is not obligated to implement any submitted ideas.
                    </div>

                    <div class="h4 font-weight-bold mt-3">7. Idea Confidentiality</div>
                    <div>The organization will take reasonable steps to maintain the confidentiality of submitted ideas.
                        However, staff members acknowledge that the organization cannot guarantee the confidentiality of
                        submitted ideas.
                    </div>

                    <div class="h4 font-weight-bold mt-3">8. Termination of Idea Submission</div>
                    <div>The organization may terminate the idea submission process at any time without notice. The
                        organization is not obligated to provide any reason for the termination of the idea submission
                        process.</div>

                    <div class="h4 font-weight-bold mt-3">9. Modification of Terms and Conditions</div>
                    <div>The organization reserves the right to modify these terms and conditions at any time without
                        notice. Staff members are responsible for reviewing these terms and conditions periodically.
                    </div>

                    <div class="h4 font-weight-bold mt-3">10. Governing Law</div>
                    <div>These terms and conditions shall be governed by and construed in accordance with the laws of
                        [insert governing jurisdiction]. Any disputes arising out of or in connection with these terms
                        and
                        conditions shall be subject to the exclusive jurisdiction of the courts of [insert governing
                        jurisdiction]</div>

                    <div class="h5 font-weight-bold mt-5">By submitting an idea, you acknowledge that you have read,
                        understood, and agreed to these terms and conditions.
                    </div>
                </div>
            </div>
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
