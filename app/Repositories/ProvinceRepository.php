<?php

namespace App\Repositories;

use App\Models\Province;
use App\Repositories\BaseRepository;

class ProvinceRepository extends BaseRepository
{
    public function getModel()
    {
        return Province::class;
    }
    
}