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

        // $basePath = config('services.nfs.path');
        // $folderName = Str::slug($user->id_user) . '-' . Str::slug($user->name);
        // $userFolderPath = $basePath . DIRECTORY_SEPARATOR . $folderName;

        // if (!File::exists($userFolderPath)) {
        //     File::makeDirectory($userFolderPath, 0755, true);
        // }

        $basePath = "\\\\PC-BD52-24\\NFS-Printers\\Users\\";
        $userFolder = $user->id . "-" . Str::slug($user->name);
        $folderPath = $basePath . $userFolder . "\\" . $projectName;

        if ($request->hasFile('inputfile')) {
            $file = $request->file('inputfile');
            $fileName = $file->getClientOriginalName();
            
            $file->storeAs($folderPath, $fileName, 'public');

            Job::create([
                'name'              => $request->name,
                'path'              => $folderPath, 
                'name_state'        => 'waiting',
                'stl_filename'      => $fileName,
                'id_slicer_profile' => $request->id_slicer_profile,
                'id_user'           => $user->id_user,
                'create_at'         => now(),
            ]);

            return redirect()->route('home')->with('success', 'Job envoyé au serveur NFS !');
        }
            return back()->withErrors(['inputfile' => 'Erreur lors du transfert du fichier.']);

    }
}