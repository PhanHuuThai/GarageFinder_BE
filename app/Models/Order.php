<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $table = 'orders';

    protected $guarded = [];
    public $timestamps = true;

    public function brand(): BelongsTo
    {
        return $this->belongsTo(BrandCar::class, 'id_brand', 'id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'id_service', 'id');
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class, 'id_garage', 'id');
    }

    public function order_detail(): HasMany
    {
        return $this->hasMany(OrderDetail::class, 'id_order', 'id');
    }
}
