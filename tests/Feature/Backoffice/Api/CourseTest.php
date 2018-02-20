<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\User
     */
    private $user;

    /**
     * @var \App\Models\Course
     */
    private $existingCourse;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->existingCourse = factory(\App\Models\Course::class)->create([
            'name' => 'How to become a web artisan with Laravel',
            'language' => 'en_US',
        ]);
    }

    /** @test */
    public function users_can_see_all_courses()
    {
        factory(\App\Models\Course::class, 5)->create();

        $this->actingAs($this->user, 'api');
        $response = $this->get('/backoffice/api/courses');
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(6, $entries); // there is already one that was created in setUp()
    }

    /** @test */
    public function users_can_see_a_single_course()
    {
        $this->actingAs($this->user, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->existingCourse->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->existingCourse->id,
            'name' => 'How to become a web artisan with Laravel',
        ]);
    }

    /** @test */
    public function users_can_create_a_new_course()
    {
        $data = factory(\App\Models\Course::class)->raw([
            'name' => 'How to become a web artisan with Laravel',
            'description' => 'In this course you\'ll learn how to create web applications with Laravel.',
            'language' => 'en_US',
        ]);

        $this->actingAs($this->user, 'api');
        $response = $this->post('/backoffice/api/courses', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'name' => 'How to become a web artisan with Laravel',
            'description' => 'In this course you\'ll learn how to create web applications with Laravel.',
            'language' => 'en_US',
        ]);

        $this->assertDatabaseHas('courses', [
            'name' => 'How to become a web artisan with Laravel',
            'description' => 'In this course you\'ll learn how to create web applications with Laravel.',
            'language' => 'en_US',
        ]);
    }

    /**
     * @test
     * @dataProvider requiredFieldsWhenCreatingACourseDataProvider
     */
    public function it_requires_some_fields_when_creating_a_course(string $field)
    {
        $this->actingAs($this->user, 'api');
        $response = $this->json('POST', '/backoffice/api/courses', [$field => null]);
        $responseData = json_decode($response->getContent(), true);

        $response->assertStatus(422);
        $this->assertArrayHasKey($field, $responseData['errors']);
    }

    /** @test */
    public function users_can_update_an_existing_course()
    {
        $data = [
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
        ];

        $this->actingAs($this->user, 'api');
        $response = $this->json('PUT', "/backoffice/api/courses/{$this->existingCourse->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->existingCourse->id,
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
            'language' => 'en_US',
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $this->existingCourse->id,
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
            'language' => 'en_US',
        ]);
    }

    /** @test */
    public function users_can_delete_an_existing_course()
    {
        $this->actingAs($this->user, 'api');
        $response = $this->delete("/backoffice/api/courses/{$this->existingCourse->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('courses', [
            'id' => $this->existingCourse->id,
        ]);
    }

    public function requiredFieldsWhenCreatingACourseDataProvider(): array
    {
        return [
            ['name'],
            ['description'],
            ['language'],
        ];
    }
}
