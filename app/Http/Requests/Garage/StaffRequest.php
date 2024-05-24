<?php

namespace App\Http\Requests\Garage;

use App\Http\Requests\BaseRequest;

class StaffRequest extends BaseRequest
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
            'id_garage' => 'required',
            'image' => 'mimes:jpeg,png,jpg,webp|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:staffs|max:255',
            'password' => 'required|confirmed|min:8|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'gender' => 'required',
        ];
    }

    protected function putRules()
    {
        return [
            'image' => 'mimes:jpeg,png,jpg,webp|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:staffs|max:255',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'gender' => 'required',
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