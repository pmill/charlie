<?php

namespace App\Models\Pagination;

use App\Support\Url;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Custom paginator that provides additional functionality required for the application.
 */
class Paginator extends LengthAwarePaginator
{
    /**
     * Factory method to wrap an existing Laravel paginator.
     */
    public static function fromLaravelPaginator(LengthAwarePaginator $paginator): self
    {
        return new self(
            $paginator->items(),
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            [
                'path' => $paginator->path(),
                'query' => $paginator->getOptions()['query'] ?? [],
                'pageName' => $paginator->getPageName(),
            ]
        );
    }

    /**
     * Generate a sort URL for a column.
     */
    public function sortUrl(string $column): string
    {
        $currentSortField = request('sort', null);
        $currentSortDirection = request('direction', 'asc');

        $direction = ($currentSortField === $column && $currentSortDirection === 'asc') ? 'desc' : 'asc';

        return request()->fullUrlWithQuery([
            'sort' => $column,
            'direction' => $direction,
        ]);
    }

    /**
     * Retrieve the URL for the next page, merging the request's query string.
     */
    public function nextPageUrl(): ?string
    {
        $url = parent::nextPageUrl();

        return Url::mergeWithRequestQueryString($url);
    }

    /**
     * Get the URL for the previous page, including the current request's query string.
     */
    public function previousPageUrl(): ?string
    {
        $url = parent::previousPageUrl();

        return Url::mergeWithRequestQueryString($url);
    }
}
