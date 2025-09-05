<?php

namespace App\Models\Filterable;

use Illuminate\Support\Arr;

/**
 * A DTO that represents a filter definition.
 */
readonly class FilterDefinition
{
    public array $fields;

    public function __construct(
        public string $name,
        array|string $fields,
        public FilterOperator $operator,
    ) {
        $this->fields = Arr::wrap($fields);
    }
}
