<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_must_have_a_lessonable()
    {
        $resourceA = factory(\App\Models\Lesson::class)->states('video')->create();
        $resourceB = factory(\App\Models\Lesson::class)->states('text')->create();

        $this->assertInstanceOf(\App\Models\Lesson::class, $resourceA);
        $this->assertInstanceOf(\App\Models\Lesson::class, $resourceB);

        $this->assertInstanceOf(\App\Models\VideoLesson::class, $resourceA->lessonable);
        $this->assertInstanceOf(\App\Models\TextLesson::class, $resourceB->lessonable);
    }
}
