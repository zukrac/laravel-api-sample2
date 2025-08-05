<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $id
 * @property mixed $name
 * @property mixed $address
 * @property mixed $phones
 * @property mixed $categories
 */
class Company extends Model
{
    /** @use HasFactory<\Database\Factories\CompanyFactory> */
    use HasFactory;

    protected $table = 'companies';
    protected $fillable = ['name'];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_company', 'company_id', 'category_id');
    }

    public function phones(): HasMany
    {
        return $this->hasMany(Phone::class);
    }
}
