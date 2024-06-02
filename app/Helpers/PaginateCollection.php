<?php

namespace App\Helpers;

use Illuminate\Pagination\LengthAwarePaginator;

class PaginateCollection
{
    public function handle($collection, $currentPage=1, $perPage=10)
    {
        $result = new LengthAwarePaginator(
            $collection->forPage($currentPage,$perPage),
            $collection->count(),
            $perPage,
            $currentPage,
            [
                'path' => url()->current(), // Current path for generating links
                'query' => request()->query(), // Keep existing query parameters
            ]
        );
        return $result;
    }
}
