<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BrandRequest;
use App\Services\BrandService;

class HelpController extends Controller
{
    protected $brandService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(BrandService $brandService)
    {
        $this->brandService = $brandService;
    }

 
}
