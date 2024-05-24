<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $table = 'provinces';

    protected $fillable = [
        'name',
        'gso_id',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function districts()
    {
        return $this->hasMany(District::class,  'province_id');
    }
}
