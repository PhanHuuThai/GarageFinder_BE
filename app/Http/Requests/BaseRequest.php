<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        $response = new JsonResponse([
            'success' => false,
            'message' => $errors[array_key_first($errors)][0]
        ], 200);

        throw new HttpResponseException($response);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param array $rules
     * @param string $method HTTP method (POST, GET, PUT, DELETE)
     * @return array
     */
    protected function mergeRouteParams($method, $properties)
    {
        $methodSplit = explode('|', $method);

        if (!in_array($this->method(), $methodSplit)) {
            return;
        }

        foreach ($properties as $property) {
            $this->merge([$property => $this->route($property)]);
        }
    }

    protected function mergeAllRouteParams($method)
    {
        $methodSplit = explode('|', $method);

        if (!in_array($this->method(), $methodSplit)) {
            return;
        }

        $this->merge($this->route()->parameters());
    }

    /**
     * @param string $method HTTP method (POST, GET, PUT, DELETE)
     * @return array
     */
    protected function isMethodRequest($method)
    {
        return $this->method() === $method;
    }
}