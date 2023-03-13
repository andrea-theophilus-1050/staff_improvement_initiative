<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\IdeaPosts;
use Illuminate\Http\Request;
use App\Models\Topics;
use App\Models\Comments;
use App\Models\PostsLikeDislike;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StaffController extends Controller
{
    public function index()
    {
        $topics = Topics::orderBy('created_at', 'desc')->paginate(10);
        return view('role-staff.index', compact(['topics']))->with('title', 'Staff Dashboard');
    }

    public function topicIdeaPosts($id)
    {
        $posts = IdeaPosts::where('topic_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        $topicTitle = Topics::where('topic_id', $id)->first();
        $relatedTopic = Topics::where('topic_id', '!=', $id)->orderBy('created_at', 'desc')->take(5)->get();
        return view('role-staff.topics', compact(['posts', 'id', 'topicTitle', 'relatedTopic']))->with('title', 'Topics');
    }

    public function ownPosts()
    {
        $ownPosts = IdeaPosts::where('user_id', auth()->user()->user_id)->orderBy('created_at', 'desc')->paginate(5);
        return view('role-staff.own-posts', compact(['ownPosts']))->with('title', 'Posts');

        // dd($ownPosts);
    }

    public function createPost(Request $request, $id)
    {
        // $request->validate([
        //     'content' => 'required',
        // ]);

        $post = new IdeaPosts();
        $post->content = $request->content;
        $post->topic_id = $id;
        $post->user_id = auth()->user()->user_id;
        $post->anonymous = $request->anonymous;
        $post->save();

        return redirect()->route('staff.topics.idea.posts', $id)->with('success', 'Post has been submitted');
    }

    public function submitComment(Request $request, $postID)
    {
        $request->validate([
            'commentContent' => 'required',
        ]);

        $comment = new Comments();
        $comment->comment_content = $request->commentContent;
        $comment->post_id = $postID;
        $comment->user_id = auth()->user()->user_id;
        $comment->save();

        $commentCount = Comments::where('post_id', $postID)->count();

        return response()->json(['newComment' => $comment->comment_content, 'commentCount' => $commentCount, 'commentCreated_at' => $comment->created_at->format('F d, Y - h:i:s a')]);
    }

    public function likeDislike($postID, $status)
    {
        $likeDislike = PostsLikeDislike::where('post_id', $postID)->where('user_id', auth()->user()->user_id)->first();

        if ($likeDislike == null) {
            $likeDislike = new PostsLikeDislike();
            $likeDislike->post_id = $postID;
            $likeDislike->user_id = auth()->user()->user_id;
            $likeDislike->status = $status;
            $likeDislike->save();
        } else {
            if ($status == "liked" && $likeDislike->status == "disliked") {
                $likeDislike->status = "liked";
                $likeDislike->save();
            } else if ($status == "disliked" && $likeDislike->status == "liked") {
                $likeDislike->status = "disliked";
                $likeDislike->save();
            } else {
                $likeDislike->delete();
            }
        }

        $likeCount = PostsLikeDislike::where('post_id', $postID)->where('status', 'liked')->count();
        $dislikeCount = PostsLikeDislike::where('post_id', $postID)->where('status', 'disliked')->count();

        // get the current user's status for this post
        $userStatus = null;
        $likeDislike = PostsLikeDislike::where('post_id', $postID)->where('user_id', auth()->user()->user_id)->first();
        if ($likeDislike) {
            $userStatus = $likeDislike->status;
        }


        return response()->json([
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount,
            'userStatus' => $userStatus
        ]);
    }
}
