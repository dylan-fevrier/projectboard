<?php

namespace Tests\Feature;

use App\Project;
use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Facades\Tests\Setup\ProjectFactory;
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
        $project = ProjectFactory::ownedBy($this->signIn())
            ->create();

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
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed'
        ]);
        $this->assertDatabaseHas('tasks', [
            'body' => 'changed'
        ]);
    }

    /**
     * @test
     */
    public function a_task_can_be_completed()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $this->patch($project->tasks->first()->path(), [
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
    public function a_task_can_be_no_completed()
    {
        $project = ProjectFactory::ownedBy($this->signIn())
            ->withTasks(1)
            ->create();

        $project->tasks->first()->complete();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => false
        ]);

        $this->assertDatabaseHas('tasks', [
            'body' => 'changed',
            'completed' => false
        ]);
    }

    /**
     * @test
     */
    public function a_task_require_a_body()
    {
        $project = ProjectFactory::ownedBy($this->signIn())->create();

        $attributes = factory(Task::class)
            ->raw(['body' => '']);

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

    /**
     * @test
     */
    public function only_the_owner_of_project_may_update_a_task()
    {
        $this->signIn();
        $project = ProjectFactory::withTasks(1)
            ->create();
        $this->assertDatabaseHas('tasks', ['body' => $project->tasks->first()->body]);
        $this->patch($project->tasks->first()->path(), ['body' => 'Test task update'])
            ->assertForbidden();
        $this->assertDatabaseMissing('tasks', ['body' => 'Test task update']);
    }
}
