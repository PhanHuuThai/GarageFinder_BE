<?php

namespace App\Services;

use App\Repositories\StaffRepository;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Hash;

class StaffService extends BaseService
{
    protected $staffRepository;

    public function __construct(StaffRepository $staffRepository)
    {
        $this->staffRepository = $staffRepository;
    }

    public function getStaffByIdGarage($idGarage)
    {
        try {
            $staffs = $this->staffRepository->getStaffByIdGarage($idGarage);
            return $this->successResult($staffs, "Sucessfully get staffs");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function registerStaff($request)
    {
        try {
            $time =  strtotime(date('Y-m-d H:i:s'));
            $image = null;
            if (!empty($request->image)) {
                $image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            }
            $staff = [
                'id_employee' => trim($request->id_garage . "-" . $time),
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
                'image' => $image,
                'id_garage' => $request->id_garage,
                'gender' => $request->gender,
                'status' => 1,
            ];
            $staff = $this->staffRepository->create($staff);
            if($staff) {
                return $this->successResult($staff, "create staff success");
            }
            return $this->errorResult($staff, "create staff failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function editStaff($request, $id)
    {
        try {
            if (!empty($request->image)) {
                $image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            }
            $staff = [
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'image' => $image,
                'gender' => $request->gender,
                'status' => 1,
            ];
            $staff = $this->staffRepository->update($id, $staff);
            if($staff) {
                return $this->successResult($staff, "update staff success");
            }
            return $this->errorResult($staff, "update staff failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function deleteStaff($id) 
    {
        $staff = $this->staffRepository->find($id);
        if(!$staff) {
            return  $this->errorResult("Car not found", 404);
        }
        $staff = $this->staffRepository->delete($id);
        if($staff) {
            return $this->successResult(true, "Sucessfully deleted");
        }
        return $this->errorResult(false, "staff delete failed");
    }
}