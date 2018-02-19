<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PublishCourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function users_can_publish_a_course()
    {
        Carbon::setTestNow(now());

        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create();

        $this->assertCourseIsNotPublished($course);

        $this->actingAs($user, 'api');
        $response = $this->put("/backoffice/api/courses/{$course->id}/publish");

        $this->assertCourseIsPublished($course);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
            'published_at' => now(),
        ]);
    }

    /** @test */
    public function users_can_unpublish_a_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->create();
        $course->markAsPublished();

        $this->assertCourseIsPublished($course);

        $this->actingAs($user, 'api');
        $response = $this->put("/backoffice/api/courses/{$course->id}/unpublish");

        $this->assertCourseIsNotPublished($course);
        $response->assertStatus(200);
        $this->assertDatabaseHas('courses', [
            'id' => $course->id,
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
