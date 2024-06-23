<?php

namespace App\Http\Controllers\garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\GarageRequest;
use App\Services\GarageService;
use Illuminate\Http\Request;

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

    public function getGarageById($id)
    {
        $garage = $this->garageService->getGarageById($id);
        return $this->sendResponse($garage);
    }

    public function getGarageByUserId()
    {
        $garage = $this->garageService->getGarageByUserId();
        return $this->sendResponse($garage);
    }

    public function recommendGarage($id)
    {
        $garages = $this->garageService->recommendGarage($id);
        return $this->sendResponse($garages);
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

    public function search(Request $request)
    {
        $garages = $this->garageService->searchGarage($request);
        return $this->sendResponse($garages);
    }

    public function registerService(Request $request)
    {
        $garage = $this->garageService->addGarageService($request);
        return $this->sendResponse($garage);
    }

    public function registerBrand(Request $request)
    {
        $garage = $this->garageService->addGarageBrand($request);
        return $this->sendResponse($garage);
    }

    public function deleleService(Request $request)
    {
        $garage = $this->garageService->deleteGarageService($request);
        return $this->sendResponse($garage);
    }
    
    public function deleleBrand(Request $request)
    {
        $garage = $this->garageService->deleteGarageBrand($request);
        return $this->sendResponse($garage);
    }
}
