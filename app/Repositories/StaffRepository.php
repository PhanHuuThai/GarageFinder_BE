<?php

namespace App\Repositories;

use App\Models\Staff;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Hash;

class StaffRepository extends BaseRepository
{
    public function getModel()
    {
        return Staff::class;
    }

    public function all()
    {
        return $this->model->get();
    }

    public function getStaffByIdGarage($id) {
        return $this->model->where('id_garage', $id)->get();
    }

}