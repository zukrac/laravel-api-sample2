<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    /** @use HasFactory<\Database\Factories\AddressFactory> */
    use HasFactory;

    protected $table = 'addresses';
    protected $fillable = ['city', 'street', 'house_number', 'latitude', 'longitude'];

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }
}
