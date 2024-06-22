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

    public function getHomeGarage()
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

    public function getGarageByUserId($id)
    {
        return $this->model->where('id_user', $id)->first();
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

    public function searchGarage($request)
    {
        return $this->model->whereHas('serviceGarages', function ($query) use ($request) {
                                $query->where('id_service', $request->service);
                            })
                            ->whereHas('brandGarages', function ($query) use ($request) {
                                $query->where('id_brand', $request->brand);
                            })
                            ->where('id_province', $request->province)
                            ->where('name', 'LIKE', '%' . $request->name . '%')
                            ->get();
    }

}