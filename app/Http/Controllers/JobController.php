<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            'inputfile' => 'required|file',
            'id_slicer_profile' => 'required|integer',
        ]);

        $user = Auth::user();
        $projectName = Str::slug($request->name);

        // Construction du chemin NFS
        $basePath = "\\\\PC-BD52-24\\NFS-Printers\\Users\\";
        $userFolder = $user->id_user;
        $folderPath = $basePath . $userFolder . "\\" . $projectName;

        if ($request->hasFile('inputfile')) {
            $file = $request->file('inputfile');
            $fileName = $file->getClientOriginalName();

            // CRUCIAL : Créer le dossier s'il n'existe pas sur le NFS
            if (!file_exists($folderPath)) {
                mkdir($folderPath, 0777, true);
            }

            // On utilise move() au lieu de storeAs() pour les chemins absolus hors projet
            $file->move($folderPath, $fileName);

            $job = Job::create([
                'name' => $request->name,
                'path' => $folderPath,
                'code_state' => 'pp', // État : Pending Preview
                'stl_filename' => $fileName,
                'id_slicer_profile' => $request->id_slicer_profile,
                'id_user' => $user->id_user,
                'create_at' => now(),
            ]);

            return redirect()->route('jobs.preview', $job->id_job)
                ->with('info', 'Fichier chargé. Ajustez l\'orientation.');
        }
    }

    // Affiche la page de preview
    public function preview(Job $job)
    {
        return view('preview-kiri-moto', compact('job'));
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
        $job->delete();
        return redirect()->route('home')->with('success', 'Job supprimé avec succès');
    }

    public function edit(Job $job)
    {
        return view('edit-job', compact('job'));
    }

    // public function update(Request $request, Job $job)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'id_slicer_profile' => 'required|integer',
    //         'code_state' => 'required|string'
    //     ]);
    //     if ($request->hasFile('stl_filename')) {
    //         $file = $request->file('stl_filename');
    //         $fileName = $file->getClientOriginalName();
    //         $file->storeAs($job->path, $fileName, 'public');
    //         $validated['stl_filename'] = $fileName;
    //     }

    //     $job->update($validated);
    //     return redirect()->route('home')->with('success', 'Job mis à jour !');
    // }

    public function update(Request $request, Job $job)
    {
        Log::info("Update reçu pour le job : " . $job->id_job);

        // Validation
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'id_slicer_profile' => 'required|integer',
            'code_state' => 'required|string' // Recevra "w"
        ]);

        // Si Kiri:Moto nous envoie le nouveau binaire STL
        if ($request->hasFile('stl_filename')) {
            $file = $request->file('stl_filename');

            // On récupère le nom d'origine stocké en base pour écraser le bon fichier
            $fileName = $job->stl_filename;

            // On déplace le fichier vers le NFS (écrase l'ancien)
            $file->move($job->path, $fileName);

            $validated['stl_filename'] = $fileName;
        }

        // Mise à jour de la base de données (l'état passera de 'pp' à 'w')
        $job->update($validated);

        // On répond en JSON car c'est un appel Fetch/AJAX
        return response()->json([
            'status' => 'success',
            'redirect' => route('home')
        ]);
    }
}
