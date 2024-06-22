<?php

namespace App\Repositories;

use App\Models\District;
use App\Repositories\BaseRepository;

class DistrictRepository extends BaseRepository
{
    public function getModel()
    {
        return District::class;
    }

    public function getDistrictByIdProvince($id)
    {
        return $this->model->where('province_id', $id)->get();
    }
    
}