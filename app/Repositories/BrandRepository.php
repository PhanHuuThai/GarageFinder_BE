<?php

namespace App\Repositories;

use App\Models\BrandCar;
use App\Repositories\BaseRepository;

class BrandRepository extends BaseRepository
{
    public function getModel()
    {
        return BrandCar::class;
    }

    public function getBrand() {
        return $this->model->paginate(7);
    }
}