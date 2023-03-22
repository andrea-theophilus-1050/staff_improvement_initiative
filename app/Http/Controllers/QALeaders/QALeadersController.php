<?php

namespace App\Http\Controllers\QALeaders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\AccountInformationNotification;
use App\Models\Department;
use App\Models\Role;
use App\Models\IdeaPosts;
use App\Models\Notification;
use App\Models\Topics;
use App\Models\User;
use App\Models\TopicDeadline;


class QALeadersController extends Controller
{
    public function topics()
    {
        $deadlines = TopicDeadline::orderBy('firstClosureDate', 'desc')->get();
        $nonDeadline_topics = Topics::where('deadline_id', null)->orderBy('created_at', 'desc')->get();

        return view('role-qa-leaders.topics', compact(['deadlines', 'nonDeadline_topics']))->with('title', 'QA Leaders');
    }

    public function createTopics(Request $request)
    {
        $request->validate([
            'topicName' => 'required',
        ]);

        $topic = new Topics();
        $topic->topic_name = $request->topicName;
        $topic->topic_description = $request->description;
        $topic->save();

        return redirect()->route('qa-leaders.topics.management')->with('success', 'Topic has been created');
    }

    public function assignDeadlineToTopic(Request $request)
    {
        $deadline = new TopicDeadline();
        $deadline->firstClosureDate = $request->firstClosureDate;
        $deadline->finalClosureDate = $request->finalClosureDate;
        $deadline->save();

        $topicID = $request->input('topicID');

        foreach ($topicID as $id) {
            $topic = Topics::where('topic_id', $id)->first();
            $topic->deadline_id = $deadline->deadline_id;
            $topic->save();

            $notifyUsers = User::where('role_id', '!=', 1)->get();
            foreach ($notifyUsers as $user) {
                if ($user->role_id == 3) {
                    Notification::insert([
                        'user_id' => $user->user_id,
                        'notify_content' => 'New topic has been created: "' . $topic->topic_name . '"',
                        'url' => $topic->topic_id,
                        'type_notification' => 'topicNew',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                } elseif ($user->role_id == 2) {
                    Notification::insert([
                        'user_id' => $user->user_id,
                        'notify_content' => 'New topic has been created: "' . $topic->topic_name . '"',
                        'url' => $topic->topic_id,
                        'type_notification' => 'NewTopicFromQALeaders',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }

        return back()->with('success', 'Deadline has been assigned to topic');
    }

    public function updateDeadline(Request $request, $id)
    {
        $deadline = TopicDeadline::where('deadline_id', $id)->first();
        $deadline->firstClosureDate = $request->firstClosureDate;
        $deadline->finalClosureDate = $request->finalClosureDate;
        $deadline->save();

        return back()->with('success', 'Deadline has been updated');
    }

    public function updateTopics(Request $request, $id)
    {
        $request->validate([
            'topicName' => 'required',
        ]);

        $topic = Topics::where('topic_id', $id)->first();
        $topic->topic_name = $request->topicName;
        $topic->topic_description = $request->description;


        $deadline = TopicDeadline::where('firstClosureDate', $request->firstClosureDate)->where('finalClosureDate', $request->finalClosureDate)->first();
        
        if (!$deadline) {
            $deadline = new TopicDeadline();
            $deadline->firstClosureDate = $request->firstClosureDate;
            $deadline->finalClosureDate = $request->finalClosureDate;
            $deadline->save();
        }

        $topic->deadline_id = $deadline->deadline_id;
        $topic->save();


        return redirect()->route('qa-leaders.topics.management')->with('success', 'Topic has been updated');
    }

    public function deleteTopics($id)
    {
        $topic = Topics::where('topic_id', $id)->first();
        $topic->delete();

        Notification::where('url', $id)
            ->where(function ($query) {
                $query->where('type_notification', 'topicNew')
                    ->orWhere('type_notification', 'NewTopicFromQALeaders');
            })->delete();

        return redirect()->back()->with('success', 'Topic has been deleted');
    }


    public function ideaPosts($id)
    {
        $posts = IdeaPosts::where('topic_id', $id)->orderBy('created_at', 'desc')->paginate(20);
        $onTopic = Topics::where('topic_id', $id)->first();
        return view('role-qa-leaders.idea-posts', compact(['posts', 'onTopic']))->with('title', 'Idea Posts');
    }



















    public function department_management()
    {
        $accounts = User::all();
        $depts = Department::all();
        return view('role-qa-leaders.department-management', compact(['depts', 'accounts']))->with('title', 'Department Management');
    }

    public function createDepartment(Request $request)
    {
        $dept = new Department();
        $dept->dept_name = $request->department;
        $dept->save();

        return redirect()->route('qa-leaders.department.management')->with('success', 'Department has been created');
    }

    public function updateDepartment(Request $request, $id)
    {
        $dept = Department::find($id);
        $dept->dept_name = $request->department;
        $dept->save();

        return redirect()->route('qa-leaders.department.management')->with('success', 'Department has been updated');
    }

    public function deleteDepartment($id)
    {
        $dept = Department::find($id);
        $dept->delete();

        return redirect()->route('qa-leaders.department.management')->with('success', 'Department has been deleted');
    }


    public function account_management()
    {
        $accounts = User::where('user_id', '!=', auth()->user()->user_id)->orderBy('role_id', 'asc')->paginate(25);
        $depts = Department::all();
        $roles = Role::all();

        return view('role-qa-leaders.account-management', compact(['accounts', 'depts', 'roles']))->with('title', 'Account Management');
    }

    public function storeAccount(Request $request)
    {

        //validate 
        $validator = Validator::make($request->all(), [
            'fullname' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
            'department' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = new User();
        $user->fullName = $request->fullname;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->dept_id = $request->department;
        $user->save();

        if ($user->save()) {
            $user->plainPassword = $request->password;
            $user->role_name = Role::where('role_id', $request->role)->first()->role_name;
            $user->dept_name = Department::where('dept_id', $request->department)->first()->dept_name;
        }

        // send account information notification email
        Mail::to($request->email)->send(new AccountInformationNotification($user));

        return redirect()->route('qa-leaders.account.management')->with('success', 'Account has been created');
    }

    public function updateAccount(Request $request, $id)
    {


        $user = User::find($id);
        $user->fullName = $request->fullname;
        $user->email = $request->email;
        $user->role_id = $request->role;
        $user->dept_id = $request->department;
        if ($request->password != null) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->route('qa-leaders.account.management')->with('success', 'Account has been updated');
    }

    public function deleteAccount($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('qa-leaders.account.management')->with('success', 'Account has been deleted');
        } catch (\Exception $e) {
            return redirect()->route('qa-leaders.account.management')->with('error', 'Account cannot be deleted');
        }
    }
}
