<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $table = 'service';

    protected $guarded = [];
    public $timestamps = true;

    public function service_garage(): HasMany
    {
        return $this->hasMany(ServiceGarage::class, 'id_brand', 'id');
    }
}
