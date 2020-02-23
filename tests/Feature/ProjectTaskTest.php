<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
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
    public function a_task_can_be_updated()
    {
        $this->withoutExceptionHandling();
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );
        $task = $project->addTask(['body' => 'Test task']);
        $this->patch($project->path() . '/tasks/' . $task->id, [
            'body' => 'changed',
            'completed' => true
        ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => true
        ]);
    }

    /**
     * @test
     */
    public function a_task_require_a_body()
    {
        $this->signIn();
        $project = factory(Project::class)->create(['owner_id' => auth()->id()]);
        $attributes = factory(Task::class)->raw(['body' => '']);
        $this->post($project->path() . '/tasks', $attributes)
            ->assertSessionHasErrors('body');
    }

    /**
     * @test
     */
    public function only_the_owner_of_project_may_add_tasks()
    {
        $this->signIn();
        $project = factory(Project::class)->create();
        $this->post($project->path() . '/tasks', ['body' => 'Test task'])
            ->assertForbidden();
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task']);
    }
}
