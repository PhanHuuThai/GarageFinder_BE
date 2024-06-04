<?php

namespace App\Repositories;

use App\Models\BrandGarage;
use App\Repositories\BaseRepository;

class BrandGarageRepository extends BaseRepository
{
    public function getModel()
    {
        return BrandGarage::class;
    }

    public function insert(array $attribute)
    {
        return $this->model->insert($attribute);
    }
    
}