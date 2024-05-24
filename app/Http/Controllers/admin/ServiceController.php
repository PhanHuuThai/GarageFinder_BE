<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\ServiceRequest;
use App\Services\ServiceService;
class ServiceController extends Controller
{
    protected $serviceService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function registerService(ServiceRequest $request)
    {
        $staff = $this->serviceService->registerService($request);
        return $this->sendResponse($staff);
    }

    public function editService(ServiceRequest $request, $id)
    {
        $staff = $this->serviceService->editService($request, $id);
        return $this->sendResponse($staff);
    }

    public function deleteService($id)
    {
        $staff = $this->serviceService->deleteService($id);
        return $this->sendResponse($staff);
    }
}