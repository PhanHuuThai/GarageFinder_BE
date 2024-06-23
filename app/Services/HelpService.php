<?php

namespace App\Services;

use App\Repositories\HelpRepository;

class HelpService extends BaseService
{
    protected $helpRepository;

    public function __construct(HelpRepository $helpRepository)
    {
        $this->helpRepository = $helpRepository;
    }

    public function register($request) 
    {
        try {
            $help = [
                "email" => $request->email,
                "name" => $request->name,
                "phone" => $request->phone,
                "message" => $request->message,
                "status" => 1
            ];
            $help = $this->helpRepository->create($help);
            return $this->successResult($help, "create help success");
        } catch (\Exception $e) {
            \Log::info("Register user error: Code:" . $e->getCode(). "  Message: " .$e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function updateStatus($request, $id) 
    {
        try {
            $help = [
                "status" => $request->status
            ];
            $help = $this->helpRepository->update($id, $help);
            return $this->successResult($help, "update help success");
        } catch (\Exception $e) {
            \Log::info("Register user error: Code:" . $e->getCode(). "  Message: " .$e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }
}