<?php

namespace App\Http\Controllers;

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
     * @param Project $project
     * @return RedirectResponse|Redirector
     * @throws AuthorizationException
     */
    public function store(Project $project)
    {
        $this->authorize('owner', $project);

        $this->validateRequest();

        $user = User::whereEmail(request('email'))->first();

        $project->invite($user);
        return redirect($project->path());
    }

    /**
     * @return array
     */
    protected function validateRequest()
    {
        return request()->validate([
            'email' => 'exists:users,email'
        ], [
            'email.exists' => 'The user you are inviting must have an account.'
        ]);
    }
}
