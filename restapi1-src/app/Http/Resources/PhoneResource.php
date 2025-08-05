<?php

namespace App\Http\Resources;

use App\Models\Company;
use App\Models\Phone;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="PhoneResource", description="Компания", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="Название"),
 * })
 *
 * @property Phone $resource
 */
class PhoneResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $phone = $this->resource;
        return [
            'id' => $phone->id,
            'number' => $phone->number,
        ];
    }
}
