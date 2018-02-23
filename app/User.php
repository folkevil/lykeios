<?php

namespace App;

use App\Jobs\AssignLessonsToUser;
use App\Models\Course;
use App\Models\Relations\Enrollment;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * User roles.
     */
    const ROLE_ADMIN = 'admin';
    const ROLE_STUDENT = 'student';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Get the courses the user is enrolled into.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_user', 'user_id')
            ->withPivot(['id'])
            ->as('enrollment')
            ->using(Enrollment::class)
            ->withTimestamps();
    }

    /**
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->role === self::ROLE_ADMIN;
    }

    /**
     * Get the enrollment relation for the given course.
     *
     * @param \App\Models\Course $course
     *
     * @return \App\Models\Relations\Enrollment
     */
    public function getEnrollmentForCourse(Course $course): Enrollment
    {
        return $this->enrollments()->where('course_id', $course->id)->first()->enrollment;
    }

    /**
     * Enroll the user into a published course.
     *
     * @param \App\Models\Course $course
     *
     * @throws \Exception
     * @return void
     */
    public function enrollInto(Course $course): void
    {
        if (! $course->isPublished()) {
            throw new \Exception('You cannot enroll an user into an unpublished course.');
        }

        $this->enrollments()->attach($course);

        dispatch(new AssignLessonsToUser($this, $course));
    }
}
