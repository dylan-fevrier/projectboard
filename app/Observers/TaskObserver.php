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

    /**
     * Handle the task "updated" event.
     *
     * @param Task $task
     * @return void
     */
    public function updated(Task $task)
    {
        if (!$task->completed) return;
        $task->project->recordActivity('complete_task');
    }
}
