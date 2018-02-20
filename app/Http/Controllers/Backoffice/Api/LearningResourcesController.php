<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\TextResource;
use App\Models\VideoResource;
use Illuminate\Http\Request;

class LearningResourcesController extends Controller
{
    public function index(Course $course)
    {
        return $course->learningResources;
    }

    public function store(Request $request, Course $course)
    {
        $data = array_merge($request->only(['name', 'description']), [
            'course_id' => $course->id,
        ]);

        switch ($request->type) {
            case 'video':
                $resource = VideoResource::create()->resource()->create($data);
                break;

            case 'text':
                $resource = TextResource::create()->resource()->create($data);
                break;

            default:
                throw new \InvalidArgumentException("Error Processing Request", 1);
                break;
        }

        return $resource;
    }
}
