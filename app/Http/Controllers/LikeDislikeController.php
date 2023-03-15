<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsLikeDislike;
use App\Models\IdeaPosts;
use App\Models\Comments;
use App\Models\Notification;


class LikeDislikeController extends Controller
{
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

    public function submitComment(Request $request, $postID)
    {
        $request->validate([
            'commentContent' => 'required',
        ]);

        $comment = new Comments();
        $comment->comment_content = $request->commentContent;
        $comment->post_id = $postID;
        $comment->anonymous = $request->commentAnonymous;
        $comment->user_id = auth()->user()->user_id;
        $comment->save();

        $notifyForPostsUser = IdeaPosts::where('post_id', $postID)->first();

        if (auth()->user()->user_id != $notifyForPostsUser->user_id) {
            $checkExists = Notification::where('user_id', $notifyForPostsUser->user_id)->where('url', $postID)->where('type_notification', 'comment')->first();
            if ($checkExists != null) {
                $checkExists->delete();
            }

            $notify = new Notification();
            $notify->user_id = $notifyForPostsUser->user_id;
            $notify->notify_content = 'Someone commented on your post';
            $notify->url = $postID;
            $notify->type_notification = 'comment';
            $notify->save();
        }
        $commentCount = Comments::where('post_id', $postID)->count();

        if ($comment->anonymous == 1) {
            $comment->fullname = "<i>(Anonymous)</i>";
            $comment->avatar = "default-avt.jpg";
        } else {
            $comment->fullname = $comment->user->fullName;
            if ($comment->user->avatar == null) {
                $comment->avatar = "default-avt.jpg";
            } else {
                $comment->avatar = $comment->user->avatar;
            }
        }

        return response()->json(['newComment' => $comment->comment_content, 'commentCount' => $commentCount, 'commentCreated_at' => \Carbon\Carbon::parse($comment->created_at)->diffForHumans(), 'commentFullname' => $comment->fullname, 'commentAvatar' => $comment->avatar]);
    }
}
