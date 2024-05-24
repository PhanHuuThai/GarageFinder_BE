<?php

namespace App\Repositories;

use App\Models\Service;
use App\Repositories\BaseRepository;

class ServiceRepository extends BaseRepository
{
    public function getModel()
    {
        return Service::class;
    }
    
}