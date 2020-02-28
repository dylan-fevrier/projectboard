<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectTaskController extends Controller
{

    /**
     * Persist one task for project.
     *
     * @param Project $project
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Project $project)
    {
        $this->authorize('access', $project);

        $project->addTask($this->validateTask());
        return redirect($project->path());
    }

    /**
     * Update task for project.
     *
     * @param Project $project
     * @param Task $task
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Project $project, Task $task)
    {
        $this->authorize('access', $project);

        $task->update($this->validateTask());

        if (request('completed')) {
            $task->complete();
        } else {
            $task->incomplete();
        }
        return redirect($project->path());
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateTask()
    {
        return request()->validate([
            'body' => 'required',
            'completed' => 'nullable'
        ]);
    }
}
