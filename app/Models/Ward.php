<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    protected $table = 'wards';

    protected $fillable = [
        'name',
        'gso_id',
        'published',
        'district_id',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
