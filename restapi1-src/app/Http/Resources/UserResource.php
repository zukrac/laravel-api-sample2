<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(schema="UserResource", description="Пользователь", properties={
 *     @OA\Property(property="id", type="integer", description="ID"),
 *     @OA\Property(property="name", type="string", description="Имя"),
 *     @OA\Property(property="email", type="string", description="Email"),
 * })
 *
 * @property User $resource
 */
class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $user = $this->resource;
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ];
    }
}
