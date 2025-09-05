<?php

namespace App\Support;

class Url
{
    /**
     * Merges the current request query parameters with those from a given URL.
     *
     * If the provided URL is null, it will return null. Otherwise, it parses the URL,
     * merges its query parameters with the current request's query parameters,
     * and reconstructs the URL with the updated query parameters.
     */
    public static function mergeWithRequestQueryString(?string $url): ?string
    {
        if (! $url) {
            return $url;
        }

        $currentQuery = request()->query();

        $parsedUrl = parse_url($url);
        parse_str($parsedUrl['query'] ?? '', $pageQuery);

        $mergedQuery = array_merge($currentQuery, $pageQuery);

        $scheme = $parsedUrl['scheme'] ?? request()->getScheme();
        $host = $parsedUrl['host'] ?? request()->getHttpHost();
        $port = isset($parsedUrl['port']) ? ':' . $parsedUrl['port'] : '';
        $path = $parsedUrl['path'] ?? '';
        $queryStr = $mergedQuery ? '?' . http_build_query($mergedQuery) : '';
        $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';

        return "{$scheme}://{$host}{$port}{$path}{$queryStr}{$fragment}";
    }
}
