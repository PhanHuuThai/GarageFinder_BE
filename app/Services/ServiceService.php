<?php

namespace App\Services;

use App\Repositories\ServiceRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ServiceService extends BaseService
{
    protected $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function getAllService() {
        $services = $this->serviceRepository->getAll();
        return $this->successResult($services, 'get all service success');
    }

    public function registerService($request)
    {
        try {
            $image = null;
            if (!empty($request->image)) {
                $image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            }
            $service = [
                'name' => $request->name,
                'image' => $image,
                'description' => $request->description
            ];
            $service = $this->serviceRepository->create($service);
            if($service) {
                return $this->successResult($service, "create service success");
            }
            return $this->errorResult($service, "create service failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function editService($request, $id)
    {
        try {
            if (!empty($request->image)) {
                $image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            }
            $service = [
                'name' => $request->name,
                'image' => $image,
                'description' => $request->description
            ];
            $service = $this->serviceRepository->update($id, $service);
            if($service) {
                return $this->successResult($service, "update service success");
            }
            return $this->errorResult($service, "update service failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function deleteService($id) 
    {
        $service = $this->serviceRepository->find($id);
        if(!$service) {
            return  $this->errorResult("Car not found", 404);
        }
        $service = $this->serviceRepository->delete($id);
        if($service) {
            return $this->successResult(true, "Sucessfully deleted");
        }
        return $this->errorResult(false, "service delete failed");
    }
}