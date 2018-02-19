<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;

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
