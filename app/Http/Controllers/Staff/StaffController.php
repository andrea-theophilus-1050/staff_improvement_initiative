<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use App\Models\IdeaPosts;
use Illuminate\Http\Request;
use App\Models\Topics;
use App\Models\Comments;
use App\Models\Notification;
use App\Models\PostsLikeDislike;
use App\Models\User;
use App\Models\Documents;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


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
        
        if($request->hasFile('idea_file')){
            $file = $request->file('idea_file');
            $filename = time() . '.' . $file->getClientOriginalExtension();

            $file->storeAs('public/idea_files', $filename);
            Documents::create([
                'doc_name' => $filename,
                'post_id' => $post->post_id,
            ]);
        }

        $notifyForQACoordinator = User::where('role_id', 3)->where('dept_id', auth()->user()->dept_id)->get();
        foreach ($notifyForQACoordinator as $notify) {
            DB::table('notification')->insert([
                'user_id' => $notify->user_id,
                'notify_content' => 'Your staff posted an idea',
                'url' => $post->post_id,
                'type_notification' => 'postIdeas',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

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
        $comment->anonymous = $request->commentAnonymous;
        $comment->user_id = auth()->user()->user_id;
        $comment->save();

        $notifyForPostsUser = IdeaPosts::where('post_id', $postID)->first();

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

        $commentCount = Comments::where('post_id', $postID)->count();

        if ($comment->anonymous == 1) {
            $comment->fullname = "<i>(Anonymous)</i>";
            $comment->avatar = "default-avt.jpg";
        } else {
            $comment->fullname = $comment->user->fullName;
            $comment->avatar = $comment->user->avatar;
        }

        return response()->json(['newComment' => $comment->comment_content, 'commentCount' => $commentCount, 'commentCreated_at' => \Carbon\Carbon::parse($comment->created_at)->diffForHumans(), 'commentFullname' => $comment->fullname, 'commentAvatar' => $comment->avatar]);
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
