<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostsLikeDislike;

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
}
