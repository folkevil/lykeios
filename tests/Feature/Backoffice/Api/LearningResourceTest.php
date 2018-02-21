<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class LearningResourceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

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
        $this->course = factory(\App\Models\Course::class)->create();
    }

    /** @test */
    public function admins_can_see_all_learning_resources_of_a_course()
    {
        factory(\App\Models\LearningResource::class, 5)->states('video')->create(['course_id' => $this->course->id]);

        $this->actingAs($this->admin, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->course->id}/learning-resources");
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(5, $entries);
    }

    /** @test */
    function other_than_admin_cannot_see_all_learning_resources_of_a_course()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->course->id}/learning-resources");

        $response->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider validLearningResourceDataProvider
     */
    public function admins_can_create_learning_resources_for_a_course(Collection $dataset)
    {
        $merged = $dataset->merge([
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->actingAs($this->admin, 'api');
        $response = $this->json('POST', "/backoffice/api/courses/{$this->course->id}/learning-resources", $merged->all());

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'course_id' => $this->course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->assertDatabaseHas('learning_resources', [
            'course_id' => $this->course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->assertDatabaseHas("{$dataset->get('type')}_resources", ($dataset->except(['type']))->all());
    }

    /** @test */
    function other_than_admin_cannot_create_learning_resources()
    {
        $this->student = factory(\App\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->json('POST', "/backoffice/api/courses/{$this->course->id}/learning-resources", ['type' => 'video']);

        $response->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider requiredFieldsWhenCreatingLearningResourcesDataProvider
     */
    public function it_requires_some_fields_when_creating_learning_resources(array $dataset)
    {
        $this->actingAs($this->admin, 'api');

        $response = $this->json('POST', "/backoffice/api/courses/{$this->course->id}/learning-resources", [
            'type' => $dataset['type'],
        ]);
        $responseData = json_decode($response->getContent(), true);

        $response->assertStatus(422);

        foreach ($dataset['fields'] as $field) {
            $this->assertArrayHasKey($field, $responseData['errors']);
        }
    }

    public function validLearningResourceDataProvider(): array
    {
        return [
            [
                collect([
                    'type' => 'video',
                    'url' => 'https://www.youtube.com/watch?v=D7zUOtlpUPw',
                ]),
            ],
            [
                collect([
                    'type' => 'text',
                    'content' => 'Lorem ipsum dolor sit amet...',
                ]),
            ],
        ];
    }

    public function requiredFieldsWhenCreatingLearningResourcesDataProvider(): array
    {
        $common = ['name', 'description'];

        return [
            [
                [
                    'type' => 'video',
                    'fields' => array_merge($common, ['url']),
                ],
                [
                    'type' => 'text',
                    'fields' => array_merge($common, ['description']),
                ],
            ],
        ];
    }
}
