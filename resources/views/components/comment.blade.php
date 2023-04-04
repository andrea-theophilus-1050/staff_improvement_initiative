<div id="post-comment{{ $post->post_id }}" class="collapse" style="transition: height 0.5s ease-out; overflow: hidden">
    <h6>Comments:</h6>
    <div id="comments-section-{{ $post->post_id }}">
        @foreach (collect($post->comments) as $comment)
            <div class="card mb-2" style="background: #f5f7ff">
                <div class="card-body">
                    <div class="media">
                        @if ($comment->anonymous == 1 || $comment->user->avatar == null)
                            <img src="{{ asset('img/default-avt.jpg') }}" style="width: 30px; height: 30px" class="mr-3"
                                alt="Profile Image">
                        @else
                            <img src="{{ asset('img/avatar/' . $comment->user->avatar) }}"
                                style="width: 30px; height: 30px" class="mr-3" alt="Profile Image">
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
    @if ($deadline2->isFuture())
        <hr>
        <form method="POST" id="comment-form-{{ $post->post_id }}" data-post-id="{{ $post->post_id }}"
            action="{{ route('staff.posts.comments.submit', [$post->post_id]) }}">
            @csrf
            <div class="form-group">
                <label for="comment-text">Add a comment:</label>
                {{-- <textarea class="form-control" id="comment-text-{{ $post->post_id }}" name="commentContent" rows="3" required></textarea> --}}
                <input type="text" class="form-control" id="comment-text-{{ $post->post_id }}" name="commentContent"required>
            </div>
            <div class="form-group col-md-4 col-sm-12 d-flex justify-content-between align-items-center">
                <label for=""><b>Anonymous</b></label>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="commentAnonymous" id="commentAnonymous"
                            value="1">
                        Yes
                    </label>
                </div>
                <div class="form-check">
                    <label class="form-check-label">
                        <input type="radio" class="form-check-input" name="commentAnonymous" id="commentAnonymous"
                            value="0" checked>
                        No
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <button type="submit" class="btn btn-primary btn-sm ml-3">Submit</button>
                <button type="button" class="btn btn-outline-success btn-sm ml-2" data-toggle="collapse"
                    data-target="#post-comment{{ $post->post_id }}">
                    Hide
                </button>
            </div>
        </form>
    @endif
</div>
