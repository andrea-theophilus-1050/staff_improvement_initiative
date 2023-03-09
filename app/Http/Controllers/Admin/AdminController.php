<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;
use App\Models\Role;
use App\Mail\AccountInformationNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\RequestStack;

class AdminController extends Controller
{

    public function department_management()
    {
        $accounts = User::all();
        $depts = Department::all();
        return view('role-admin.department-management', compact(['depts', 'accounts']))->with('title', 'Department Management');
    }

    public function createDepartment(Request $request)
    {
        $dept = new Department();
        $dept->dept_name = $request->department;
        $dept->save();

        return redirect()->route('admin.department.management')->with('success', 'Department has been created');
    }

    public function updateDepartment(Request $request, $id)
    {
        $dept = Department::find($id);
        $dept->dept_name = $request->department;
        $dept->save();

        return redirect()->route('admin.department.management')->with('success', 'Department has been updated');
    }

    public function deleteDepartment($id)
    {
        $dept = Department::find($id);
        $dept->delete();

        return redirect()->route('admin.department.management')->with('success', 'Department has been deleted');
    }

    public function index()
    {
        return view('role-admin.index')->with('title', 'Admin Dashboard');
    }

    public function account_management()
    {
        $accounts = User::all();
        $depts = Department::all();
        $roles = Role::all();

        return view('role-admin.account-management', compact(['accounts', 'depts', 'roles']))->with('title', 'Account Management');
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

        return redirect()->route('admin.account.management')->with('success', 'Account has been created');
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

        return redirect()->route('admin.account.management')->with('success', 'Account has been updated');
    }

    public function deleteAccount($id)
    {
        try {
            $user = User::find($id);
            $user->delete();
            return redirect()->route('admin.account.management')->with('success', 'Account has been deleted');
        } catch (\Exception $e) {
            return redirect()->route('admin.account.management')->with('error', 'Account cannot be deleted');
        }
    }
}
