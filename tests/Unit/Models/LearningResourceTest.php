<?php

namespace Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LearningResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_must_have_a_resourceable()
    {
        $resourceA = factory(\App\Models\LearningResource::class)->states('video')->create();
        $resourceB = factory(\App\Models\LearningResource::class)->states('text')->create();

        $this->assertInstanceOf(\App\Models\LearningResource::class, $resourceA);
        $this->assertInstanceOf(\App\Models\LearningResource::class, $resourceB);

        $this->assertInstanceOf(\App\Models\VideoResource::class, $resourceA->resourceable);
        $this->assertInstanceOf(\App\Models\TextResource::class, $resourceB->resourceable);
    }
}
