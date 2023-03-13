<?php

namespace App\Http\Controllers;

use App\Models\IdeaPosts;
use Illuminate\Http\Request;
use App\Models\Notification;

class NotifyController extends Controller
{
    public function notificationHandlerTopic($type, $url, $notifyID)
    {
        if ($type == 'topicNew') {
            Notification::where('id', $notifyID)->delete();
            return redirect()->route('staff.topics.idea.posts', $url);
        }
        if ($type == 'comment') {
            Notification::where('id', $notifyID)->delete();
            $post = IdeaPosts::where('post_id', $url)->first();
            return view('role-staff.single-post', compact(['post']))->with('title', 'Single Post');
        }
        if ($type == "postIdeas") {
            Notification::where('id', $notifyID)->delete();
            $post = IdeaPosts::where('post_id', $url)->first();
            return view('role-qa-coordinators.staff-single-post', compact(['post']))->with('title', 'Single Post');
        }
    }
}
