<?php

namespace App\Repositories;

use App\Repositories\BaseRepository;
use App\Services\BrandService;

class ServiceGarageRepository extends BaseRepository
{
    public function getModel()
    {
        return BrandService::class;
    }
    
    public function insert(array $attribute)
    {
        return $this->model->insert($attribute);
    }
}