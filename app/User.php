<?php

namespace App;

use App\Models\Course;
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
        return $this->belongsToMany(Course::class, 'course_user', 'user_id');
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
     * Enroll the user into a published course.
     *
     * @param \App\Models\Course $course
     *
     * @return void
     */
    public function enrollInto(Course $course): void
    {
        if (! $course->isPublished()) {
            throw new \Exception('You cannot enroll an user in an unpublished course.');
        }

        $this->enrollments()->attach($course);
    }
}
