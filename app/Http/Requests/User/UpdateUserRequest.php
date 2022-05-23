<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiRequest;

class UpdateUserRequest extends ApiRequest
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
            'id' => 'required | integer | exists:users,id',
            'name' => 'sometimes | string | max:50',
            'email' => 'sometimes | email | max:80 | unique:users,email',
            'password' => 'sometimes | string | min:8'
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['id' => $this->route('user')]);
    }
}
