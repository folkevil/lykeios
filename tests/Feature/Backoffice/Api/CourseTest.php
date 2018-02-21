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
    private $admin;

    /**
     * @var \App\Models\Course
     */
    private $existingCourse;

    protected function setUp()
    {
        parent::setUp();

        $this->admin = factory(\App\User::class)->states('admin')->create();
        $this->existingCourse = factory(\App\Models\Course::class)->create([
            'name' => 'How to become a web artisan with Laravel',
            'language' => 'en_US',
        ]);
    }

    /** @test */
    public function admins_can_see_all_courses()
    {
        factory(\App\Models\Course::class, 5)->create();

        $this->actingAs($this->admin, 'api');
        $response = $this->get('/backoffice/api/courses');
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(6, $entries); // there is already one that was created in setUp()
    }

    /** @test */
    public function other_than_admin_cannot_see_all_courses()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->get('/backoffice/api/courses');

        $response->assertStatus(403);
    }

    /** @test */
    public function admins_can_see_a_single_course()
    {
        $this->actingAs($this->admin, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->existingCourse->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $this->existingCourse->id,
            'name' => 'How to become a web artisan with Laravel',
        ]);
    }

    /** @test */
    public function other_than_admin_cannot_see_a_single_course()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->existingCourse->id}");

        $response->assertStatus(403);
    }

    /** @test */
    public function admins_can_create_a_new_course()
    {
        $data = factory(\App\Models\Course::class)->raw([
            'name' => 'How to become a web artisan with Laravel',
            'description' => 'In this course you\'ll learn how to create web applications with Laravel.',
            'language' => 'en_US',
        ]);

        $this->actingAs($this->admin, 'api');
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

    /** @test */
    public function other_than_admin_cannot_create_courses()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->json('POST', '/backoffice/api/courses', []);

        $response->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider requiredFieldsWhenCreatingACourseDataProvider
     */
    public function it_requires_some_fields_when_creating_a_course(string $field)
    {
        $this->actingAs($this->admin, 'api');
        $response = $this->json('POST', '/backoffice/api/courses', [$field => null]);
        $responseData = json_decode($response->getContent(), true);

        $response->assertStatus(422);
        $this->assertArrayHasKey($field, $responseData['errors']);
    }

    /** @test */
    public function admins_can_update_an_existing_course()
    {
        $data = [
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
        ];

        $this->actingAs($this->admin, 'api');
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
    public function other_than_admin_cannot_update_courses()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->json('PUT', "/backoffice/api/courses/{$this->existingCourse->id}", []);

        $response->assertStatus(403);
    }

    /** @test */
    public function admins_can_delete_an_existing_course()
    {
        $this->actingAs($this->admin, 'api');
        $response = $this->delete("/backoffice/api/courses/{$this->existingCourse->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('courses', [
            'id' => $this->existingCourse->id,
        ]);
    }

    /** @test */
    public function other_than_admin_cannot_delete_courses()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->delete("/backoffice/api/courses/{$this->existingCourse->id}");

        $response->assertStatus(403);
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
