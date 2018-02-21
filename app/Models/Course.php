<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = ['name', 'description', 'language'];

    /**
     * Get the learning resources for the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function learningResources(): HasMany
    {
        return $this->hasMany(LearningResource::class);
    }

    /**
     * Get the users enrolled into the course.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user', 'course_id');
    }

    /**
     * Scope a query to only include published courses.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * Determine if the course has been published.
     *
     * @return bool
     */
    public function isPublished(): bool
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
