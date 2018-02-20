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
    private $user;

    /**
     * @var \App\Models\Course
     */
    private $course;

    protected function setUp()
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->course = factory(\App\Models\Course::class)->create([
            'name' => 'How to become a web artisan with Laravel',
            'language' => 'en_US',
        ]);
    }

    /** @test */
    public function users_can_publish_a_course()
    {
        Carbon::setTestNow(now());

        $this->assertCourseIsNotPublished($this->course);

        $this->actingAs($this->user, 'api');
        $response = $this->put("/backoffice/api/courses/{$this->course->id}/publish");

        $this->assertCourseIsPublished($this->course);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'published_at' => now(),
        ]);
    }

    /** @test */
    public function users_can_unpublish_a_course()
    {
        $this->course->markAsPublished();

        $this->assertCourseIsPublished($this->course);

        $this->actingAs($this->user, 'api');
        $response = $this->put("/backoffice/api/courses/{$this->course->id}/unpublish");

        $this->assertCourseIsNotPublished($this->course);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', [
            'id' => $this->course->id,
            'published_at' => null,
        ]);
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
