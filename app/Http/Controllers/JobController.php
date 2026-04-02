<?php

namespace App\Http\Controllers;

use App\Models\Job;
class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('home', compact('jobs'));
    }
}