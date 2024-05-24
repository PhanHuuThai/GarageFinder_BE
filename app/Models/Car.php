<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Car extends Model
{
    use HasFactory;
    protected $table = 'car';

    protected $guarded = [];
    public $timestamps = true;

    public function brand(): HasOne
    {
        return $this->hasOne(BrandCar::class, 'id', 'id_brand');
    }
}
