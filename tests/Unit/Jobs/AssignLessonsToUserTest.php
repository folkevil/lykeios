<?php

namespace Tests\Unit\Models;

use App\Jobs\AssignLessonsToUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AssignLessonsToUserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function handle()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();

        $lessons = factory(\App\Models\Lesson::class, 2)->states('video')->create(['course_id' => $course->id]);

        $user->enrollments()->attach($course);
        $enrollment = $user->getEnrollmentForCourse($course);

        dispatch_now(new AssignLessonsToUser($user, $course));

        $this->assertEquals(2, $enrollment->lessons()->count());
    }
}
