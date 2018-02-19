<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Models\Course;
use App\Http\Controllers\Controller;

class PublishCourseController extends Controller
{
    public function publish(Course $course)
    {
        $course->markAsPublished();

        return $course;
    }

    public function unpublish(Course $course)
    {
        $course->markAsUnpublished();

        return $course;
    }
}
