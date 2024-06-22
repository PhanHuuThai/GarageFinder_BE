<?php

namespace App\Repositories;

use App\Models\ServiceGarage;
use App\Repositories\BaseRepository;
use App\Services\BrandService;

class ServiceGarageRepository extends BaseRepository
{
    public function getModel()
    {
        return ServiceGarage::class;
    }
    
    public function insert(array $attribute)
    {
        return $this->model->insert($attribute);
    }

    public function getByIdGarageAndIdService($request)
    {
        return $this->model->where('id_garage', $request->id_garage)
                        ->where('id_service', $request->id_service)
                        ->first();
    }
}