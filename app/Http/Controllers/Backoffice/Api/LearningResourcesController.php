<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class LearningResourcesController extends Controller
{
    public function index(Course $course)
    {
        return $course->learningResources;
    }

    public function store(Request $request, Course $course)
    {
        $data = $request->only(['name', 'description']);

        return $course->learningResources()->create($data);
    }
}
