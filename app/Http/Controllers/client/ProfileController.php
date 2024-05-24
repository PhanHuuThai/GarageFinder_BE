<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\CarRequest;
use App\Services\ProfileService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    protected $profileService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }


    public function update(Request $request) 
    {
    //    return $request->ward;
        $user = $this->profileService->update($request);
        return $this->sendResponse($user);
    }

    public function createCar(CarRequest $carRequest) {
        $car = $this->profileService->createCar($carRequest);
        return $this->sendResponse($car);
    }

    public function updateCar(CarRequest $carRequest, $id) {
        
        $car = $this->profileService->updateCar($carRequest, $id);
        return $this->sendResponse($car);
    }

    public function deleteCar($id) {
        $car = $this->profileService->deleteCar($id);
        return $this->sendResponse($car);
    }

    public function getOrder($status) {
        $order = $this->profileService->getOrder($status);
        return $this->sendResponse($order);
    }
}
