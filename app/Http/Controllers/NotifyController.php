<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;

class NotifyController extends Controller
{
    public function notificationHandlerTopic($type, $id)
    {
        if ($type == 'topicNew') {
            Notification::where('user_id', auth()->user()->user_id)->where('type_notification', 'topicNew')->where('url', $id)->delete();
            return redirect()->route('staff.topics.idea.posts', $id);
        }
    }
}
