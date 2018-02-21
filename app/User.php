<?php

namespace App;

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
     * Determine if the user is an admin.
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }
}
