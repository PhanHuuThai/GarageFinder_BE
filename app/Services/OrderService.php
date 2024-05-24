<?php

namespace App\Services;

use App\Repositories\OrderRepository;

class OrderService extends BaseService
{
    protected $orderRepository;

    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getOrderByIdGarage($request) {
        $order = $this->orderRepository->getOrderByIdGarage($request->id);
        return $this->successResult($order, 'get order success');
    }
}