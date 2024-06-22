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
 
    public function getWardByIdDistrict($id)
    {
        return $this->model->where('district_id', $id)->get();
    }
}