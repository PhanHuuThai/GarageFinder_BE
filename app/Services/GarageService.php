<?php

namespace App\Services;

use App\Repositories\GarageRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class GarageService extends BaseService
{
    protected $garageRepository;

    public function __construct(GarageRepository $garageRepository)
    {
        $this->garageRepository = $garageRepository;
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

    public function createGarage($garageRequest)
    {
        try {
            $img_detail = [];
            $time =  strtotime(date('Y-m-d H:i:s'));
            $image = Cloudinary::upload($garageRequest->file('image')->getRealPath())->getSecurePath();
            if (!empty($garageRequest->image_detail)) {
                foreach ($garageRequest->image_detail as $item) {
                    $image = Cloudinary::upload($item->file('image')->getRealPath())->getSecurePath();
                    $img_detail[] = $image;
                }
            }
            if (!empty($garageRequest->image_thumnail)) {
                // $name_image_thum = $time . '_' . pathinfo($request->image_thumnail->getClientOriginalName(), \PATHINFO_FILENAME) . '.webp';
                // $path = public_path('uploads/garage/thumnail/' . $name_image_thum);
                // $path1 = public_path('uploads/garage/thumnail/1_' . $name_image_thum);
                // Image::make($request->image_thumnail->getRealPath())->encode('webp', 90)->resize(600, 420)->save($path);
                // Image::make($request->image_thumnail->getRealPath())->encode('webp', 90)->resize(400, 300)->save($path1);
                // $img_thum = $name_image_thum;
            }
            $car = [
                "id_user" => auth()->user()->id,
                "id_brand" => $garageRequest->id_brand,
                "name" => $garageRequest->name,
                "type" => $garageRequest->type,
                "license" => $garageRequest->license,
                "image" => $image
            ];
            $car = $this->garageRepository->create($car);
            if($car) {
                return $this->successResult($car, "Sucessfully fetched users");
            }
            return $this->errorResult($car, "car create failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }
}