<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\FavouriteGarageRequest;
use App\Services\FavouriteGarageService;

class FavouriteGarageController extends Controller
{
    protected $favouriteGarageService; 
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(FavouriteGarageService $favouriteGarageService)
    {
        $this->favouriteGarageService = $favouriteGarageService;
    }

    public function getFavouriteGarageByUserId()
    {
        $garages = $this->favouriteGarageService->getFavouriteGarageByIdUser();
        return $this->sendResponse($garages);
    }

    public function registerFavouriteGarage(FavouriteGarageRequest $request) 
    {
        $favou = $this->favouriteGarageService->registerFavouriteGarage($request);
        return $this->sendResponse($favou);
    }

}
