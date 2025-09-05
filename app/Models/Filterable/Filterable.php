<?php

namespace App\Models\Filterable;

use Illuminate\Database\Eloquent\Builder;

/**
 * Filterable trait for eloquent models that are required to be filterable.
 */
trait Filterable
{
    /**
     * Returns a list of filter definitions the model supports.
     *
     * @return FilterDefinition[]
     */
    abstract protected function getFilterableFields(): array;

    /**
     * Returns an array of allowed filter fields for the model.
     *
     * @return string[]
     */
    public function allowedFilters(): array
    {
        return collect($this->getFilterableFields())
            ->pluck('field')
            ->toArray();
    }

    /**
     * Apply filters to the query
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        $filterDefinitions = $this->getFilterableFields();

        foreach ($filterDefinitions as $filterDefinition) {
            if (empty($filters[$filterDefinition->name])) {
                continue;
            }

            $query->where(fn ($q) => match ($filterDefinition->operator) {
                FilterOperator::Equal => $this->generateEqualsFilterClause($q, $filterDefinition->fields, $filters[$filterDefinition->name]),
                FilterOperator::Like => $this->generateLikeFilterClause($q, $filterDefinition->fields, $filters[$filterDefinition->name]),
            });
        }

        return $query;
    }

    /**
     * Generates and applies an "equals" filter clause to the query for the specified fields and value.
     */
    protected function generateEqualsFilterClause(Builder $query, array $fields, string $value): Builder
    {
        foreach ($fields as $field) {
            $query->orWhere($field, $value);
        }

        return $query;
    }

    /**
     * Generates and applies a "like" filter clause to the query for the specified fields and value.
     */
    protected function generateLikeFilterClause(Builder $query, array $fields, string $value): Builder
    {
        foreach ($fields as $field) {
            $query->orWhere($field, 'like', '%' . $value . '%');
        }

        return $query;
    }
}
