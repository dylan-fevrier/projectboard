<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Project extends Model
{

    use RecordsActivity;

    protected $guarded = [];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function activities()
    {
        return $this->hasMany(Activity::class);
    }

    public function addTask(array $attributes)
    {
        return $this->tasks()->create($attributes);
    }

    public function addTasks(array $tasks)
    {
        foreach ($tasks as $task) {
            if (isset($task['body'])) {
                $this->addTask($task);
            }
        }
    }

    public function invite(User $user)
    {
        $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

    public function hasMember(int $userId)
    {
        return DB::table('project_members')
            ->where('user_id', $userId)
            ->where('project_id', $this->id)
            ->exists();
    }
}
