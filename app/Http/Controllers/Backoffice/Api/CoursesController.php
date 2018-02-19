<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'language' => 'required|string',
        ]);

        return Course::create($data);
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validate($request, [
            'name' => 'string',
            'description' => 'string',
            'language' => 'string',
        ]);

        $course->update($data);

        return $course;
    }

    public function destroy(Course $course)
    {
        $course->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
