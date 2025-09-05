<?php

namespace App\Models\Sortable;

use Illuminate\Database\Eloquent\Builder;

/**
 * Sortable trait for eloquent models that are required to be sortable. Adds the ability to restrict which fields can be
 * sorted by.
 */
trait Sortable
{
    /**
     * @return string[]
     */
    abstract protected function allowedSortableFields(): array;

    public function scopeSortable(Builder $query, ?string $field, ?Direction $direction): Builder
    {
        if (in_array($field, $this->allowedSortableFields())) {
            $query->orderBy($field, $direction->value);
        }

        return $query;
    }
}
