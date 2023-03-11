@extends('layouts.main')
@section('content')
    {{-- <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card-body">
                            Idea Topics
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-2">
                        <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                            style="height: 30px; width: 30px">
                        <div class="media-body">
                            <h5 class="card-title" style="text-transform: none">Submit your idea here</h5>
                        </div>
                    </div>
                    <form method="POST" action="{{ route('staff.posts.submit.idea', $id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="topicName" class="font-weight-bold">Topic:</label>
                            <textarea class="form-control" rows="3" id="topicName" placeholder="Enter title" readonly
                                style="line-height: 1.5">{{ $topicTitle->topic_name }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="topicDesc" class="font-weight-bold">Topic description:</label>
                            <textarea class="form-control" rows="10" id="topicDesc" placeholder="Enter title" readonly
                                style="line-height: 1.5">{{ $topicTitle->topic_description }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="idea-description">Your idea:</label>
                            <textarea class="form-control" id="content" name="content" rows="10" name="idea_content"
                                placeholder="Enter description" style="line-height:1.5"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="idea-description">Your supported files: <i style="color: blue; font-size: 12px">(Not
                                    required)</i></label>
                            <input type="file" class="form-control" id="idea-description"
                                placeholder="Enter description">
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
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <h6>Related Posts:</h6>
                    <ul class="list-styled">
                        <li><a href="#">Related Post 1</a></li>
                        <li><a href="#">Related Post 2</a></li>
                        <li><a href="#">Related Post 3</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            @if ($posts->count() != 0)
                @foreach ($posts as $post)
                    <div class="card mb-4">
                        <div class="card-body">
                            <div class="media mb-5">
                                <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                    style="height: 50px; width: 50px">
                                <div class="media-body">
                                    <h5 class="card-title">Anonymous</h5>
                                    <div class="mb-2" style="font-size: 12px">
                                        <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;Created on
                                        {{ date('F d, Y', strtotime($post->created_at)) }} at
                                        {{ date('h:i A', strtotime($post->created_at)) }}
                                    </div>
                                    <p class="card-text" style="font-size: 15px">{{ $post->content }}</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-9 d-flex">
                                    <button
                                        class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center">
                                        <i class="mdi mdi-thumb-up"></i>
                                        &nbsp;&nbsp;123 Like
                                    </button>
                                    <button
                                        class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                        <i class="mdi mdi-thumb-down"></i>
                                        &nbsp;&nbsp;123 Dislike
                                    </button>
                                    <button
                                        class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                        data-toggle="collapse" data-target="#comment-section{{ $loop->iteration }}">
                                        <i class="mdi mdi-comment"></i>
                                        &nbsp;&nbsp;{{ $post->comments->count() }} Comment
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
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
                            <hr>
                            <div id="comment-section{{ $loop->iteration }}" class="collapse">
                                <h6>Comments:</h6>
                                @foreach (collect($post->comments) as $comment)
                                    <div class="card mb-2" style="background: #f5f7ff">
                                        <div class="card-body">
                                            <div class="media">
                                                <img src="{{ asset('img/default-avt.jpg') }}"
                                                    style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
                                                <div class="media-body">
                                                    <p class="card-text">{{ $comment->comment_content }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- <div class="card mb-2" style="background: #f5f7ff">
                                    <div class="card-body">
                                        <div class="media">
                                            <img src="{{ asset('img/default-avt.jpg') }}"
                                                style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
                                            <div class="media-body">
                                                <p class="card-text">Comment 2</p>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <form method="POST" id="comment-form"
                                    action="{{ route('staff.posts.comments.submit', [$post->post_id, $id]) }}">
                                    @csrf
                                    <div class="form-group">
                                        <label for="comment-text">Add a comment:</label>
                                        <textarea class="form-control" id="comment-text" name="commentContent" rows="3"></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center align-items-center">
                        {{ $posts->links() }}
                    </div>
                @endforeach
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
                        organization. The form must include a description of the idea and any supporting materials. Staff
                        members may submit multiple ideas.
                    </div>

                    <div class="h4 font-weight-bold mt-3">4. Idea Ownership</div>
                    <div>All submitted ideas remain the property of the organization. By submitting an idea, staff members
                        acknowledge that they are not entitled to any compensation or recognition for the idea.
                    </div>

                    <div class="h4 font-weight-bold mt-3">5. Idea Evaluation</div>
                    <div>All ideas will be evaluated by a designated team within the organization. The team will assess the
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
                        [insert governing jurisdiction]. Any disputes arising out of or in connection with these terms and
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

    <script>
        const form = document.getElementById('comment-form');

        form.addEventListener('submit', e => {
            e.preventDefault();

            const formData = new FormData(form);

            fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    // handle the response data here
                    console.log(data);
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>


@endsection
