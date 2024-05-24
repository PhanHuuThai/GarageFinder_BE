<?php

namespace App\Http\Controllers\garage;

use App\Http\Controllers\Controller;
use App\Services\GarageService;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ProfileController extends Controller
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


    public function create(Request $request) 
    {

        
    }
}
