<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class BrandService extends BaseService
{
    protected $brandRepository;

    public function __construct(BrandRepository $brandRepository)
    {
        $this->brandRepository = $brandRepository;
    }

    public function getAllBrand()
    {
        $brands = $this->brandRepository->getAll();
        return $this->successResult($brands, 'get all brands success');
    }

    public function getBrand()
    {
        try {
            $brands = $this->brandRepository->getBrand();
            return $this->successResult($brands, "get brand success");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function createBrand($brandRequest) 
    {
        try {
            $image = Cloudinary::upload($brandRequest->file('image')->getRealPath())->getSecurePath();
            $brand = [
                "name" => $brandRequest->name,
                "image" => $image,
                "description" => $brandRequest->description
            ];
            $brand = $this->brandRepository->create($brand);
            if($brand) {
                return $this->successResult($brand, "create brand success");
            }
            return $this->errorResult($brand, "create brand failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function updateBrand($brandRequest, $id) 
    {
        try {
            $image = Cloudinary::upload($brandRequest->file('image')->getRealPath())->getSecurePath();
            $brand = [
                "name" => $brandRequest->name,
                "image" => $image,
                "description" => $brandRequest->description
            ];
            $brand = $this->brandRepository->update($id, $brand);
            if($brand) {
                return $this->successResult($brand, "User Updated Successfully");
            } 
            return $this->errorResult($brand, "brand update failed");
            
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
             return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function deleteBrand($id) {
        $brand = $this->brandRepository->find($id);
        if(!$brand) {
            return  $this->errorResult("brand not found", 404);
        }
        $brand = $this->brandRepository->delete($id);
        if($brand) {
            return $this->successResult(true, "Sucessfully deleted");
        }
        return $this->errorResult(false, "brand update failed");
    }
}