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


    public function showOrder(Request $request) 
    {
        $order = $this->orderService->getOrderByIdGarage($request);
        return $this->sendResponse($order);
    }
}
