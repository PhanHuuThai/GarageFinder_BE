<?php

namespace App\Services;

use App\Models\BrandGarage;
use App\Models\Garage;
use App\Models\Service;
use App\Models\ServiceGarage;
use App\Repositories\BrandGarageRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\GarageRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\ServiceGarageRepository;
use App\Repositories\WardRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class GarageService extends BaseService
{
    protected $garageRepository;
    protected $wardRepository;
    protected $districtRepository;
    protected $provinceRepository;
    protected $brandGarageRepository;
    protected $serviceGarageRepository;

    public function __construct(
        GarageRepository $garageRepository,
        WardRepository $wardRepository, 
        DistrictRepository $districtRepository, 
        ProvinceRepository $provinceRepository,
        BrandGarageRepository $brandGarageRepository,
        ServiceGarageRepository $serviceGarageRepository
        )
    {
        $this->garageRepository = $garageRepository;
        $this->wardRepository = $wardRepository;
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
        $this->serviceGarageRepository = $serviceGarageRepository;
        $this->brandGarageRepository = $brandGarageRepository;
    }

    public function getAll()
    {
        $garage = $this->garageRepository->getAll();
        return $this->successResult($garage, "get all garage success");
    }

    public function getAllGarageRegister()
    {
        try {
            $garage = $this->garageRepository->getAllGarageRegister();
            return $this->successResult($garage, "get garage register success");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function updateGarageStatus($request, $id)
    {
        try {
            $garage = $this->garageRepository->updateStatusGarage($request, $id);
            if($garage) {
                return $this->successResult($garage, "updat garage success");
            }
            return $this->errorResult(false, "update failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function registerGarage($garageRequest)
    {
        try {
            $img_detail = [];
            $time =  strtotime(date('Y-m-d H:i:s'));
            if ($garageRequest->image_detail) {
                foreach ($garageRequest->image_detail as $item) {
                    $image = Cloudinary::upload($item->getRealPath())->getSecurePath();
                    $img_detail[] = $image;
                }
            }
            if (!empty($garageRequest->image_thumnail)) {
                $name_image_thum = Cloudinary::upload($garageRequest->image_thumnail->getRealPath())->getSecurePath();
            }
            $wards = $this->wardRepository->find($garageRequest->ward)->first();
            $districts = $this->districtRepository->find($garageRequest->district)->first();
            $provinces = $this->provinceRepository->find($garageRequest->province)->first();
            $address_detail = $garageRequest->nest . ', ' . $wards->name . ', ' . $districts->name . ', ' . $provinces->name;
            
            $garage = [
                "name" => $garageRequest->name,
                "address_detail" => $address_detail,
                "id_ward" => $garageRequest->ward,
                "id_district" => $garageRequest->district,
                "id_province" => $garageRequest->province,
                "id_user" => auth()->user()->id,
                "email" => $garageRequest->email,
                "phone" => $garageRequest->phone,
                "time_open" => $garageRequest->time_open,
                "time_close" => $garageRequest->time_close,
                "img_thumnail" => $name_image_thum,
                "img_detail" => json_encode($img_detail),
                "status" => 1,
                "action" => 1,
                
            ];
            $garage = $this->garageRepository->create($garage);
            if($garage) {
                $brand = [];
                foreach ($garageRequest->brand as $br) {
                    $brand[] = [
                        'id_garage'  =>  $garage->id,
                        'id_brand'    => $br
                    ];
                }
                $service = [];
                foreach ($garageRequest->service as $sv) {
                    $service[] = [
                        'id_garage'  => $garage->id,
                        'id_service'    => $sv
                    ];
                }
                $brand = BrandGarage::insert($brand);
                $service = ServiceGarage::insert($service);
                if($brand && $service) {
                    return $this->successResult($garage, "register garage success");
                }
            }
            return $this->errorResult($garage, "register garage failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function editGarage($garageRequest, $id) {
        try {
            if (!empty($garageRequest->image_thumnail)) {
                $name_image_thum = Cloudinary::upload($garageRequest->image_thumnail->getRealPath())->getSecurePath();
            }
            $wards = $this->wardRepository->find($garageRequest->ward)->first();
            $districts = $this->districtRepository->find($garageRequest->district)->first();
            $provinces = $this->provinceRepository->find($garageRequest->province)->first();
            $address_detail = $garageRequest->nest . ', ' . $wards->name . ', ' . $districts->name . ', ' . $provinces->name;
            
            $garage = [
                "name" => $garageRequest->name,
                "address_detail" => $address_detail,
                "id_ward" => $garageRequest->ward,
                "id_district" => $garageRequest->district,
                "id_province" => $garageRequest->province,
                "email" => $garageRequest->email,
                "phone" => $garageRequest->phone,
                "time_open" => $garageRequest->time_open,
                "time_close" => $garageRequest->time_close,
                "img_thumnail" => $name_image_thum,
            ];
            $garage = $this->garageRepository->update($id, $garage);
            if($garage) {
                return $this->successResult($garage, "garage car success");
            } 
            return $this->errorResult($garage, "garage update failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }
}