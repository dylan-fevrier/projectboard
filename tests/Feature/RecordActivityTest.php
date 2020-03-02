<?php

namespace Tests\Feature;

use App\Task;
use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecordActivityTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);

        $this->assertEquals('created', $project->activities[0]->description);
    }

    /**
     * @test
     */
    public function updating_a_project()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activities);
        $this->assertEquals('updated', $project->activities->last()->description);
    }

    /**
     * @test
     */
    public function creating_a_new_task()
    {
        $project = ProjectFactory::create();

        $project->addTask(['body' => 'Some task']);

        $this->assertCount(2, $project->activities);
        $this->assertEquals('create_task', $project->activities->last()->description);
        $this->assertInstanceOf(Task::class, $project->activities->last()->subject);
        $this->assertEquals('Some task', $project->activities->last()->subject->body);
    }

    /**
     * @test
     */
    public function completing_a_task()
    {
        $project = ProjectFactory::withTasks(1)
            ->ownedBy($this->signIn())
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'completed' => true,
            'body' => 'New Body'
        ]);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('complete_task', $project->activities->last()->description);
        $this->assertInstanceOf(Task::class, $project->activities->last()->subject);
    }

    /**
     * @test
     */
    public function incompleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)
            ->ownedBy($this->signIn())
            ->create();

        $this->patch($project->tasks->first()->path(), [
            'completed' => true,
            'body' => 'New Body'
        ]);

        $this->patch($project->tasks->first()->path(), [
            'completed' => false,
            'body' => 'New Body'
        ]);

        $this->assertCount(4, $project->activities);
        $this->assertEquals('incomplete_task', $project->activities->last()->description);
        $this->assertInstanceOf(Task::class, $project->activities->last()->subject);
    }

    /**
     * @test
     */
    public function deleting_a_task()
    {
        $project = ProjectFactory::withTasks(1)->create();

        $project->tasks->first()->delete();

        $this->assertCount(3, $project->activities);
        $this->assertEquals('delete_task', $project->activities->last()->description);
    }
}
