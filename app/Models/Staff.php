<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Staff extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'staffs';

    protected $guarded = [];
    public $timestamps = true;

    protected $hidden = [
        'password', 'remember_token',
    ];
}
