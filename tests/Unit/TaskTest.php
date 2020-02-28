<?php

namespace Tests\Unit;

use App\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TaskTest extends TestCase
{

    use RefreshDatabase;

    /**
     * @test
     */
    public function it_has_a_path()
    {
        $task = factory(Task::class)->create();
        $this->assertEquals('/projects/' . $task->project->id . '/tasks/' . $task->id, $task->path());
    }

    /**
     * @test
     */
    public function it_completed()
    {
        $task = factory(Task::class)->create();
        $this->assertFalse($task->completed);
        $task->complete();
        $this->assertTrue($task->completed);
    }

    /**
     * @test
     */
    public function it_incomplete()
    {
        $task = factory(Task::class)->create();
        $task->complete();
        $this->assertTrue($task->completed);
        $task->incomplete();
        $this->assertFalse($task->completed);
    }
}
