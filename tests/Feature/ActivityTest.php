<?php

namespace Tests\Feature;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function creating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $this->assertCount(1, $project->activities);

        $this->assertEquals('created', $project->activities[0]->description);
    }

    /**
     * @test
     */
    public function updating_a_project_records_activity()
    {
        $project = ProjectFactory::create();

        $project->update(['title' => 'Changed']);

        $this->assertCount(2, $project->activities);
        $this->assertEquals('updated', $project->activities->last()->description);
    }

    /**
     * @test
     */
    public function creating_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::create();

        $project->addTask(['body' => 'Some task']);

        $this->assertCount(2, $project->activities);
        $this->assertEquals('create_task', $project->activities->last()->description);
    }

    /**
     * @test
     */
    public function completing_a_new_task_records_project_activity()
    {
        $project = ProjectFactory::withTasks(1)
            ->ownedBy($this->signIn())
            ->create();

        $project->tasks[0]->update([
            'completed' => 1
        ]);

        $this->assertCount(3, $project->activities);
        $this->assertEquals('complete_task', $project->activities->last()->description);
    }
}
