<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BrandCar extends Model
{
    use HasFactory;
    protected $table = 'brand';

    protected $guarded = [];
    public $timestamps = true;

    public function brand_garage(): HasMany
    {
        return $this->hasMany(BrandGarage::class, 'id_brand', 'id');
    }
}
