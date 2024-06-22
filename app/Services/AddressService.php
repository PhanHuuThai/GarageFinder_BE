<?php

namespace App\Services;

use App\Repositories\DistrictRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\WardRepository;

class AddressService extends BaseService
{
    protected $wardRepository;
    protected $districtRepository;
    protected $provinceRepository;

    public function __construct( 
        WardRepository $wardRepository, 
        DistrictRepository $districtRepository, 
        ProvinceRepository $provinceRepository,
        )
    {
        $this->wardRepository = $wardRepository;
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
    }

    public function getAllProvinces()
    {
        $provinces = $this->provinceRepository->getAll();
        return $this->successResult($provinces, "get all provinces success");
    }

    public function getDistrictByIdProvince($id)
    {
        $districts = $this->districtRepository->getDistrictByIdProvince($id);
        return $this->successResult($districts, "get all districts success");
    }

    public function getWardByIdDistrict($id)
    {
        $wards = $this->wardRepository->getWardByIdDistrict($id);
        return $this->successResult($wards, "get all wards success");
    }
}