<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FavouriteGarage extends Model
{
    use HasFactory;

    protected $table = 'favourite_garage';

    protected $guarded = [];
    public $timestamps = true;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function garage(): BelongsTo
    {
        return $this->belongsTo(Garage::class, 'id_garage', 'id');
    }
}
