<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{

    /**
     * Persist one task for project.
     *
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
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

    /**
     * Update task for project.
     *
     * @param Project $project
     * @param Task $task
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Project $project, Task $task)
    {
        if (auth()->user()->isNot($project->owner)) {
            abort(403);
        }
        $task->update([
            'body' => request('body'),
            'completed' => request()->has('completed')
        ]);
        return redirect($project->path());
    }
}
