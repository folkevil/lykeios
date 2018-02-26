<?php

namespace Tests\Feature\Backoffice\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Collection;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * @var \App\Models\User
     */
    private $admin;

    /**
     * @var \App\Models\Course
     */
    private $course;

    protected function setUp()
    {
        parent::setUp();

        $this->admin = factory(\App\Models\User::class)->states('admin')->create();
        $this->course = factory(\App\Models\Course::class)->create();
    }

    /** @test */
    public function admins_can_see_all_lessons_of_a_course()
    {
        factory(\App\Models\Lesson::class, 5)->states('video')->create(['course_id' => $this->course->id]);

        $this->actingAs($this->admin, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->course->id}/lessons");
        $entries = json_decode($response->getContent(), true);

        $response->assertStatus(200);
        $this->assertCount(5, $entries);
    }

    /** @test */
    public function other_than_admin_cannot_see_all_lessons_of_a_course()
    {
        $this->student = factory(\App\Models\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->get("/backoffice/api/courses/{$this->course->id}/lessons");

        $response->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider validLessonDataProvider
     */
    public function admins_can_create_lessons_for_a_course(Collection $dataset)
    {
        $this->withoutExceptionHandling();
        $merged = $dataset->merge([
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->actingAs($this->admin, 'api');
        $response = $this->json('POST', "/backoffice/api/courses/{$this->course->id}/lessons", $merged->all());

        $response->assertStatus(201);
        $response->assertJsonFragment([
            'course_id' => $this->course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->assertDatabaseHas('lessons', [
            'course_id' => $this->course->id,
            'name' => 'Installing Laravel',
            'description' => 'Let\'s get started by installing...',
        ]);

        $this->assertDatabaseHas("{$dataset->get('type')}_lessons", ($dataset->except(['type']))->all());
    }

    /** @test */
    public function other_than_admin_cannot_create_lessons()
    {
        $this->student = factory(\App\Models\User::class)->create();

        $this->actingAs($this->student, 'api');
        $response = $this->json('POST', "/backoffice/api/courses/{$this->course->id}/lessons", ['type' => 'video']);

        $response->assertStatus(403);
    }

    /**
     * @test
     * @dataProvider requiredFieldsWhenCreatingLessonsDataProvider
     */
    public function it_requires_some_fields_when_creating_lessons(array $dataset)
    {
        $this->actingAs($this->admin, 'api');

        $response = $this->json('POST', "/backoffice/api/courses/{$this->course->id}/lessons", [
            'type' => $dataset['type'],
        ]);
        $responseData = json_decode($response->getContent(), true);

        $response->assertStatus(422);

        foreach ($dataset['fields'] as $field) {
            $this->assertArrayHasKey($field, $responseData['errors']);
        }
    }

    public function validLessonDataProvider(): array
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

    public function requiredFieldsWhenCreatingLessonsDataProvider(): array
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
