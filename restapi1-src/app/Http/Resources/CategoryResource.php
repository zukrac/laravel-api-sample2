<?php

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="CategoryResource", description="Категория", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="Название"),
 *     @OA\Property(property="parent_id", type="integer", description="ID родительской категории", nullable=true),
 *     @OA\Property(property="level", type="integer", description="Уровень"),
 * })
 *
 * @property Category $resource
 */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $category = $this->resource;
        return [
            'id' => $category->id,
            'name' => $category->name,
            'parent_id' => $category->parent_id,
            'level' => $category->level,
        ];
    }
}
