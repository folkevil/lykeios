<?php

namespace App\Models\Relations;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Enrollment extends Pivot
{
    /**
     * Get the assigned lessons for the enrollment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, 'enrollment_lesson', 'enrollment_id');
    }
}
