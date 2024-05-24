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

    public function service(): HasMany
    {
        return $this->hasMany(ServiceGarage::class, 'id', 'id_garage');
    }
}
