<?php

namespace App\Http\Controllers\garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\StaffRequest;
use App\Services\StaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    protected $staffService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(StaffService $staffService)
    {
        $this->staffService = $staffService;
    }

    public function getStaff($idGarage) 
    {
        $staffs = $this->staffService->getStaffByIdGarage($idGarage);
        return $this->sendResponse($staffs);
    }

    public function registerStaff(StaffRequest $request)
    {
        $staff = $this->staffService->registerStaff($request);
        return $this->sendResponse($staff);
    }

    public function editStaff(StaffRequest $request, $id)
    {
        $staff = $this->staffService->editStaff($request, $id);
        return $this->sendResponse($staff);
    }

    public function deleteStaff($id)
    {
        $staff = $this->staffService->deleteStaff($id);
        return $this->sendResponse($staff);
    }
}
