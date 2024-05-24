<?php

namespace App\Repositories;

use App\Models\FavouriteGarage;
use App\Repositories\BaseRepository;

class FavouriteGarageRepository extends BaseRepository
{
    public function getModel()
    {
        return FavouriteGarage::class;
    }

    public function getFavouriteGarageByIdUser($id)
    {
        return $this->model->where('id_user', $id)->get();
    }

}