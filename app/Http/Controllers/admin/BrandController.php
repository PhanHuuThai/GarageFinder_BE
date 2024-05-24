<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\BrandService;

class BrandController extends Controller
{
    protected $brandService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

    public function getBrand() {
        $brands = $this->brandService->getBrand();
        return $this->sendResponse($brands);
    }

    public function createBrand(BrandRequest $brandRequest) {
        $brand = $this->brandService->createBrand($brandRequest);
        return $this->sendResponse($brand);
    }

    public function updateBrand(BrandRequest $brandRequest, $id) {
        $brand = $this->brandService->updateBrand($brandRequest, $id);
        return $this->sendResponse($brand);
    }

    public function deleteBrand($id) {
        $brand = $this->brandService->deleteBrand($id);
        return $this->sendResponse($brand);
    }
}
