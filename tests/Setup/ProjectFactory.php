<?php

namespace Tests\Setup;

use App\Project;
use App\Task;
use App\User;

class ProjectFactory
{

    protected $taskCount = 0;

    protected $owner;

    public function withTasks($count)
    {
        $this->taskCount = $count;

        return $this;
    }

    public function ownedBy($owner)
    {
        $this->owner = $owner;

        return $this;
    }

    public function create()
    {
        $project = factory(Project::class)->create([
            'owner_id' => $this->owner ?? factory(User::class)
        ]);

        factory(Task::class, $this->taskCount)->create([
           'project_id' => $project->id
        ]);

        return $project;
    }
}
