<?php

namespace App\Repositories;

use App\Models\Car;
use App\Repositories\BaseRepository;

class CarRepository extends BaseRepository
{
    public function getModel()
    {
        return Car::class;
    }

    public function getCarByUserId($id)
    {
        return $this->model->where('id_user', $id)->get();
    }
}