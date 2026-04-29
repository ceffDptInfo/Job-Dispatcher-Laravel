<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Job;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function create()
    {
        return view('gestion-tag');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Tag::create([
            'name' => $request->name,
            'id_user' => auth()->id(),
        ]);

        return redirect()->back()->with('success');
    }

    public function assign(Job $job)
    {
        $tags = Tag::where('id_user', auth()->id())->get();
        return view('gestion-tag', compact('job', 'tags'));
    }

    public function storeRelation(Request $request, Job $job)
    {
        $request->validate([
            'id_tag' => 'required|exists:tag,id_tag',
        ]);

        $job->tags()->syncWithoutDetaching([$request->id_tag]);

        return redirect()->route('home')->with('success');
    }

    public function destroy(Request $request)
    {
        $tagId = $request->input('id_tag');
        $tag = Tag::where('id_tag', $tagId)
            ->where('id_user', auth()->id())
            ->first();

        if ($tag) {
            $tag->delete();
            return back()->with('success');
        }
        return back()->with('error');
    }
}