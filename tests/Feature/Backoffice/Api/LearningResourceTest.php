<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningResourceTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Models\Course
     */
    private $course;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->course = factory(\App\Models\Course::class)->create();
    }

    /** @test */
    public function users_can_see_all_learning_resources_of_a_course()
    {
        factory(\App\Models\LearningResource::class, 5)->states('video')->create(['course_id' => $this->course->id]);

        $this->actingAs($this->user, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->course->id}/learning-resources");
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(5, $entries);
    }

    /** @test */
    public function users_can_create_a_learning_resource_for_a_course()
    {
        $this->withoutExceptionHandling();

        $data = array_merge(factory(\App\Models\LearningResource::class)->raw([
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]), ['type' => 'video']);

        $this->actingAs($this->user, 'api');
        $response = $this->post("/backoffice/api/courses/{$this->course->id}/learning-resources", $data);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'course_id' => $this->course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->assertDatabaseHas('learning_resources', [
            'course_id' => $this->course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);
    }
}
