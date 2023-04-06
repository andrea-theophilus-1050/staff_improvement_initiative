<?php

namespace App\Http\Controllers;

use App\Models\IdeaPosts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TopIdeasController extends Controller
{
    public function listOfTopIdeas($topicID)
    {
        $topLikedPosts = IdeaPosts::select('idea_posts.*', DB::raw('count(like_dislike.id) as like_count'))
            ->leftJoin('like_dislike', 'like_dislike.post_id', '=', 'idea_posts.post_id')
            ->where('idea_posts.topic_id', $topicID)
            ->where('like_dislike.status', 'liked')
            ->groupBy('idea_posts.post_id', 'idea_posts.content', 'idea_posts.created_at', 'idea_posts.updated_at')
            ->orderBy('like_count', 'desc')
            ->take(5)
            ->get();

        $topCommentPosts = IdeaPosts::select('idea_posts.*', DB::raw('count(comments.comment_id) as comment_count'))
            ->leftJoin('comments', 'comments.post_id', '=', 'idea_posts.post_id')
            ->where('idea_posts.topic_id', $topicID)
            ->groupBy('idea_posts.post_id', 'idea_posts.content', 'idea_posts.created_at', 'idea_posts.updated_at')
            ->orderBy('comment_count', 'desc')
            ->take(5)
            ->get();

        return view('top-ideas.top-ideas', compact(['topLikedPosts', 'topCommentPosts']))->with('title', 'List of TOP ideas');
    }
}
