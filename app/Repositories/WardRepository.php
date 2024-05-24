<?php

namespace App\Repositories;

use App\Models\Ward;
use App\Repositories\BaseRepository;

class WardRepository extends BaseRepository
{
    public function getModel()
    {
        return Ward::class;
    }
    
}