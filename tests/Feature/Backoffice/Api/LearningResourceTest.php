<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_see_all_learning_resources_of_a_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create();

        factory(\App\Models\LearningResource::class, 5)->create(['course_id' => $course->id]);

        $this->actingAs($user, 'api');
        $response = $this->get("/backoffice/api/courses/{$course->id}/learning-resources");
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(5, $entries);
    }

    /** @test */
    function users_can_create_a_learning_resource_for_a_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create();

        $data = factory(\App\Models\LearningResource::class)->raw([
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->actingAs($user, 'api');
        $response = $this->post("/backoffice/api/courses/{$course->id}/learning-resources", $data);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'course_id' => $course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->assertDatabaseHas('learning_resources', [
            'course_id' => $course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);
    }
}
