<?php

namespace App\Services;

use App\Repositories\BrandRepository;
use App\Repositories\CarRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ServiceRepository;

class OrderService extends BaseService
{
    protected $orderRepository;
    protected $carRepository;
    protected $brandRepository;
    protected $serviceRepository;

    public function __construct(OrderRepository $orderRepository, CarRepository $carRepository, BrandRepository $brandRepository, ServiceRepository $serviceRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->carRepository = $carRepository;
        $this->brandRepository = $brandRepository;
        $this->serviceRepository = $serviceRepository;
    }

    public function updateStatusOrder($request, $id)
    {
        try {
            $order = [
                "status" => $request->status
            ];
            $order = $this->orderRepository->update($id, $order);
            if($order) {
                return $this->successResult($order, "update order success");
            }
            return $this->errorResult($order, "update order failed");
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
            return $this->errorResult($e->getMessage(), [], 200);
        }
    }

    public function getCompleteOrder($id)
    {
        $orders = $this->orderRepository->getCompleteOrder($id);
        $ids = collect($orders)->pluck('id_brand')->unique()->toArray();
        $idServices = collect($orders)->pluck('id_service')->unique()->toArray();
        $brands = $this->brandRepository->getBrandByIds($ids);
        $services = $this->serviceRepository->getServiceByIds($idServices);
        $brandMap = $brands->pluck('name', 'id')->toArray();
        $serviceMap = $services->pluck('name', 'id')->toArray();
        $order = $orders->map(function ($order) use ($brandMap) {
            if (isset($brandMap[$order->id_brand])) {
                $order->brand_name = $brandMap[$order->id_brand];
            } else {
                $order->brand_name = null; // Nếu không tìm thấy brand tương ứng, có thể gán giá trị null hoặc một giá trị mặc định
            }
            return $order;
        });

        $order = $orders->map(function ($order) use ($serviceMap) {
            if (isset($serviceMap[$order->id_service])) {
                $order->service_name = $serviceMap[$order->id_service];
            } else {
                $order->service_name = null; // Nếu không tìm thấy brand tương ứng, có thể gán giá trị null hoặc một giá trị mặc định
            }
            return $order;
        });
        return $this->successResult($orders, "get order success");
    }

    public function getOrderByIdGarage($id) {
        $orders = $this->orderRepository->getOrderByIdGarage($id);
        $ids = collect($orders)->pluck('id_brand')->unique()->toArray();
        $idServices = collect($orders)->pluck('id_service')->unique()->toArray();
        $brands = $this->brandRepository->getBrandByIds($ids);
        $services = $this->serviceRepository->getServiceByIds($idServices);
        $brandMap = $brands->pluck('name', 'id')->toArray();
        $serviceMap = $services->pluck('name', 'id')->toArray();
        $order = $orders->map(function ($order) use ($brandMap) {
            if (isset($brandMap[$order->id_brand])) {
                $order->brand_name = $brandMap[$order->id_brand];
            } else {
                $order->brand_name = null; // Nếu không tìm thấy brand tương ứng, có thể gán giá trị null hoặc một giá trị mặc định
            }
            return $order;
        });

        $order = $orders->map(function ($order) use ($serviceMap) {
            if (isset($serviceMap[$order->id_service])) {
                $order->service_name = $serviceMap[$order->id_service];
            } else {
                $order->service_name = null; // Nếu không tìm thấy brand tương ứng, có thể gán giá trị null hoặc một giá trị mặc định
            }
            return $order;
        });
    
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