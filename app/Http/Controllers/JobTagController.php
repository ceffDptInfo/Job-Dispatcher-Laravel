<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Tag;
use Illuminate\Http\Request;

class JobTagController extends Controller
{
    public function destroy(Job $job, Tag $tag)
    {
        $job->tags()->detach($tag->id_tag);
        return back()->with('success');
    }

    public function store(Request $request, Job $job)
    {
        $request->validate([
            'tag_id' => 'required|exists:tags,id_tag',
        ]);

        $job->tags()->syncWithoutDetaching([$request->tag_id]);

        return back()->with('success');
    }
}