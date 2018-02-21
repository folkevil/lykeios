<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;

class EnrollmentsController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('enroll_users');

        $users = $this->mapUsers($request->users);
        $courses = $this->mapCourses($request->courses);

        $totalEnrollments = 0;

        $courses->each(function ($course) use ($users, &$totalEnrollments) {
            $users->each(function ($user) use ($course, &$totalEnrollments) {
                $user->enrollInto($course);
                $totalEnrollments++;
            });
        });

        return response()->json([
            'total_successfull_enrollments' => $totalEnrollments,
        ], Response::HTTP_CREATED);
    }

    /**
     * @param int[] $users
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapUsers(array $users): Collection
    {
        return collect($users)->map(function (int $userId) {
            return User::findOrFail($userId);
        });
    }

    /**
     * @param int[] $courses
     *
     * @return \Illuminate\Support\Collection
     */
    private function mapCourses(array $courses): Collection
    {
        return collect($courses)->map(function (int $courseId) {
            return Course::published()->findOrFail($courseId);
        });
    }
}
