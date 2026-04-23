<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::orderBy('create_at', 'desc')->paginate(15);
        return view('home', compact('jobs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'inputfile' => 'required|file',
            'id_slicer_profile' => 'required|integer',
        ]);

        $user = Auth::user();
        $projectName = Str::slug($request->name);

        $basePath = "\\\\PC-BD52-24\\NFS-Printers\\Users\\";
        $userFolder = $user->id . "-" . Str::slug($user->name);
        $folderPath = $basePath . $userFolder . "\\" . $projectName;

        if ($request->hasFile('inputfile')) {
            $file = $request->file('inputfile');
            $fileName = $file->getClientOriginalName();

            $file->storeAs($folderPath, $fileName, 'public');

            Job::create([
                'name' => $request->name,
                'path' => $folderPath,
                'name_state' => 'waiting',
                'stl_filename' => $fileName,
                'id_slicer_profile' => $request->id_slicer_profile,
                'id_user' => $user->id_user,
                'create_at' => now(),
            ]);

            return redirect()->route('home')->with('success', 'Job envoyé au serveur NFS !');
        }
        return back()->withErrors(['inputfile' => 'Erreur lors du transfert du fichier.']);
    }

    public function destroy(Job $job)
    {
        $job->delete();
        return redirect()->route('home')->with('success', 'Job supprimé avec succès');
    }

    public function edit(Job $job)
    {
        return view('edit', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_slicer_profile' => 'required|integer',
            'name_state' => 'required|string'
        ]);
        if ($request->hasFile('stl_filename')) {
            $file = $request->file('stl_filename');
            $fileName = $file->getClientOriginalName();
            $file->storeAs($job->path, $fileName, 'public');
            $validated['stl_filename'] = $fileName;
        }

        $job->update($validated);
        return redirect()->route('home')->with('success', 'Job mis à jour !');
    }
}