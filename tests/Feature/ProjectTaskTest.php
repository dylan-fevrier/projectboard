<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTaskTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function a_project_can_have_task()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);

        $task = [
            'body' => 'Lorem ipsum facto set'
        ];

        $this->post($project->path() . '/tasks', $task);
        $this->get($project->path())
            ->assertSee($task['body']);
    }

    /**
     * @test
     */
    public function a_task_require_a_body()
    {
        $this->signIn();
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $this->post($project->path() . '/tasks', [])
            ->assertSessionHasErrors('body');
    }
}
