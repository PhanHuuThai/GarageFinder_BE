<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Check results from the Services
     *
     * @param  mixed $result
     * @return void
     */
    public function sendResponse($result)
    {
        if ($result['success']) {
            return $this->sendJsonResponse($result['data'], $result['message']);
        }
        return $this->sendJsonError($result['error'], $result['errorMessages'], $result['code']);
    }

    /**
     * return success response
     *
     * @param  mixed $result
     * @param  mixed $message
     * @return void
     */
    protected function sendJsonResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];

        return response()->json($response, 200);
    }

    /**
     * return error response
     *
     * @param  mixed $error
     * @param  mixed $errorMessages
     * @param  mixed $code
     * @return void
     */
    protected function sendJsonError($error, $errorMessages = [], $code = 200)
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}