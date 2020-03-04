<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectInvitationsRequest;
use App\Project;
use App\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;

class ProjectInvitationsController extends Controller
{

    /**
     * Persist a new member on a project.
     *
     * @param ProjectInvitationsRequest $request
     * @param Project $project
     * @return RedirectResponse|Redirector
     */
    public function store(ProjectInvitationsRequest $request, Project $project)
    {
        $user = User::whereEmail($request->email)->first();

        $project->invite($user);
        return redirect($project->path());
    }
}
