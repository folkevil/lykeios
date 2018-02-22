<?php

namespace App\Models\Traits;

use App\Models\Lesson;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Lessonable
{
    /**
     * Get the lesson of the lessonable.
     */
    public function lesson(): MorphOne
    {
        return $this->morphOne(Lesson::class, 'lessonable');
    }
}
