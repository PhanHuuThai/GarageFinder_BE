<?php

namespace App\Http\Controllers\garage;

use App\Http\Controllers\Controller;
use App\Http\Requests\Garage\GarageRequest;
use App\Models\BrandCar;
use App\Models\BrandGarage;
use App\Models\Car;
use App\Models\Garage;
use App\Models\ServiceGarage;
use App\Services\GarageService;
use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class GarageController extends Controller
{
    protected $garageService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(GarageService $garageService)
    {
        $this->garageService = $garageService;
    }

    public function getGarageById($id)
    {
        $garage = $this->garageService->getGarageById($id);
        return $this->sendResponse($garage);
    }

    public function getGarageByUserId()
    {
        $garage = $this->garageService->getGarageByUserId();
        return $this->sendResponse($garage);
    }

    public function recommendGarage($id)
    {
        $garage = Garage::find($id);
        $service = ServiceGarage::where('id_garage', $garage->id)->get();
        $brand = BrandGarage::where('id_garage', $garage->id)->get();

        //recommend garage
        $path = public_path('python/main.py');
        $process = new Process(['python', $path, $id]);
        
        $process->run();
        
        // error handling
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        $output_data = json_decode($process->getOutput(), true);
        //dd($output_data);
        $ids = implode(',', $output_data);

        $recommend_garage = Garage::whereIn('id', $output_data)->orderByRaw("FIELD(id,{$ids})")->get();
        return response()->json([
            'data' => $recommend_garage,
            'status' => true,
            'message' => 'Logout success',
        ], 200);
    }

    public function register(GarageRequest $request) 
    {
        $garage = $this->garageService->registerGarage($request);
        return $this->sendResponse($garage);
    }

    public function edit(GarageRequest $request, $id)
    {
        $garage = $this->garageService->editGarage($request, $id);
        return $this->sendResponse($garage);
    }

    public function search(Request $request)
    {
        $garages = $this->garageService->searchGarage($request);
        return $this->sendResponse($garages);
    }

    public function registerService(Request $request)
    {
        $garage = $this->garageService->addGarageService($request);
        return $this->sendResponse($garage);
    }

    public function registerBrand(Request $request)
    {
        $garage = $this->garageService->addGarageBrand($request);
        return $this->sendResponse($garage);
    }

    public function deleleService(Request $request)
    {
        $garage = $this->garageService->deleteGarageService($request);
        return $this->sendResponse($garage);
    }
    
    public function deleleBrand(Request $request)
    {
        $garage = $this->garageService->deleteGarageBrand($request);
        return $this->sendResponse($garage);
    }
}
