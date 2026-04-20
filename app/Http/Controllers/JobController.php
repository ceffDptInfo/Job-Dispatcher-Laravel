<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::all();
        return view('home', compact('jobs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'              => 'required|string|max:50',
            'path'              => 'required|string|max:200',
            'name_state'        => 'required|string|exists:state,name',
            'stl_filename'      => 'required|string|max:100',
            'gcode_filename'    => 'nullable|string|max:100',
            'filament'          => 'nullable|numeric|min:0',
            'duration'          => 'nullable|numeric|min:0',
            'create_at'         => 'required|date',
            'slice_at'          => 'nullable|date',
            'print_at'          => 'nullable|date',
            'finish_at'         => 'nullable|date',
            'id_printer'        => 'nullable|integer',

            'id_slicer_profile' => 'required|exists:slicer_profiles,id',
            'id_user'           => 'required|exists:users,id',
        ]);

        Job::create([
            'name' => $validated['name'],
            'path' => $validated['path'],
            'name_state' => $validated['name_state'],
            'stl_filename' => $validated['stl_filename'],
            'id_slicer_profile' => $validated['id_slicer_profile'],
            'id_user' => Auth::id(), 
            'create_at' => now(), 
        ]);

        return redirect()->route('jobs.index')->with('success', 'Job created successfully!');
    }
}