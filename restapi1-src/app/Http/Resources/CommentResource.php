<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="CommentResource", description="Комментарий", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="content", type="string", description="Содержание комментария"),
 *     @OA\Property(property="user", type="object", description="Автор комментария",
 *         @OA\Property(property="id", type="integer"),
 *         @OA\Property(property="name", type="string"),
 *         @OA\Property(property="email", type="string"),
 *     ),
 *     @OA\Property(property="commentable_id", type="integer", description="ID комментируемого объекта"),
 *     @OA\Property(property="commentable_type", type="string", description="Тип комментируемого объекта"),
 *     @OA\Property(property="parent_id", type="integer", description="ID родительского комментария", nullable=true),
 *     @OA\Property(property="created_at", type="string", format="date-time", description="Дата создания"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", description="Дата обновления"),
 * })
 *
 * @property Comment $resource
 */
class CommentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $comment = $this->resource;
        return [
            'id' => $comment->id,
            'content' => $comment->content,
            'user' => [
                'id' => $comment->user->id,
                'name' => $comment->user->name,
                'email' => $comment->user->email,
            ],
            'commentable_id' => $comment->commentable_id,
            'commentable_type' => $comment->commentable_type,
            'parent_id' => $comment->parent_id,
            'created_at' => $comment->created_at?->toISOString(),
            'updated_at' => $comment->updated_at?->toISOString(),
        ];
    }
}
