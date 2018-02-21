<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnrollmentTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\User
     */
    private $admin;

    protected function setUp()
    {
        parent::setUp();

        $this->admin = factory(\App\User::class)->states('admin')->create();
    }

    /** @test */
    public function users_can_be_enrolled_in_published_courses()
    {
        $this->withoutExceptionHandling();
        $student = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();

        $data = [
            'users' => [$student->id],
            'courses' => [$course->id],
        ];

        $this->actingAs($this->admin, 'api');
        $response = $this->post('/backoffice/api/enrollments', $data);

        $response->assertStatus(201);
        $this->assertEquals(1, $student->enrollments()->count());
        $this->assertEquals(1, $course->enrollments()->count());
    }
}
