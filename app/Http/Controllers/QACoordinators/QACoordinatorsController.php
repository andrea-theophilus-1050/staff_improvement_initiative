<?php

namespace App\Http\Controllers\QACoordinators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Topics;
use App\Models\IdeaPosts;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QACoordinatorsController extends Controller
{
    public function index()
    {
        $staffs = User::where('role_id', 4)->where('dept_id', auth()->user()->dept_id)->get();
        return view('role-qa-coordinators.staff-management', compact(['staffs']))->with('title', 'QA Coordinators');
    }

    public function topics()
    {
        $topics = Topics::orderBy('created_at', 'desc')->get();
        return view('role-qa-coordinators.topics', compact(['topics']))->with('title', 'Topics Management');
    }

    public function topicIdeaPosts($id)
    {
        // $posts = IdeaPosts::join('users', 'users.user_id', '=', 'topics.user_id')->where('topic_id', $id)->orderBy('created_at', 'desc')->paginate(5);
        $posts = IdeaPosts::join('users', 'users.user_id', '=', 'idea_posts.user_id')
            ->where('topic_id', $id)
            ->where('users.dept_id', auth()->user()->dept_id)
            ->orderBy('idea_posts.created_at', 'desc')->paginate(5);
        $topicTitle = Topics::where('topic_id', $id)->first();
        $staffs = User::where('role_id', 4)->where('dept_id', auth()->user()->dept_id)->get();
        return view('role-qa-coordinators.staff-idea-posts', compact(['posts', 'id', 'topicTitle', 'staffs']))->with('title', 'Topics');
    }

    public function sendNotification($id)
    {
        $staffs = User::where('role_id', 4)->where('dept_id', auth()->user()->dept_id)->get();

        foreach ($staffs as $staff) {
            if (collect($staff->posts)->where('topic_id', $id)->count() == 0) {
                // DB::table('notification')->insert([
                //     'user_id' => $staff->user_id,
                //     'notify_content' => 'You have a new topic to submit your idea',
                //     'type_notification' => 'QACoordinator-newTopic',
                //     'url' => $id,
                //     'created_at' => Carbon::now(),
                //     'updated_at' => Carbon::now(),
                // ]);
                // check exists before submit to database
                $check = DB::table('notification')->where('user_id', $staff->user_id)->where('url', $id)->where('type_notification', 'QACoordinator-newTopic')->first();
                if (!$check) {
                    DB::table('notification')->insert([
                        'user_id' => $staff->user_id,
                        'notify_content' => 'You have a new topic to submit your idea',
                        'type_notification' => 'QACoordinator-newTopic',
                        'url' => $id,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Notification sent successfully');
    }
}
