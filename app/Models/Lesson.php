<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Lesson extends Model
{
    protected $fillable = ['name', 'description', 'course_id'];

    /**
     * Get all of the owning lessonable models.
     */
    public function lessonable(): MorphTo
    {
        return $this->morphTo();
    }
}
