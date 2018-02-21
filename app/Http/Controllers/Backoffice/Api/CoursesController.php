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
        $this->authorize('index', Course::class);

        return Course::all();
    }

    public function show(Course $course)
    {
        $this->authorize('show', $course);

        return $course;
    }

    public function store(Request $request)
    {
        $this->authorize('store', Course::class);

        $data = $this->validate($request, [
            'name' => 'required|string',
            'description' => 'required|string',
            'language' => 'required|string',
        ]);

        return Course::create($data);
    }

    public function update(Request $request, Course $course)
    {
        $this->authorize('update', $course);

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
        $this->authorize('destroy', $course);

        $course->delete();

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
