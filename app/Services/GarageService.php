<?php

namespace App\Services;

use App\Models\BrandCar;
use App\Models\BrandGarage;
use App\Models\Garage;
use App\Models\Province;
use App\Models\Service;
use App\Models\ServiceGarage;
use App\Repositories\BrandGarageRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\GarageRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\ServiceGarageRepository;
use App\Repositories\WardRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Http;

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

    public function recommendGarage($id)
    {
        $recommend_garage = Http::get('http://127.0.0.1:5000/api/recommend-garage/'.$id);
        $garages = $this->garageRepository->getGarageByIds(json_decode($recommend_garage));
        return $this->successResult($garages, "get recommend garage success");
    }

    public function getHomeGarage()
    {
        $garage = $this->garageRepository->getHomeGarage();
        return $this->successResult($garage, "get all garage success");
    }

    public function getGarageByUserId()
    {
        $garage = $this->garageRepository->getGarageByUserId(auth()->user()->id);
        $garage->img_detail = json_decode($garage->img_detail);
        return $this->successResult($garage, "get all garage success");
    }

    public function getGarageById($id) 
    {
        $garage = $this->garageRepository->find($id);
        return $this->successResult($garage, "get detail garage success");
    }

    public function getAllGarage()
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

    public function addGarageService($request)
    {
        try {
            $garageService = [
                "id_garage" => $request->id_garage,
                "id_service" => $request->id_service
            ];
            $garage = $this->serviceGarageRepository->create($garageService);
            return $this->successResult($garage, "add success");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function addGarageBrand($request)
    {
        try {
            $garageBrand = [
                "id_garage" => $request->id_garage,
                "id_brand" => $request->id_brand
            ];
            $garage = $this->brandGarageRepository->create($garageBrand);
            return $this->successResult($garage, "add success");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function deleteGarageService($request)
    { 
        try {
            $garage = $this->serviceGarageRepository->getByIdGarageAndIdService($request);
            $result = $this->serviceGarageRepository->delete($garage->id);
            return $this->successResult($result, "delete success");       
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function deleteGarageBrand($id)
    { 
        try {
            $garage = $this->brandGarageRepository->getByIdGarageAndIdBrand($id);
            $result = $this->brandGarageRepository->delete($garage->id);
            return $this->successResult($result, "delete success");       
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
            $img_detail = [];
            $oldGarage = $this->garageRepository->find($id);
            if (!empty($garageRequest->image_thumnail)) {
                $oldGarage->img_thumnail = Cloudinary::upload($garageRequest->image_thumnail->getRealPath())->getSecurePath();
            }
            if(isset($garageRequest->name)) {
                $oldGarage->name = $garageRequest->name;
            }
            if(isset($garageRequest->email)) {
                $oldGarage->email = $garageRequest->email;
            }
            if(isset($garageRequest->phone)) {
                $oldGarage->phone = $garageRequest->phone;
            }
            if(isset($garageRequest->time_open)) {
                $oldGarage->time_openname = $garageRequest->time_open;
            }
            if(isset($garageRequest->time_close)) {
                $oldGarage->time_close = $garageRequest->time_close;
            }
            if(isset($garageRequest->ward) && isset($garageRequest->id_province) && isset($garageRequest->id_province) && isset($garageRequest->nest)) {
                $oldGarage->id_ward = $garageRequest->ward;
                $oldGarage->id_district = $garageRequest->id_district;
                $oldGarage->id_province = $garageRequest->id_province;
                $wards = $this->wardRepository->find($garageRequest->ward)->first();
                $districts = $this->districtRepository->find($garageRequest->district)->first();
                $provinces = $this->provinceRepository->find($garageRequest->province)->first();
                $oldGarage->address_datail = $garageRequest->nest . ', ' . $wards->name . ', ' . $districts->name . ', ' . $provinces->name;
            }
            if ($garageRequest->image_detail) {
                foreach ($garageRequest->image_detail as $item) {
                    $image = Cloudinary::upload($item->getRealPath())->getSecurePath();
                    $img_detail[] = $image;
                }
            } else {
                $img_detail[] = json_decode($oldGarage->img_detail);
            }
            $garage = [
                "name" => $oldGarage->name,
                "address_detail" => $oldGarage->address_detail,
                "id_ward" => $oldGarage->id_ward,
                "id_district" => $oldGarage->id_district,
                "id_province" => $oldGarage->id_province,
                "email" => $oldGarage->email,
                "phone" => $oldGarage->phone,
                "time_open" => $oldGarage->time_open,
                "time_close" => $oldGarage->time_close,
                "img_thumnail" => $oldGarage->img_thumnail,
                "img_detail" => json_encode($img_detail),
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

    public function searchGarage($request)
    {
        $garages = $this->garageRepository->searchGarage($request);
        return $this->successResult($garages, "get Garage Success");
    }
}