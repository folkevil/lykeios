<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CourseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_should_determine_if_it_has_been_published()
    {
        $courseA = factory(\App\Models\Course::class)->create(['published_at' => now()]);
        $courseB = factory(\App\Models\Course::class)->create(['published_at' => null]);

        $this->assertTrue($courseA->published());
        $this->assertFalse($courseB->published());
    }

    /** @test */
    public function it_should_be_marked_as_published()
    {
        $course = factory(\App\Models\Course::class)->create(['published_at' => null]);
        $this->assertFalse($course->published());

        $course->markAsPublished();

        $this->assertTrue($course->fresh()->published());
    }

    /** @test */
    public function it_should_be_marked_as_unpublished()
    {
        $course = factory(\App\Models\Course::class)->create(['published_at' => now()]);
        $this->assertTrue($course->published());

        $course->markAsUnpublished();

        $this->assertFalse($course->fresh()->published());
    }
}
