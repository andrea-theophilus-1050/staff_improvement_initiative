<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('role-admin.index')->with('title', 'Admin Dashboard');
    }

    public function account_management()
    {
        return view('role-admin.account-management')->with('title', 'Account Management');
    }
}
