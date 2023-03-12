<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\IdeaPosts;
use Illuminate\Http\Request;
use App\Models\Topics;
use App\Models\Comments;
use App\Models\PostsLikeDislike;

class StaffController extends Controller
{
    public function index()
    {
        $topics = Topics::orderBy('created_at', 'desc')->paginate(10);
        return view('role-staff.index', compact(['topics']))->with('title', 'Staff Dashboard');
    }

    public function topics($id)
    {
        $posts = IdeaPosts::where('topic_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        $topicTitle = Topics::where('topic_id', $id)->first();
        return view('role-staff.topics', compact(['posts', 'id', 'topicTitle']))->with('title', 'Topics');
    }

    public function posts()
    {
        return view('role-staff.posts')->with('title', 'Posts');
    }

    public function createPost(Request $request, $id)
    {
        // $request->validate([
        //     'content' => 'required',
        // ]);

        $post = new IdeaPosts();
        // $post->title = $request->title;
        $post->content = $request->content;
        $post->topic_id = $id;
        $post->user_id = auth()->user()->user_id;
        $post->save();

        return redirect()->route('staff.topics.idea.posts', $id)->with('success', 'Post has been submitted');
    }

    // public function submitComment(Request $request, $postID, $topicID)
    // {
    //     $request->validate([
    //         'commentContent' => 'required',
    //     ]);

    //     $comment = new Comments();
    //     $comment->comment_content = $request->commentContent;
    //     $comment->post_id = $postID;
    //     $comment->user_id = auth()->user()->user_id;
    //     $comment->save();

    //     return redirect()->route('staff.topics.idea.posts', $topicID)->with('success', 'Comment has been submitted');
    // }

    public function submitComment(Request $request, $postID, $topicID)
    {
        $request->validate([
            'commentContent' => 'required',
        ]);

        $comment = new Comments();
        $comment->comment_content = $request->commentContent;
        $comment->post_id = $postID;
        $comment->user_id = auth()->user()->user_id;
        $comment->save();

        return redirect()->route('staff.topics.idea.posts', $topicID)->with('success', 'Comment has been submitted');
    }

    public function likeDislike($topicID, $postID, $status)
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

        return redirect()->route('staff.topics.idea.posts', $topicID)->with('success', 'Like/Dislike has been submitted');
    }
}
