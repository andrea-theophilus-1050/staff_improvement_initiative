<?php

namespace App\Http\Controllers\QALeaders;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QALeadersController extends Controller
{
    public function index()
    {
        return view('role-qa-leaders.index')->with('title', 'QA Leaders');
    }
}
