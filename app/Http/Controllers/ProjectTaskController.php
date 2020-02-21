<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{

    public function store(Project $project)
    {
        $attributes = request()->validate([
            'body' => 'required'
        ]);

        $project->addTask($attributes);
        return redirect($project->path());
    }
}
