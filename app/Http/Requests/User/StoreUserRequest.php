<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class StoreUserRequest extends ApiRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required | string',
            'email' => 'required | email | string | unique:users,email',
            'password' => 'required | string | min:8'
        ];
    }
}
