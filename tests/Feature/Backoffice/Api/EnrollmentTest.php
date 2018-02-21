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
        $students = factory(\App\User::class, 2)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();

        $data = [
            'users' => $students->pluck('id')->all(),
            'courses' => [$course->id],
        ];

        $this->actingAs($this->admin, 'api');
        $response = $this->post('/backoffice/api/enrollments', $data);

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'total_successfull_enrollments' => 2,
        ]);
        $this->assertEquals(2, $course->enrollments()->count());
    }
}
