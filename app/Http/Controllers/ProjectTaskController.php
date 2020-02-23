<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{

    public function store(Project $project)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        $attributes = request()->validate([
            'body' => 'required'
        ]);

        $project->addTask($attributes);
        return redirect($project->path());
    }
}
