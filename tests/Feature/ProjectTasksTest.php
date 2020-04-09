<?php

namespace Tests\Feature;

use App\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTasksTest extends TestCase
{
   use RefreshDatabase;

   public function a_project_can_have_task()
   {
       $this->withoutExceptionHandling();
       $this->signIn();

       $project = auth()->user()->projects()->create(
           factory(Project::class)->raw()
       );


       $this->get($project->path())
           ->assertSee('Test task');
   }

   public function a_task_requires_a_body()
   {
       $this->signIn();

       $project = auth()->user()->projects()->create(
           factory(Project::class)->raw()
       );

       $attributes = factory('App\Task')->raw(['body' => '']);

       $this->post($project->path() . '/tasks', $attributes)->assertSessionHasErrors('body');
   }
}
