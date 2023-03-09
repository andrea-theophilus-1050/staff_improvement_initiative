<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function login_action(Request $request)
    {
        $remember = $request->has('remember_me') ? true : false;
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            Auth::login($user, $remember);

            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.index');
            } else if (Auth::user()->role_id == 2) {
                return redirect()->route('qa-leaders.index');
            } else if (Auth::user()->role_id == 3) {
                return redirect()->route('qa-coordinators.index');
            } else if (Auth::user()->role_id == 4) {
                return redirect()->route('staff.index');
            }
        }
        return redirect()->route('login')->with('error', 'Email or password is incorrect')->withInput($request->only('email', 'password'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out');
    }
}
