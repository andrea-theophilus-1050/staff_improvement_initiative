<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Department;

class AuthController extends Controller
{
    public function login_action(Request $request)
    {
        
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            Auth::login($user);

            if (Auth::user()->role_id == 1) {
                return redirect()->route('qa-leaders.topics.management');
            } else if (Auth::user()->role_id == 2) {
                return redirect()->route('qa-coordinators.index');
            } else if (Auth::user()->role_id == 3) {
                return redirect()->route('staff.index');
            }
        }
        return redirect()->route('login')->with('error', 'Email or password is incorrect')->withInput($request->only('email', 'password'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('auth.profile', compact('user'))->with('title', 'Profile');
    }

    public function changePassword(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();
        $request->validate([
            'currentPassword' => 'required',
            'newPassword' => 'required|min:8',
            'confirmPassword' => 'required|same:newPassword',
        ]);

        if (Hash::check($request->currentPassword, $user->password)) {
            $user->password = Hash::make($request->newPassword);
            $user->password_changed = 1;
            $user->save();
            return redirect()->route('profile')->with('success', 'Password has been changed');
        } else {
            return back()->with('error', 'Current password is incorrect');
        }
    }

    public function changeProfile(Request $request)
    {
        $user = User::where('user_id', Auth::user()->user_id)->first();

        $request->validate([
            'fullname' => 'required',
            'email' => 'required|email',
        ]);

        $checkEmailExists = User::where('email', $request->email)->where('user_id', '!=', $user->user_id)->first();
        if ($checkEmailExists) {
            return back()->with('errorProfile', 'Email already exists');
        }
        $user->fullName = $request->fullname;
        $user->email = $request->email;

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $extension = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extension;
            $file->move(public_path('img/avatar/'), $filename);
            $user->avatar = $filename;
        }

        $user->save();
        return redirect()->route('profile')->with('successProfile', 'Profile has been updated');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out');
    }
}
