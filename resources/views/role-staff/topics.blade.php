@extends('layouts.main')
@section('content')
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
                    <form method="POST" action="{{ route('staff.posts.submit.idea', $id) }}" enctype="multipart/form-data">
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
                            <input type="file" class="form-control" id="idea-file" name="idea_file"
                                placeholder="Enter description">
                        </div>
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <label for=""><b>Anonymous</b></label>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="anonymous" id="anonymous"
                                        value="1" checked>
                                    Yes
                                </label>
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="radio" class="form-check-input" name="anonymous" id="anonymous"
                                        value="0">
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
                                <img src="{{ asset('img/default-avt.jpg') }}" class="mr-3" alt="Profile Image"
                                    style="height: 50px; width: 50px">
                                <div class="media-body">
                                    <h5 class="card-title">
                                        @if ($post->anonymous == 1)
                                            <i>(Anonymous)</i>
                                        @else
                                            {{ $post->user->fullName }}
                                        @endif
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
                                <div class="col-sm-9 d-flex">
                                    <form id="like-form-{{ $post->post_id }}" data-post-id="{{ $post->post_id }}"
                                        method="POST"
                                        action="{{ route('staff.posts.like.dislike', [$post->post_id, 'liked']) }}">
                                        @csrf
                                        @if (collect($post->like_dislike)->where('status', 'liked')->where('post_id', $post->post_id)->where('user_id', auth()->user()->user_id)->count() > 0)
                                            <button type="submit" id="like-button-{{ $post->post_id }}"
                                                class="btn btn-primary btn-sm d-flex justify-content-center align-items-center">
                                                <i class="mdi mdi-thumb-up"></i>
                                                &nbsp;&nbsp;
                                                <b id="like-count-{{ $post->post_id }}">
                                                    {{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                                </b>&nbsp;&nbsp;Like
                                            </button>
                                        @else
                                            <button type="submit" id="like-button-{{ $post->post_id }}"
                                                class="btn btn-outline-primary btn-sm d-flex justify-content-center align-items-center">
                                                <i class="mdi mdi-thumb-up"></i>
                                                &nbsp;&nbsp;
                                                <b id="like-count-{{ $post->post_id }}">
                                                    {{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                                </b>&nbsp;&nbsp;Like
                                            </button>
                                        @endif
                                    </form>
                                    <form id="dislike-form-{{ $post->post_id }}" data-post-id="{{ $post->post_id }}"
                                        method="POST"
                                        action="{{ route('staff.posts.like.dislike', [$post->post_id, 'disliked']) }}">
                                        @csrf
                                        @if (collect($post->like_dislike)->where('status', 'disliked')->where('post_id', $post->post_id)->where('user_id', auth()->user()->user_id)->count() > 0)
                                            <button type="submit" id="dislike-button-{{ $post->post_id }}"
                                                class="btn btn-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                                <i class="mdi mdi-thumb-down"></i>
                                                &nbsp;&nbsp;
                                                <b id="dislike-count-{{ $post->post_id }}">
                                                    {{ collect($post->like_dislike)->where('status', 'disliked')->count() }}
                                                </b>&nbsp;&nbsp;Dislike
                                            </button>
                                        @else
                                            <button type="submit" id="dislike-button-{{ $post->post_id }}"
                                                class="btn btn-outline-danger btn-sm d-flex justify-content-center align-items-center ml-2">
                                                <i class="mdi mdi-thumb-down"></i>
                                                &nbsp;&nbsp;
                                                <b id="dislike-count-{{ $post->post_id }}">
                                                    {{ collect($post->like_dislike)->where('status', 'disliked')->count() }}
                                                </b>&nbsp;&nbsp;Dislike
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
                                        action="{{ route('staff.posts.comments.submit', [$post->post_id]) }}">
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
        document.addEventListener("DOMContentLoaded", function() {
            var likeForms = document.querySelectorAll('form[id^="like-form-"]');
            var dislikeForms = document.querySelectorAll('form[id^="dislike-form-"]');
            var i;

            // Add event listener for each like form
            for (i = 0; i < likeForms.length; i++) {
                likeForms[i].addEventListener("submit", function(event) {
                    event.preventDefault(); // prevent form from submitting normally
                    var postId = this.dataset.postId; // get the post ID
                    var formData = new FormData(this); // get the form data
                    var request = new XMLHttpRequest();
                    request.open("POST", this.action);
                    request.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            // update the like count on the page for the specific post
                            document.getElementById('like-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).likeCount;
                            document.getElementById('dislike-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).dislikeCount;
                        }
                    };
                    request.send(formData);
                });
            }

            // Add event listener for each dislike form
            for (i = 0; i < dislikeForms.length; i++) {
                dislikeForms[i].addEventListener("submit", function(event) {
                    event.preventDefault(); // prevent form from submitting normally
                    var postId = this.dataset.postId; // get the post ID
                    var formData = new FormData(this); // get the form data
                    var request = new XMLHttpRequest();
                    request.open("POST", this.action);
                    request.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            // update the dislike count on the page for the specific post
                            document.getElementById('dislike-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).dislikeCount;
                            document.getElementById('like-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).likeCount;
                        }
                    };
                    request.send(formData);
                });
            }
        });
    </script>
@endsection
