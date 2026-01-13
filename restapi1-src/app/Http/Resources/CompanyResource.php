<?php

namespace App\Http\Resources;

use App\Models\Company;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CommentSectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="CompanyResource", description="Компания", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="Название"),
 *     @OA\Property(property="address", ref="#/components/schemas/PhoneResource", description="Адрес компании"),
 *     @OA\Property(property="phones", type="array", description="Телефоны компании", @OA\Items(ref="#/components/schemas/PhoneResource")),
 *     @OA\Property(property="comments_section", ref="#/components/schemas/CommentSectionResource", description="Секция комментариев компании"),
 * })
 *
 * @property Company $resource
 */
class CompanyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $company = $this->resource;
        $comments = $company->comments()->with(['user', 'parent'])->orderBy('created_at', 'desc')->cursorPaginate(15);

        return [
            'id' => $company->id,
            'name' => $company->name,
            'address' => AddressResource::make($company?->address),
            'phones' => PhoneResource::collection($company->phones),
            'comments_section' => CommentSectionResource::make($comments),
        ];
    }
}
