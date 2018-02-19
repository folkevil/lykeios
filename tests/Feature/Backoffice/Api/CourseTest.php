<?php

namespace Tests\Feature\Backoffice\Api;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function users_can_see_all_courses()
    {
        $user = factory(\App\User::class)->create();
        factory(\App\Models\Course::class, 5)->create();

        $this->actingAs($user, 'api');
        $response = $this->get('/backoffice/api/courses');
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(5, $entries);
    }

    /** @test */
    function users_can_see_a_single_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create([
            'name' => 'How to become a web artisan with Laravel',
        ]);

        $this->actingAs($user, 'api');
        $response = $this->get("/backoffice/api/courses/{$course->id}");

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $course->id,
            'name' => 'How to become a web artisan with Laravel',
        ]);
    }

    /** @test */
    function users_can_create_a_new_course()
    {
        $user = factory(\App\User::class)->create();
        $data = factory(\App\Models\Course::class)->raw([
            'name' => 'How to become a web artisan with Laravel',
            'description' => 'In this course you\'ll learn how to create web applications with Laravel.',
            'language' => 'en_US',
        ]);

        $this->actingAs($user, 'api');
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
    function it_requires_some_when_creating_a_course(string $field)
    {
        $user = factory(\App\User::class)->create();

        $this->actingAs($user, 'api');
        $response = $this->json('POST', '/backoffice/api/courses', [$field => null]);
        $responseData = json_decode($response->getContent(), true);

        $response->assertStatus(422);
        $this->assertArrayHasKey($field, $responseData['errors']);
    }

    /** @test */
    function users_can_update_an_existing_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create([
            'name' => 'How to become a web artisan with Laravel',
            'language' => 'en_US',
        ]);

        $data = [
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
        ];

        $this->actingAs($user, 'api');
        $response = $this->json('PUT', "/backoffice/api/courses/{$course->id}", $data);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $course->id,
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
            'language' => 'en_US',
        ]);

        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'name' => 'Changed the course name',
            'description' => 'Also the course description',
            'language' => 'en_US',
        ]);
    }

    /** @test */
    function users_can_delete_an_existing_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create();

        $this->actingAs($user, 'api');
        $response = $this->delete("/backoffice/api/courses/{$course->id}");

        $response->assertStatus(204);
        $this->assertDatabaseMissing('courses', [
            'id' => $course->id,
        ]);
    }

    public function requiredFieldsWhenCreatingACourseDataProvider()
    {
        return [
            ['name'],
            ['description'],
            ['language'],
        ];
    }
}
