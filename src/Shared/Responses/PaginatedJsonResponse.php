<?php

namespace Shared\Responses;

use Illuminate\Http\JsonResponse;

class PaginatedJsonResponse
{
    public static function from(
        array $items,
        int $total,
        int $page,
        int $perPage,
        ?callable $transform = null
    ): JsonResponse {
        $data = $transform
            ? array_map($transform, $items)
            : $items;

        return new JsonResponse([
            'data' => $data,
            'pagination' => [
                'total' => $total,
                'current_page' => $page,
                'per_page' => $perPage,
            ]
        ]);
    }
}
