<?php

namespace App\Http\Controllers;

use App\Models\State;
use Illuminate\Http\Request;

class StateController extends Controller
{
    public function index()
    {
        $jobs = State::orderBy('create_at', 'desc')->paginate(15);
        return view('home', compact('states'));
    }
}
