<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="ProductResource", description="Продукт", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="Название"),
 *     @OA\Property(property="sku", type="string", description="SKU"),
 *     @OA\Property(property="price", type="number", format="float", description="Цена"),
 *     @OA\Property(property="type", type="string", description="Тип продукта"),
 *     @OA\Property(property="description", type="string", description="Описание"),
 *     @OA\Property(property="quantity", type="integer", description="Количество"),
 *     @OA\Property(property="weight", type="number", format="float", description="Вес"),
 *     @OA\Property(property="length", type="number", format="float", description="Длина"),
 *     @OA\Property(property="width", type="number", format="float", description="Ширина"),
 *     @OA\Property(property="height", type="number", format="float", description="Высота"),
 *     @OA\Property(property="is_active", type="boolean", description="Активен"),
 *     @OA\Property(property="is_featured", type="boolean", description="Рекомендуемый"),
 *     @OA\Property(property="meta_title", type="string", description="Мета заголовок"),
 *     @OA\Property(property="meta_description", type="string", description="Мета описание"),
 *     @OA\Property(property="meta_keywords", type="string", description="Мета ключевые слова"),
 *     @OA\Property(property="company_id", type="integer", description="ID компании", nullable=true),
 * })
 *
 * @property Product $resource
 */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $product = $this->resource;
        return [
            'id' => $product->id,
            'name' => $product->name,
            'sku' => $product->sku,
            'price' => $product->price,
            'type' => $product->type,
            'description' => $product->description,
            'quantity' => $product->quantity,
            'weight' => $product->weight,
            'length' => $product->length,
            'width' => $product->width,
            'height' => $product->height,
            'is_active' => $product->is_active,
            'is_featured' => $product->is_featured,
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'meta_keywords' => $product->meta_keywords,
            'company_id' => $product->company_id,
        ];
    }
}
