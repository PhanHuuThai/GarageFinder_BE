<?php
namespace App\Services;

/**
 * @var BaseService
 * @package App/BaseService
 */
class BaseService
{
    public function successResult($data, $message)
    {
        return [
            'success' => true,
            'data' => $data,
            'message' => $message
        ];
    }

    public function errorResult($error, $errorMessages = [], $code = 200)
    {
        return [
            'success' => false,
            'error' => $error,
            'errorMessages' => $errorMessages,
            'code' => $code
        ];
    }
}