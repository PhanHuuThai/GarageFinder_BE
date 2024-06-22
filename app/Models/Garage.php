<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Garage extends Model
{
    use HasFactory;
    protected $table = 'garage';

    protected $guarded = [];
    public $timestamps = true;

    public function serviceGarages(): HasMany
    {
        return $this->hasMany(ServiceGarage::class, 'id_garage', 'id');
    }

    public function brandGarages(): HasMany
    {
        return $this->hasMany(BrandGarage::class, 'id_garage', 'id');
    }
}
