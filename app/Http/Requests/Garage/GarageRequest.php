<?php

namespace App\Http\Requests\Garage;

use App\Http\Requests\BaseRequest;

class GarageRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }


    protected function prepareForValidation()
    {
        $this->mergeAllRouteParams('POST|PUT|DELETE|GET');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'DELETE':
                return $this->deleteRules();
            case 'POST':
                return $this->postRules();
            case 'PUT':
                return $this->putRules();
            case 'GET':
                return $this->getRules();
            default:
                return [];
        }
    }

    protected function deleteRules()
    {
        return [];
    }

    protected function postRules()
    {
        return [
            'image_thumnail' => 'required|mimes:jpeg,png,jpg,webp',
            // 'image_detail.*' => 'required|mimes:jpeg,png,jpg,webp',
            // 'image_detail' => 'required',
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:11',
            'nest' => 'required',
            'province' => 'required',
            'district' => 'required',
            'ward' => 'required',
            'time_open' => 'required|date_format:H:i',
            'time_close' => 'required|date_format:H:i|after:time_open',
            'brand' => 'required',
            'service' => 'required'
        ];
    }

    protected function putRules()
    {
        return [
            'image_thumnail' => 'mimes:jpeg,png,jpg,webp',
            // 'name' => 'required',
            // 'email' => 'required|email|max:255',
            // 'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:11',
            // 'nest' => 'required',
            // 'province' => 'required',
            // 'district' => 'required',
            // 'ward' => 'required',
            // 'time_open' => 'required|date_format:H:i',
            // 'time_close' => 'required|date_format:H:i|after:time_open',
        ];
    }

    protected function getRules()
    {
        $rules = [];
        switch ($this->route()->getName()) {
            case '':
                break;
            default:
                $rules = [];
                break;
        }
        return $rules;
    }
}