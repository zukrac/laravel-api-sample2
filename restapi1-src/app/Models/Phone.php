<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property mixed $id
 * @property mixed $number
 */
class Phone extends Model
{
    /** @use HasFactory<\Database\Factories\PhoneFactory> */
    use HasFactory;

    protected $table = 'phones';
    protected $fillable = ['number'];

    public function company(): HasOne
    {
        return $this->hasOne(Company::class, 'id', 'company_id');
    }
}
