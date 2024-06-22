<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BrandGarage extends Model
{
    use HasFactory;
    protected $table = 'brand_garage';

    protected $guarded = [];
    public $timestamps = true;

    public function brand(): BelongsTo
    {
        return $this->belongsTo(BrandCar::class, 'id_brand', 'id');
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class, 'id_garage', 'id');
    }
}
