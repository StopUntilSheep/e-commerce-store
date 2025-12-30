<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Sluggable
{
    private const DEFAULT_FIELD_SLUG = 'slug';
    private const DEFAULT_FIELD_NAME = 'name';

    /**
     * Boot the sluggable trait for a model.
     */
    protected static function bootSluggable(): void
    {
        static::creating(function ($model) {
            $model->generateSlug();
        });

        static::updating(function ($model) {
            $model->generateSlugOnUpdate();
        });
    }

    /**
     * Generate slug on create.
     */
    protected function generateSlug(): void
    {
        $slugField = $this->slugField ?? $this->DEFAULT_FIELD_SLUG;
        $sourceField = $this->slugSourceField ?? $this->DEFAULT_FIELD_NAME;
        
        if (empty($this->{$slugField})) {
            $this->{$slugField} = $this->generateUniqueSlug(
                Str::slug($this->{$sourceField})
            );
        }
    }

    /**
     * Generate slug on update if needed.
     */
    protected function generateSlugOnUpdate(): void
    {
        $slugField = $this->slugField ?? $this->DEFAULT_FIELD_SLUG;
        $sourceField = $this->slugSourceField ?? $this->DEFAULT_FIELD_NAME;
        
        // Only regenerate slug if name changed and slug is empty
        if ($this->isDirty($sourceField) && empty($this->{$slugField})) {
            $this->{$slugField} = $this->generateUniqueSlug(
                Str::slug($this->{$sourceField})
            );
        }
        
        // Or if you want to always update slug when name changes:
        // if ($this->isDirty($sourceField)) {
        //     $this->{$slugField} = $this->generateUniqueSlug(
        //         Str::slug($this->{$sourceField})
        //     );
        // }
    }

    /**
     * Generate a unique slug.
     */
    protected function generateUniqueSlug(string $slug): string
    {
        $originalSlug = $slug;
        $slugField = $this->slugField ?? $this->DEFAULT_FIELD_SLUG;
        $count = 1;

        // Check if slug exists, if yes append a number
        while ($this->slugExists($slug, $slugField)) {
            $slug = $originalSlug . '-' . $count++;
        }

        return $slug;
    }

    /**
     * Check if a slug already exists.
     */
    protected function slugExists(string $slug, string $slugField): bool
    {
        $query = static::where($slugField, $slug);

        // Exclude current model when updating
        if ($this->exists) {
            $query->where($this->getKeyName(), '!=', $this->getKey());
        }

        return $query->exists();
    }

    /**
     * Get the route key name for Laravel's route model binding.
     */
    public function getRouteKeyName(): string
    {
        return $this->slugField ?? $this->DEFAULT_FIELD_SLUG;
    }
}