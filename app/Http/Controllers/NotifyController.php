<?php

namespace App\Http\Controllers;

use App\Models\IdeaPosts;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\Topics;

class NotifyController extends Controller
{
    public function notificationHandlerTopic($type, $url, $notifyID)
    {
        // handle notify when new topic is created from QA Managers
        if ($type == 'topicNew') {
            Notification::where('id', $notifyID)->delete();
            return redirect()->route('staff.topics.idea.posts', $url);
        }

        // handle notify when someone comment on your posts
        if ($type == 'comment') {
            Notification::where('id', $notifyID)->delete();
            $post = IdeaPosts::where('post_id', $url)->first();
            $onTopic = Topics::where('topic_id', $post->topic_id)->first();
            return view('role-staff.single-post', compact(['post', 'onTopic']))->with('title', 'Single Post');
        }

        // handle notify when QA Coordinator notify you about new topic
        if ($type == 'QACoordinator-newTopic') {
            Notification::where('id', $notifyID)->delete();
            return redirect()->route('staff.topics.idea.posts', $url);
        }

        // handle notify for QA Coordinators when staff posts new idea
        if ($type == "postIdeas") {
            Notification::where('id', $notifyID)->delete();
            $post = IdeaPosts::where('post_id', $url)->first();
            $onTopic = Topics::where('topic_id', $post->topic_id)->first();
            return view('role-qa-coordinators.staff-single-post', compact(['post', 'onTopic']))->with('title', 'Single Post');
        }
    }
}
