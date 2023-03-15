<form id="like-form-{{ $post->post_id }}" data-post-id="{{ $post->post_id }}" method="POST"
    action="{{ route('posts.like.dislike', [$post->post_id, 'liked']) }}">
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



<form id="dislike-form-{{ $post->post_id }}" data-post-id="{{ $post->post_id }}" method="POST"
    action="{{ route('posts.like.dislike', [$post->post_id, 'disliked']) }}">
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

<button class="btn btn-outline-success btn-sm d-flex justify-content-center align-items-center ml-2"
    data-toggle="collapse" data-target="#post-comment{{ $post->post_id }}">
    <i class="mdi mdi-comment"></i>
    &nbsp;&nbsp;
    <b id="comment-count-{{ $post->post_id }}">
        {{ $post->comments->count() }}
    </b>&nbsp;&nbsp; Comment
</button>
