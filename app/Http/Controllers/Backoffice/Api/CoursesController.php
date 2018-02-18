<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Models\Course;
use App\Http\Controllers\Controller;

class CoursesController extends Controller
{
    public function index()
    {
        return Course::all();
    }

    public function show(Course $course)
    {
        return $course;
    }
}
