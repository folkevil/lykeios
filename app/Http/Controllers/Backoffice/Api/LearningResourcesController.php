<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LearningResourceRequest;
use App\Models\Course;
use App\Models\TextResource;
use App\Models\VideoResource;

class LearningResourcesController extends Controller
{
    public function index(Course $course)
    {
        $this->authorize('index', $course);

        return $course->learningResources;
    }

    public function store(LearningResourceRequest $request, Course $course)
    {
        switch ($request->type) {
            case 'video':
                $resource = VideoResource::create([
                    'url' => $request->url,
                ])->resource()->create([
                    'course_id' => $course->id,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
                break;

            case 'text':
                $resource = TextResource::create([
                    'content' => $request->content,
                ])->resource()->create([
                    'course_id' => $course->id,
                    'name' => $request->name,
                    'description' => $request->description,
                ]);
                break;

            default:
                throw new \InvalidArgumentException('Error Processing Request', 1);
                break;
        }

        return $resource;
    }
}
