<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\BrandService;
use App\Services\ServiceService;

class AboutController extends Controller
{
    protected $serviceService;   
    protected $brandService; 
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(ServiceService $serviceService, BrandService $brandService)
    {
        $this->serviceService = $serviceService;
        $this->brandService = $brandService;
    }

    public function getAllService() 
    {
        $services = $this->serviceService->getAllService();
        return $this->sendResponse($services);
    }

    public function getAllBrand()
    {
        $brands =  $this->brandService->getAllBrand();
        return $this->sendResponse($brands);
    }
}
