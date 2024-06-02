<?php

namespace App\Http\Controllers\garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\GarageRequest;
use App\Services\GarageService;

class GarageController extends Controller
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

    public function register(GarageRequest $request) 
    {
        $garage = $this->garageService->registerGarage($request);
        return $this->sendResponse($garage);
    }

    public function edit(GarageRequest $request, $id)
    {
        $garage = $this->garageService->editGarage($request, $id);
        return $this->sendResponse($garage);
    }
}
