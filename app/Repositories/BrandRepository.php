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

    public function getBrandByIdGarage($id)
    {
        return $this->model->whereHas('brand_garage', function ($query) use ($id) {
                                $query->where('id_garage', $id);
                            })
                            ->get();
    }   

    public function getBrandByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}