<?php

namespace App\Models\Traits;

use App\Models\LearningResource;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Resourceable
{
    /**
     * Get the learning resource of the resourceable.
     */
    public function resource(): MorphOne
    {
        return $this->morphOne(LearningResource::class, 'resourceable');
    }
}
