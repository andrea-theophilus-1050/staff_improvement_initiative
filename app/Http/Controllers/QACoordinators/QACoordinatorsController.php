<?php

namespace App\Http\Controllers\QACoordinators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class QACoordinatorsController extends Controller
{
    public function index()
    {
        $staffs = User::where('role_id', 4)->where('dept_id', auth()->user()->dept_id)->get();
        return view('role-qa-coordinators.staff-management', compact(['staffs']))->with('title', 'QA Coordinators');
    }
}
