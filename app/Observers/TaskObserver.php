<?php

namespace App\Observers;

use App\Task;

class TaskObserver
{
    /**
     * Handle the task "created" event.
     *
     * @param Task $task
     * @return void
     */
    public function created(Task $task)
    {
        $task->project->recordActivity('create_task');
    }
}
