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

    public function getAllGarage() 
    {
        $garages = $this->garageService->getAll();
        return $this->sendResponse($garages);
    }
}
