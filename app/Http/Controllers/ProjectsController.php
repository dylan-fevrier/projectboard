<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
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
        $projects = auth()->user()->projects;
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
     * Persist Project.
     *
     * @return RedirectResponse
     */
    public function store()
    {
        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);

        $project = auth()->user()->projects()->create($attributes);
        return redirect($project->path());
    }

    /**
     * Update project.
     *
     * @param Project $project
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function update(Project $project)
    {
        $this->authorize('access', $project);

        $project->update(request(['notes']));
        return redirect($project->path());
    }
}
