<?php

namespace App\Policies;

use App\Project;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProjectsPolicy
{
    use HandlesAuthorization;

    public function access(User $user, Project $project)
    {
        return $user->is($project->owner) || $project->members->contains($user);
    }

    public function owner(User $user, Project $project)
    {
        return $user->is($project->owner);
    }
}
