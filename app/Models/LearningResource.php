<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LearningResource extends Model
{
    protected $fillable = ['name', 'description', 'course_id'];

    /**
     * Get all of the owning resourceable models.
     */
    public function resourceable(): MorphTo
    {
        return $this->morphTo();
    }
}
