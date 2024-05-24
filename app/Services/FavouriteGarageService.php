<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use App\Repositories\FavouriteGarageRepository;
use App\Repositories\GarageRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class FavouriteGarageService extends BaseService
{
    protected $favouriteGarageRepository;
    protected $garageRepository;

    public function __construct(FavouriteGarageRepository $favouriteGarageRepository, GarageRepository $garageRepository)
    {
        $this->favouriteGarageRepository = $favouriteGarageRepository;
        $this->garageRepository = $garageRepository;
    }

    public function getFavouriteGarageByIdUser()
    {
        $fav = $this->favouriteGarageRepository->getFavouriteGarageByIdUser(auth()->user()->id);
        if(count($fav) == 0) {
            return $this->successResult([], "user not have favourite garage");
        }
        $id_garage = collect($fav)->pluck('id_garage')->toArray();
        $garages = $this->garageRepository->getGarageByIds($id_garage);
        return $this->successResult($garages, 'get all favourite garage success');
    }

    public function registerFavouriteGarage($favouriteRequest) 
    {
        try {
            $fav = [
                "id_user" => auth()->user()->id,
                "id_garage" => $favouriteRequest->id_garage
            ];
            $fav = $this->favouriteGarageRepository->create($fav);
            if($fav) {
                return $this->successResult($fav, "create favourite garage success");
            } 
            return $this->errorResult($fav, "create favourite garage failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

}