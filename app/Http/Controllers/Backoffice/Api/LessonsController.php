<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LessonRequest;
use App\Models\Course;
use App\Models\TextLesson;
use App\Models\VideoLesson;

class LessonsController extends Controller
{
    public function index(Course $course)
    {
        $this->authorize('index', $course);

        return $course->lessons;
    }

    public function store(LessonRequest $request, Course $course)
    {
        switch ($request->type) {
            case 'video':
                $lesson = VideoLesson::create([
                    'url' => $request->url,
                ])->lesson()->create([
                    'course_id' => $course->id,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
                break;

            case 'text':
                $lesson = TextLesson::create([
                    'content' => $request->content,
                ])->lesson()->create([
                    'course_id' => $course->id,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
                break;

            default:
                throw new \InvalidArgumentException('Error Processing Request', 1);
                break;
        }

        return $lesson;
    }
}
