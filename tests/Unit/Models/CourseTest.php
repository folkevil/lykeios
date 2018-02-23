<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_many_users_enrolled_into()
    {
        $course = factory(\App\Models\Course::class)->create();

        $this->assertCount(0, $course->enrollments);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $course->enrollments);
    }

    /** @test */
    public function it_has_many_learning_resources()
    {
        $course = factory(\App\Models\Course::class)->create();

        $this->assertCount(0, $course->lessons);
        $this->assertInstanceOf(\Illuminate\Database\Eloquent\Collection::class, $course->lessons);
    }

    /** @test */
    public function it_should_determine_if_it_has_been_published()
    {
        $courseA = factory(\App\Models\Course::class)->create(['published_at' => now()]);
        $courseB = factory(\App\Models\Course::class)->create(['published_at' => null]);

        $this->assertTrue($courseA->isPublished());
        $this->assertFalse($courseB->isPublished());
    }

    /** @test */
    public function it_should_be_marked_as_published()
    {
        $course = factory(\App\Models\Course::class)->create(['published_at' => null]);
        $this->assertFalse($course->isPublished());

        $course->markAsPublished();

        $this->assertTrue($course->fresh()->isPublished());
    }

    /** @test */
    public function it_should_be_marked_as_unpublished()
    {
        $course = factory(\App\Models\Course::class)->create(['published_at' => now()]);
        $this->assertTrue($course->isPublished());

        $course->markAsUnpublished();

        $this->assertFalse($course->fresh()->isPublished());
    }

    /** @test */
    public function it_must_throw_an_exception_when_trying_to_unpublish_a_course_with_enrollments()
    {
        $this->expectException(\Exception::class);

        $user = factory(\App\User::class)->create();
        $course = factory(\App\Models\Course::class)->states('published')->create();
        $user->enrollInto($course);

        $course->markAsUnpublished();
    }

    /** @test */
    public function it_should_scope_to_published_courses()
    {
        factory(\App\Models\Course::class, 3)->create(['published_at' => now()]);
        factory(\App\Models\Course::class, 2)->create(['published_at' => null]);

        $this->assertEquals(3, \App\Models\Course::published()->count());
    }
}
