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
use Illuminate\Support\Str;
use ZipArchive;


class StaffController extends Controller
{
    public function index()
    {
        $topics = Topics::orderBy('created_at', 'desc')->get();

        return view('role-staff.index', compact(['topics']))->with('title', 'Staff Dashboard');
    }

    public function topicIdeaPosts($id)
    {
        $posts = IdeaPosts::where('topic_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        $onTopic = Topics::where('topic_id', $id)->first();
        $relatedTopic = Topics::where('topic_id', '!=', $id)->orderBy('created_at', 'desc')->take(5)->get();
        return view('role-staff.topics', compact(['posts', 'id', 'onTopic', 'relatedTopic']))->with('title', 'Topics');
    }

    public function ownPosts()
    {
        $ownPosts = IdeaPosts::where('user_id', auth()->user()->user_id)->orderBy('created_at', 'desc')->paginate(5);
        return view('role-staff.own-posts', compact(['ownPosts']))->with('title', 'Posts');

        // dd($ownPosts);
    }

    public function createPost(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        $post = new IdeaPosts();
        $post->content = $request->content;
        $post->topic_id = $id;
        $post->user_id = auth()->user()->user_id;
        $post->anonymous = $request->anonymous;
        $post->save();

        if ($request->hasFile('idea_file')) {
            foreach ($request->file('idea_file') as $file) {
                if ($post->anonymous == 1) {
                    $filename = time() . ' - ' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                } else {
                    $filename = $post->user->fullName . ' - Post_' . $post->post_id . ' - ' . Str::random(5) . '.' . $file->getClientOriginalExtension();
                }

                $file->storeAs('public/idea_files', $filename);
                Documents::create([
                    'doc_name' => $filename,
                    'post_id' => $post->post_id,
                ]);
            }
        }

        $notifyForQACoordinator = User::where('role_id', 2)->where('dept_id', auth()->user()->dept_id)->get();
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
        // dd($request->all());
    }

    
}
