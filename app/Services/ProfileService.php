<?php

namespace App\Services;

use App\Models\Car;
use App\Repositories\CarRepository;
use App\Repositories\UserRepository;
use App\Repositories\DistrictRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProvinceRepository;
use App\Repositories\WardRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Auth;

class ProfileService extends BaseService
{
    protected $userRepository;
    protected $wardRepository;
    protected $districtRepository;
    protected $provinceRepository;
    protected $carRepository;
    protected $orderRepository;

    public function __construct(
        UserRepository $userRepository, 
        WardRepository $wardRepository, 
        DistrictRepository $districtRepository, 
        ProvinceRepository $provinceRepository,
        CarRepository $carRepository,
        OrderRepository $orderRepository
        )
    {
        $this->userRepository = $userRepository;
        $this->wardRepository = $wardRepository;
        $this->districtRepository = $districtRepository;
        $this->provinceRepository = $provinceRepository;
        $this->carRepository = $carRepository;
        $this->orderRepository = $orderRepository;
    }

    public function update($request)
    {
        try {
            $data = $request->all();
            $address = '';
            $user = $this->userRepository->find(auth()->user()->id);

            if (!empty($request->image)) {
                $data['image'] = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            } else {
                $data['image'] = $user->image;
            }
            if (!empty($request->nest)) {
                $address = $address . $request->nest . ', ';
            }
            if (!empty($request->ward)) {
                $wards = $this->wardRepository->find($request->ward)->first();
                
                $address = $address . $wards->name . ', ';
            }
            if (!empty($request->district)) {
                $districts = $this->districtRepository->find($request->district)->first();
                $address = $address . $districts->name . ', ';
            }
            if (!empty($request->province)) {
                $provinces = $this->provinceRepository->find($request->province)->first();
                $address = $address . $provinces->name;
            }
            if (empty($request->nest) || empty($request->province) || empty($request->district) || empty($request->ward)) {
                $address = $user->address;
                $data['ward'] = $user->id_ward;
            }

            $user->name = $data['name'];
            $user->image = $data['image'];
            $user->phone = $data['phone'];
            $user->address = $address;
            $user->id_ward = $data['ward'] ?? $user->id_ward;
            
            $user = $this->userRepository->updateUser($user);
            return $this->successResult($user, "Sucessfully fetched users");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function createCar($carRequest) 
    {
        try {
            $image = Cloudinary::upload($carRequest->file('image')->getRealPath())->getSecurePath();
            $car = [
                "id_user" => auth()->user()->id,
                "id_brand" => $carRequest->id_brand,
                "name" => $carRequest->name,
                "type" => $carRequest->type,
                "license" => $carRequest->license,
                "image" => $image
            ];
            $car = $this->carRepository->create($car);
            if($car) {
                return $this->successResult($car, "create car success");
            }
            return $this->errorResult($car, "car create failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function updateCar($carRequest, $id) 
    {
        try {
            $image = Cloudinary::upload($carRequest->file('image')->getRealPath())->getSecurePath();
            $car = [
                "id_brand" => $carRequest->id_brand,
                "name" => $carRequest->name,
                "type" => $carRequest->type,
                "license" => $carRequest->license,
                "image" => $image
            ];
            $car = $this->carRepository->update($id, $car);
            if($car) {
                return $this->successResult($car, "update car success");
            } 
            return $this->errorResult($car, "car update failed");
            
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function deleteCar($id) {
        $car = $this->carRepository->find($id);
        if(!$car) {
            return  $this->errorResult("Car not found", 404);
        }
        $car = $this->carRepository->delete($id);
        if($car) {
            return $this->successResult(true, "Sucessfully deleted");
        }
        return $this->errorResult(false, "car delete failed");
    }
    
    public function getOrder($status) {
        if($status == 0) {
            $order = $this->orderRepository->getOrderByIdUser(auth()->user()->id);
        } else {
            $order = $this->orderRepository->getOrderByIdUserAndStatus(auth()->user()->id, $status);
        }
        return $this->successResult($order, 'get order success');
    }
}