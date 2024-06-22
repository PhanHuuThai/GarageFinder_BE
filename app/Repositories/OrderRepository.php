<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;

class OrderRepository extends BaseRepository
{
    public function getModel()
    {
        return Order::class;
    }

    public function getOrderByIdUser($id) {
        return $this->model->where('id_user', $id)->orderBy('created_at')->get();
    }

    public function getCompleteOrder($id) {
        return $this->model->where('id_garage', $id)
                        ->where('status', 2)->get();
    }

    public function getOrderByIdUserAndStatus($id, $status) {
        return $this->model->where('id_user', $id)->where('status', $status)->orderBy('created_at')->get();
    }
    
    public function getOrderByIdGarage($id) {
        return $this->model->where('id_garage', $id)->orderBy('created_at', 'DESC')->get();
    }
}