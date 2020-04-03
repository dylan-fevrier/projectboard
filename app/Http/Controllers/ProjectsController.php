<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProjectsController extends Controller
{

    /**
     * View all projects.
     *
     * @return Factory
     */
    public function index()
    {
        $projects = auth()->user()->allProjects();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show a project.
     *
     * @param Project $project
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function show(Project $project)
    {
        $this->authorize('access', $project);

        return view('projects.show', compact('project'));
    }

    /**
     * Create a new project.
     *
     * @return Factory
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Persist project.
     *
     * @return mixed
     */
    public function store()
    {
        $project = auth()->user()->projects()->create($this->validateProject());

        if ($tasks = request('tasks')) {
            $project->addTasks($tasks);
        }

        if (request()->wantsJson()) {
            return response()
                ->json(['message' => $project->path()]);
        }

        return redirect($project->path());
    }

    /**
     * Edit a project.
     *
     * @param Project $project
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Project $project)
    {
        $this->authorize('access', $project);

        return view('projects.edit', compact('project'));
    }

    /**
     * Update a project
     *
     * @param Project $project
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Project $project)
    {
        $this->authorize('access', $project);

        $project->update($this->validateProject());
        return redirect($project->path());
    }

    /**
     * Delete project.
     *
     * @param Project $project
     * @return \Illuminate\Http\JsonResponse|RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function destroy(Project $project)
    {
        $this->authorize('owner', $project);

        $project->delete();

        if (request()->wantsJson()) {
            return response()
                ->json(['message' => 'success'], 204);
        }

        return redirect('/projects');
    }

    /**
     * Validate the request attributes.
     *
     * @return array
     */
    protected function validateProject()
    {
        return request()->validate([
            'title' => 'sometimes|required',
            'description' => 'sometimes|required',
            'notes' => 'nullable'
        ]);
    }
}
