<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseRequest;

class OrderRequest extends BaseRequest
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
            'name' => 'required',
            'email' => 'required|email|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'car' => 'required',
            'service' => 'required',
            'time' => "required|date_format:H:i",
            'date' => "required|date|after_or_equal:today",
        ];
    }

    protected function putRules()
    {
        return [
            'name' => 'required|min:5|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:1024',
            'type' => 'required|min:3|max:10',
            'id_brand' => 'required',
            'license' => 'required|min:8|max:20'
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