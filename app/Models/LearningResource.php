<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LearningResource extends Model
{
    protected $fillable = ['name', 'description', 'course_id'];

    /**
     * Get all of the owning resourceable models.
     */
    public function resourceable()
    {
        return $this->morphTo();
    }
}
