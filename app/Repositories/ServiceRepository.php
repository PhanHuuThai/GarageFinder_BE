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
    
    public function getServiceByIdGarage($id)
    {
        return $this->model->whereHas('service_garage', function ($query) use ($id) {
                                $query->where('id_garage', $id);
                            })
                            ->get();
    }   

    public function getServiceByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }
}