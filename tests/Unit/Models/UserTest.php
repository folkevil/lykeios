<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_determine_if_it_is_admin()
    {
        $admin = factory(\App\User::class)->states('admin')->create();
        $student = factory(\App\User::class)->create();

        $this->assertTrue($admin->isAdmin());
        $this->assertFalse($student->isAdmin());
    }

    /** @test */
    public function it_can_be_enrroled_in_a_published_course()
    {
        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();

        $enrollment = $user->enrollInto($course);

        $this->assertEquals(1, $user->enrollments()->count());
    }
}
