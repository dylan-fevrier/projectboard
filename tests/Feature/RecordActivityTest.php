<?php

namespace Tests\Feature;

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
    }

    /**
     * @test
     */
    public function completing_a_new_task()
    {
        $project = ProjectFactory::withTasks(1)
            ->ownedBy($this->signIn())
            ->create();

        $project->tasks[0]->update([
            'completed' => true
        ]);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('complete_task', $project->activities->last()->description);
    }

    /**
     * @test
     */
    public function incomplete_task()
    {
        $project = ProjectFactory::withTasks(1)
            ->ownedBy($this->signIn())
            ->create();

        $project->tasks[0]->update([
            'completed' => true
        ]);

        $project->task[0]->update([
            'completed' => false
        ]);

        $this->assertCount(4, $project->activities);
        $this->assertEquals('incomplete_task', $project->activities->last()->description);
    }
}
