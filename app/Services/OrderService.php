<?php

namespace App\Services;

use App\Repositories\CarRepository;
use App\Repositories\OrderRepository;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $carRepository;

    public function __construct(OrderRepository $orderRepository, CarRepository $carRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->carRepository = $carRepository;
    }

    public function getOrderByIdGarage($request) {
        $order = $this->orderRepository->getOrderByIdGarage($request->id);
        return $this->successResult($order, 'get order success');
    }

    public function createBooking($request) {
        try {
            if ($request->status == 1) {
                $car = $this->carRepository->find($request->car);
                $id_car = $request->car;
                $name_car = $car->name;
                $license = $car->license;
                $brand = $car->id_brand;
            } else if ($request->status == 2) {
                $id_car = null;
                $name_car = $request->name_car;
                $license = $request->license;
                $brand = $request->brand_all;
            }
            $order = [
                "id_garage" => $request->id_garage,
                "id_user" => auth()->user()->id,
                "id_car" => $id_car,
                "name" => $request->name,
                "phone" => $request->phone,
                "email" => $request->email,
                "id_brand" => $brand,
                "id_service" => $request->service,
                "license" => $license,
                "car_name" => $name_car,
                "time" => strtotime($request->date . " " . $request->time),
                "note" => "",
                "status" => 1,
            ];
            $order = $this->orderRepository->create($order);
            if($order) {
                return $this->successResult($order, "create order success");
            }
            return $this->errorResult($order, "order create failed");
        }
        catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function editBooking($request, $id) {
        
    }
}