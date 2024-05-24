<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Services\GarageService;
use Illuminate\Http\Request;

class GarageRegisterController extends Controller
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

    public function getAllGarageRegister() 
    {
        $garage = $this->garageService->getAllGarageRegister();
        return $this->sendResponse($garage);
    }
 
    public function updateGarageStatus(Request $request, $id)
    {
        $garage = $this->garageService->updateGarageStatus($request, $id);
        return $this->sendResponse($garage);
    }
}
