<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\OrderRequest;
use App\Services\OrderService;

class OrderClientController extends Controller
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

    public function createBooking(OrderRequest $request) 
    {
        $order = $this->orderService->createBooking($request);
        return $this->sendResponse($order);
    }
}
