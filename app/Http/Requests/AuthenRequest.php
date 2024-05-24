<?php

namespace App\Http\Requests;

use App\Http\Requests\BaseRequest;

class AuthenRequest extends BaseRequest
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
            'email' => 'required|email|max:255',
            'password' => 'required',
        ];
    }

    protected function putRules()
    {
        return [
            'email' => 'required|email',
            // 'username' => 'required',
            'password' => 'required',
            // 'id_provider' => 'required',
            // 'id_role' => 'required',
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