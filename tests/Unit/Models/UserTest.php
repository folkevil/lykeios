<?php

namespace Tests\Unit\Models;

use App\Jobs\AssignLessonsToUser;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_determine_if_it_is_admin()
    {
        $admin = factory(\App\Models\User::class)->states('admin')->create();
        $student = factory(\App\Models\User::class)->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($student->isAdmin());
    }

    /** @test */
    public function it_can_be_enrroled_in_a_published_course()
    {
        $user = factory(\App\Models\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();

        $enrollment = $user->enrollInto($course);

        $this->assertEquals(1, $user->enrollments()->count());
    }

    /** @test */
    public function it_must_throw_an_exception_when_trying_to_enroll_the_user_into_an_unpublish_course()
    {
        $this->expectException(\Exception::class);

        $user = factory(\App\Models\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('unpublished')->create();

        $enrollment = $user->enrollInto($course);
    }

    /** @test */
    public function it_must_assign_lessons_when_enrolled_into_an_course()
    {
        Bus::fake();

        $user = factory(\App\Models\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();

        $enrollment = $user->enrollInto($course);

        Bus::assertDispatched(AssignLessonsToUser::class);
    }
}
