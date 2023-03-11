<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        return view('role-staff.index')->with('title', 'Staff Dashboard');
    }

    public function topics()
    {
        return view('role-staff.topics')->with('title', 'Topics');
    }

    public function posts()
    {
        return view('role-staff.posts')->with('title', 'Posts');
    }

    
}
