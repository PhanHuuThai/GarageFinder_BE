<?php

namespace App\Http\Requests\Client;

use App\Http\Requests\BaseRequest;

class ProfileRequest extends BaseRequest
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
            'name' => 'required|max:500',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:1024',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'nest' => 'max:500',
        ];
    }

    protected function putRules()
    {
        return [
            'name' => 'required|max:500',
            'image' => 'image|mimes:jpeg,png,jpg,webp|max:1024',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:10',
            'nest' => 'max:500',
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