<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Services\HelpService;
use Illuminate\Http\Request;

class ClientHelpController extends Controller
{
    protected $helpService;    
    /**
     * __construct
     *
     * @param  mixed $userService
     */
    public function __construct(HelpService $helpService)
    {
        $this->helpService = $helpService;
    }

    public function createHelp(Request $request)
    {
        $help = $this->helpService->register($request);
        return $this->sendResponse($help);
    }

    public function updateStatus(Request $request, $id)
    {
        $help = $this->helpService->updateStatus($request, $id);
        return $this->sendResponse($help);
    }
}
