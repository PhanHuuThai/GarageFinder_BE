<?php

namespace App\Repositories;

use App\Models\Garage;
use App\Repositories\BaseRepository;

class GarageRepository extends BaseRepository
{
    public function getModel()
    {
        return Garage::class;
    }

    public function getAll()
    {
        return $this->model->orderByRaw('RAND()')->take(9)->get();
    }
    
    public function getAllGarageRegister() {
        return $this->model->where('status', 1)->get();
    }

    public function getGarageByIds($ids)
    {
        return $this->model->whereIn('id', $ids)->get();
    }

    public function updateStatusGarage($request, $id) {
        try{
            $garage = $this->model->find($id);
            $garage->status = $request->status;
            $garage->save();
            return $garage;
        } catch (\Exception $e) {
            \Log::debug($e->getMessage());
            abort(500, $e->getMessage());
        }
    }

}