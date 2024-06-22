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

    public function getByIdGarageAndIdBrand($request)
    {
        return $this->model->where('id_garage', $request->id_garage)
                        ->where('id_brand', $request->id_brand)
                        ->first();
    }
}