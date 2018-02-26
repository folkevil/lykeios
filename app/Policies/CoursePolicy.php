<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursePolicy
{
    use HandlesAuthorization;

    /**
     * Determine the user ability before run all others checks.
     *
     * @param \App\Models\User $user
     * @param mixed $ability
     *
     * @return bool
     */
    public function before($user, $ability)
    {
        return $user->isAdmin();
    }

    public function index(User $user)
    {
        //
    }

    public function show(User $user, Course $course)
    {
        //
    }

    public function store(User $user)
    {
        //
    }

    public function update(User $user, Course $course)
    {
        //
    }

    public function destroy(User $user, Course $course)
    {
        //
    }
}
