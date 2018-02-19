<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'language'];

    /**
     * Determine if the course has been published.
     *
     * @return bool
     */
    public function published(): bool
    {
        return $this->published_at !== null;
    }

    /**
     * Mark the course as published.
     *
     * @return void
     */
    public function markAsPublished(): void
    {
        if ($this->published_at === null) {
            $this->forceFill(['published_at' => $this->freshTimestamp()])->save();
        }
    }

    /**
     * Mark the course as unpublished.
     *
     * @return void
     */
    public function markAsUnpublished(): void
    {
        if ($this->published_at !== null) {
            $this->forceFill(['published_at' => null])->save();
        }
    }
}
