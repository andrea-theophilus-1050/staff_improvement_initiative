@extends('layouts.main')
@section('content')
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="media mb-2">
                        <div class="media-body d-flex justify-content-between align-items-center">
                            <h5 class="card-title" style="text-transform: none">Send notification for staffs</h5>
                            <a href="{{ route('qa-coordinators.send.notify', $topicTitle->topic_id) }}"
                                class="btn btn-primary" title="Send notify for staff who has no submited ideas yet"><i
                                    class="mdi mdi-bell-alert"></i></a>
                        </div>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Success!</strong> {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="media mb-2">
                        <div class="media-body">
                            <h5 class="card-title" style="text-transform: none">Topic name: {{ $topicTitle->topic_name }}
                            </h5>
                            <p>Topic description: {{ $topicTitle->topic_description }}</p>
                        </div>
                    </div>
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
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-3 d-flex">
                                    <button type="submit" id="like-button-{{ $post->post_id }}"
                                        class="btn btn-primary btn-sm d-flex justify-content-center align-items-center"
                                        disabled>
                                        <i class="mdi mdi-thumb-up"></i>
                                        &nbsp;&nbsp;
                                        <b id="like-count-{{ $post->post_id }}">
                                            {{ collect($post->like_dislike)->where('status', 'liked')->count() }}
                                        </b>&nbsp;&nbsp;Like
                                    </button>

                                    <button type="submit" id="dislike-button-{{ $post->post_id }}"
                                        class="btn btn-danger btn-sm d-flex justify-content-center align-items-center ml-2"
                                        disabled>
                                        <i class="mdi mdi-thumb-down"></i>
                                        &nbsp;&nbsp;
                                        <b id="dislike-count-{{ $post->post_id }}">
                                            {{ collect($post->like_dislike)->where('status', 'disliked')->count() }}
                                        </b>&nbsp;&nbsp;Dislike
                                    </button>


                                    <button
                                        class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
                                        data-toggle="collapse" data-target="#post-comment{{ $post->post_id }}">
                                        <i class="mdi mdi-comment"></i>
                                        &nbsp;&nbsp;
                                        <b id="comment-count-{{ $post->post_id }}">
                                            {{ $post->comments->count() }}
                                        </b>&nbsp;&nbsp; Comment
                                    </button>
                                </div>
                            </div>
                            <hr>
                            <div id="post-comment{{ $post->post_id }}" class="collapse">
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

    {{-- <script>
        // Handle like and dislike and comments functionality
        document.addEventListener("DOMContentLoaded", function() {
            var likeForms = document.querySelectorAll('form[id^="like-form-"]');
            var dislikeForms = document.querySelectorAll('form[id^="dislike-form-"]');
            var commentForms = document.querySelectorAll('form[id^="comment-form-"]');
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
                            var likeButton = document.getElementById('like-button-' + postId);
                            var dislikeButton = document.getElementById('dislike-button-' + postId);

                            // update the like count on the page for the specific post
                            document.getElementById('like-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).likeCount;
                            document.getElementById('dislike-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).dislikeCount;

                            // update the like button
                            if (JSON.parse(this.responseText).userStatus == 'liked') {
                                likeButton.classList.remove('btn-outline-primary');
                                likeButton.classList.add('btn-primary');
                                dislikeButton.classList.remove('btn-danger');
                                dislikeButton.classList.add('btn-outline-danger');
                            } else {
                                likeButton.classList.remove('btn-primary');
                                likeButton.classList.add('btn-outline-primary');
                                dislikeButton.classList.remove('btn-danger');
                                dislikeButton.classList.add('btn-outline-danger');
                            }
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
                            var likeButton = document.getElementById('like-button-' + postId);
                            var dislikeButton = document.getElementById('dislike-button-' + postId);

                            // update the dislike count on the page for the specific post
                            document.getElementById('dislike-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).dislikeCount;
                            document.getElementById('like-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).likeCount;

                            // update the like button
                            if (JSON.parse(this.responseText).userStatus == 'disliked') {
                                dislikeButton.classList.remove('btn-outline-danger');
                                dislikeButton.classList.add('btn-danger');
                                likeButton.classList.remove('btn-primary');
                                likeButton.classList.add('btn-outline-primary');
                            } else {
                                dislikeButton.classList.remove('btn-danger');
                                dislikeButton.classList.add('btn-outline-danger');
                                likeButton.classList.remove('btn-primary');
                                likeButton.classList.add('btn-outline-primary');
                            }
                        }
                    };
                    request.send(formData);
                });
            }

            // Add event listener for each comment form
            for (i = 0; i < commentForms.length; i++) {
                commentForms[i].addEventListener("submit", function(event) {
                    event.preventDefault(); // prevent form from submitting normally
                    var postId = this.dataset.postId; // get the post ID
                    var formData = new FormData(this); // get the form data
                    var request = new XMLHttpRequest();
                    request.open("POST", this.action);
                    request.onreadystatechange = function() {
                        if (this.readyState === 4 && this.status === 200) {
                            const commentSection = document.getElementById('comments-section-' +
                                postId);
                            const newComment = document.createElement('div');
                            newComment.classList.add('card', 'mb-2');
                            newComment.style.background = "#f5f7ff";

                            const innerHTML = `
                                            <div class="card-body">
                                                <div class="media">
                                                    <img src="{{ asset('img/avatar/${JSON.parse(this.responseText).commentAvatar}') }}"
                                                        style="width: 30px; height: 30px" class="mr-3"
                                                        alt="Profile Image">
                                                    <div class="media-body">
                                                        <p class="card-text"><b>${JSON.parse(this.responseText).commentFullname}:&nbsp;&nbsp;</b>${JSON.parse(this.responseText).newComment}</p>
                                                    </div>
                                                </div>
                                                <div class="media ml-5 mt-3">
                                                    <div class="mb-2 pull-right" style="font-size: 10px">
                                                        <i class="mdi mdi-calendar-clock"></i>&nbsp;&nbsp;${JSON.parse(this.responseText).commentCreated_at}
                                                    </div>
                                                </div>
                                            </div>`;

                            newComment.innerHTML = innerHTML;
                            commentSection.appendChild(newComment);

                            document.getElementById('comment-count-' + postId).innerHTML = JSON.parse(
                                this.responseText).commentCount;
                            document.getElementById('comment-text-' + postId).value = '';
                        }
                    };
                    request.send(formData);
                });
            }
        });
    </script> --}}
@endsection
