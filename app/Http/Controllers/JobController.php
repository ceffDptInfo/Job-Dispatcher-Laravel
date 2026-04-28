<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Material;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function getMaterialDetails($id)
    {
        $material = Material::with(['profiles', 'colors'])->find($id);
        if (!$material) {
            return response()->json(['error' => 'Matériau non trouvé'], 404);
        }

        return response()->json([
            'profiles' => $material->profiles,
            'colors'   => $material->colors,
        ]);

    }

    public function index(Request $request)
    {
        $filter = $request->get('filter');
        $query = Job::where('id_user', auth()->id());

        if ($filter) {
            if (str_starts_with($filter, 'tag_')) {
                $tagId = str_replace('tag_', '', $filter);

                $query->whereHas('tags', function ($q) use ($tagId) {
                    $q->where('tag.id_tag', $tagId);
                });
            } else {
                match ($filter) {
                    'abc' => $query->orderBy('name', 'asc'),
                    'cba' => $query->orderBy('name', 'desc'),
                    'waiting' => $query->where('status', 'waiting'),
                    default => $query->orderBy('create_at', 'desc'),
                };
            }
        } else {
            $query->orderBy('create_at', 'desc');
        }

        $jobs = $query->get();
        $tags = Tag::where('id_user', auth()->id())->get();

        return view('home', compact('jobs', 'tags'));
    }

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

    public function updateTags(Request $request, Job $job)
    {
        $request->validate([
            'id_tag' => 'required|exists:tags,id_tag',
        ]);

        $job->tags()->syncWithoutDetaching([$request->id_tag]);

        return redirect()->route('home')->with('success', 'Tag assigné !');
    }
}
