<?php

namespace App\Http\Controllers\QACoordinators;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class QACoordinatorsController extends Controller
{
    public function index()
    {
        return view('role-qa-coordinators.index')->with('title', 'QA Coordinators');
    }
}
