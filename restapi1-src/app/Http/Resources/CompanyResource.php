<?php

namespace App\Http\Resources;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="CompanyResource", description="Компания", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="Название"),
 *     @OA\Property(property="address", ref="#/components/schemas/PhoneResource", description="Адрес компании"),
 *     @OA\Property(property="phones", type="array", description="Телефоны компании", @OA\Items(ref="#/components/schemas/PhoneResource")),
 * })
 *
 * @property Company $resource
 */
class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $company = $this->resource;
        return [
            'id' => $company->id,
            'name' => $company->name,
            'address' => AddressResource::make($company?->address),
            'phones' => PhoneResource::collection($company->phones),
        ];
    }
}
