<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\GarageService;

class HomeController extends Controller
{
    protected $garageService; 
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(GarageService $garageService)
    {
        $this->garageService = $garageService;
    }

    public function getHomeGarage() 
    {
        $garages = $this->garageService->getHomeGarage();
        return $this->sendResponse($garages);
    }

    public function getAllGarage() 
    {
        $garages = $this->garageService->getAllGarage();
        return $this->sendResponse($garages);
    }
}
