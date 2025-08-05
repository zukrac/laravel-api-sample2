<?php

namespace App\Http\Resources;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="AddressResource", description="Компания", properties={
 *     @OA\Property(property="id", type="integer", description="ID соглашения"),
 *     @OA\Property(property="status", type="integer", description="Статус соглашения (0 - не подписан, 1 - подписан одним, 2 - подписан всеми, 3 - прекращён)"),
 *     @OA\Property(property="file_mime_type", type="string", description="MIME тип документа"),
 *     @OA\Property(property="url", type="string", description="Ссылка на документ"),
 *     @OA\Property(property="created_at", type="string", description="Дата создания"),
 *     @OA\Property(property="updated_at", type="string", description="Дата последнего изменения")
 * })
 *
 * @property Address $resource
 */
class AddressResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $address = $this->resource;
        return [
            'id' => $address->id,
            'city' => $address->city,
            'street' => $address->street,
            'house_number' => $address->house_number,
            'apartment_number' => $address->apartment_number,
            'latitude' => $address->latitude,
            'longitude' => $address->longitude,
        ];
    }
}
