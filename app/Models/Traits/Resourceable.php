<?php

namespace App\Models\Traits;

use App\Models\LearningResource;

trait Resourceable
{
    /**
     * Get the learning resource of the resourceable.
     */
    public function resource()
    {
        return $this->morphOne(LearningResource::class, 'resourceable');
    }
}
