<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\AddressService;

class AddressController extends Controller
{
    protected $addressService; 
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(AddressService $addressService)
    {
        $this->addressService = $addressService;
    }

    public function getAllProvinces() 
    {
        $provinces = $this->addressService->getAllProvinces();
        return $this->sendResponse($provinces);
    }

    public function getDistrictByIdProvince($id)
    {
        $districts = $this->addressService->getDistrictByIdProvince($id);
        return $this->sendResponse($districts);
    }

    public function getWardByIdDistrict($id)
    {
        $wards = $this->addressService->getWardByIdDistrict($id);
        return $this->sendResponse($wards);
    }
}
