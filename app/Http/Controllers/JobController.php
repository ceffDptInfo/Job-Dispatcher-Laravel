<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::where('id_user', auth()->id());
        $filter = $request->query('filter');

        match ($filter) {
            'abc' => $query->reorder()->orderBy('name', 'asc'),
            'cba' => $query->reorder()->orderBy('name', 'desc'),
            'waiting' => $query->where('code_state', 'w'),
            'printing' => $query->where('code_state', 'p'),
            'finished' => $query->where('code_state', 'f'),
            'sliced' => $query->where('code_state', 's'),
            'error_printing' => $query->where('code_state', 'ep'),
            'error_slicing' => $query->where('code_state', 'es'),

            default => $query->reorder()->orderBy('create_at', 'desc'),
        };

        $jobs = $query->paginate(15)->withQueryString();

        return view('home', compact('jobs'));
    }

    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:50',
    //         'inputfile' => 'required|file',
    //         'id_slicer_profile' => 'required|integer',
    //     ]);

    //     $user = Auth::user();
    //     $projectName = Str::slug($request->name);

    //     $basePath = "\\\\PC-BD52-24\\NFS-Printers\\Users\\";
    //     $userFolder = $user->id . "-" . Str::slug($user->name);
    //     $folderPath = $basePath . $userFolder . "\\" . $projectName;

    //     if ($request->hasFile('inputfile')) {
    //         $file = $request->file('inputfile');
    //         $fileName = $file->getClientOriginalName();

    //         $file->storeAs($folderPath, $fileName, 'public');

    //         Job::create([
    //             'name' => $request->name,
    //             'path' => $folderPath,
    //             'code_state' => 'w',
    //             'stl_filename' => $fileName,
    //             'id_slicer_profile' => $request->id_slicer_profile,
    //             'id_user' => $user->id_user,
    //             'create_at' => now(),
    //         ]);

    //         return redirect()->route('home')->with('success', 'Job envoyé au serveur NFS !');
    //     }
    //     return back()->withErrors(['inputfile' => 'Erreur lors du transfert du fichier.']);
    // }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
            'inputfile' => 'required|file', // Ce sera le fichier orienté envoyé par le JS
            'id_slicer_profile' => 'required|integer',
        ]);

        $user = Auth::user();
        $projectName = Str::slug($request->name);

        // Configuration du chemin NFS
        $basePath = rtrim(config('app.nfs_base_path'), '\\') . '\\';
        $folderPath = $basePath . $user->id_user . "\\" . $projectName;

        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        $file = $request->file('inputfile');
        $fileName = $projectName . '-' . time() . '.stl';

        $file->move($folderPath, $fileName);

        Job::create([
            'name' => $request->name,
            'path' => $folderPath,
            'code_state' => 'w',
            'stl_filename' => $fileName,
            'id_slicer_profile' => $request->id_slicer_profile,
            'id_user' => $user->id_user,
            'create_at' => now(),
        ]);

        return response()->json(['success' => true, 'redirect' => route('home')]);
    }

    // Affiche la page de preview
    public function preview(Job $job)
    {
        return view('stl-orientation-viewer', compact('job'));
    }

    // Permet au JS de télécharger le fichier depuis le NFS
    public function downloadStl(Job $job)
    {
        $fullPath = $job->path . DIRECTORY_SEPARATOR . $job->stl_filename;
        if (file_exists($fullPath)) {
            return response()->file($fullPath);
        }
        abort(404);
    }

    public function destroy(Job $job)
    {
        if (is_dir($job->path)) {
            foreach (glob($job->path . "/*") as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($job->path);
        }

        $job->delete();
        return redirect()->route('home')->with('success', 'Job supprimé avec succès');
    }

    public function edit(Job $job)
    {
        return view('edit-job', compact('job'));
    }

    public function update(Request $request, Job $job)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_slicer_profile' => 'required|integer',
            'code_state' => 'required|string'
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
