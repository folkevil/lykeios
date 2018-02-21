<?php

namespace App\Http\Controllers\Backoffice\Api;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnrollmentsController extends Controller
{
    public function store(Request $request)
    {
        $users = collect($request->users)->map(function (int $userId) {
            return User::findOrFail($userId);
        });

        collect($request->courses)
            ->map(function ($courseId) {
                return Course::published()->findOrFail($courseId);
            })
            ->each(function ($course) use ($users) {
                $users->each->enrollInto($course);
            });

        return response()->json([], Response::HTTP_CREATED);
    }
}
