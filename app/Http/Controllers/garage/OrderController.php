<?php

namespace App\Http\Controllers\garage;

use App\Http\Controllers\Controller;
use App\Services\GarageService;
use App\Services\OrderService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function updateStatus(Request $request, $id)
    {
        $order = $this->orderService->updateStatusOrder($request, $id);
        return $this->sendResponse($order);
    }

    public function getCompleteOrder($id)
    {
        $order = $this->orderService->getCompleteOrder($id);
        return $this->sendResponse($order);
    }

    public function showOrder($id) 
    {
        $order = $this->orderService->getOrderByIdGarage($id);
        return $this->sendResponse($order);
    }
}
