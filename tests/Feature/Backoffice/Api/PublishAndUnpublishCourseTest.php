<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PublishAndUnpublishCourseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var \App\User
     */
    private $admin;

    /**
     * @var \App\Models\Course
     */
    private $course;

    protected function setUp()
    {
        parent::setUp();

        $this->admin = factory(\App\User::class)->states('admin')->create();
        $this->course = factory(\App\Models\Course::class)->create([
            'name' => 'How to become a web artisan with Laravel',
            'language' => 'en_US',
        ]);
    }

    /** @test */
    public function admins_can_publish_a_course()
    {
        Carbon::setTestNow(now());

        $this->assertCourseIsNotPublished($this->course);

        $this->actingAs($this->admin, 'api');
        $response = $this->put("/backoffice/api/courses/{$this->course->id}/publish");

        $this->assertCourseIsPublished($this->course);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'published_at' => now(),
        ]);
    }

    /** @test */
    public function other_than_admin_cannot_publish_courses()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->put("/backoffice/api/courses/{$this->course->id}/publish");

        $response->assertStatus(403);
    }

    /** @test */
    public function admins_can_unpublish_a_course()
    {
        $this->course->markAsPublished();

        $this->assertCourseIsPublished($this->course);

        $this->actingAs($this->admin, 'api');
        $response = $this->put("/backoffice/api/courses/{$this->course->id}/unpublish");

        $this->assertCourseIsNotPublished($this->course);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'published_at' => null,
        ]);
    }

    /** @test */
    public function other_than_admin_cannot_unpublish_courses()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->put("/backoffice/api/courses/{$this->course->id}/unpublish");

        $response->assertStatus(403);
    }

    private function assertCourseIsNotPublished(\App\Models\Course $course)
    {
        $this->assertFalse($course->fresh()->published(), 'Failed asserting that course isn\'t published.');
    }

    private function assertCourseIsPublished(\App\Models\Course $course)
    {
        $this->assertTrue($course->fresh()->published(), 'Failed asserting that course is published.');
    }
}
