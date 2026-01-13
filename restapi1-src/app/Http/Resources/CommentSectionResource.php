<?php

namespace App\Http\Resources;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="CommentSectionResource", description="Секция комментариев с пагинацией", properties={
 *     @OA\Property(property="data", type="array", description="Список комментариев", @OA\Items(ref="#/components/schemas/CommentResource")),
 *     @OA\Property(property="next_cursor", type="string", description="Курсор для следующей страницы", nullable=true),
 *     @OA\Property(property="prev_cursor", type="string", description="Курсор для предыдущей страницы", nullable=true),
 *     @OA\Property(property="per_page", type="integer", description="Количество элементов на странице"),
 * })
 *
 * @property CursorPaginator $resource
 */
class CommentSectionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $paginator = $this->resource;
        return [
            'data' => CommentResource::collection($paginator->items()),
            'next_cursor' => $paginator->nextCursor()?->encode(),
            'prev_cursor' => $paginator->previousCursor()?->encode(),
            'per_page' => $paginator->perPage(),
        ];
    }
}
