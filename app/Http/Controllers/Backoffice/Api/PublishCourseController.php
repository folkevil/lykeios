<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;

class PublishCourseController extends Controller
{
    public function publish(Course $course)
    {
        $this->authorize('update', $course);

        $course->markAsPublished();

        return $course;
    }

    public function unpublish(Course $course)
    {
        $this->authorize('update', $course);

        $course->markAsUnpublished();

        return $course;
    }
}
