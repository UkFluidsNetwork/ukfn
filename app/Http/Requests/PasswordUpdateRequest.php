<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class PasswordUpdateRequest extends Request
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
            'password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return
        [
            'new_password.confirmed' => 'New passwords does not match!'
        ];
    }
}
