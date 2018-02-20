<?php

namespace App\Models\Traits;

use App\Models\LearningResource;

trait Resourceable
{
    public function resource()
    {
        return $this->morphOne(LearningResource::class, 'resourceable');
    }
}
