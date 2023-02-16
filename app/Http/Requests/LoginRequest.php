<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
    public function LoginFormatter()
    {
        return [
            'username'  =>  $this->get('username'),
            'password' =>  $this->get('password')
        ];
    }
    public function rules()
    {
        return [
            'username'  =>  'required|exists:users,username',
            'password' =>  'required'
        ];
    }
    public function messages()
    {
        return [
            'username.required'  =>  'يجب عليك ادخال اسم المستخدم',
            'username.exists'  =>  ' اسم المستخدم غير موجود',
            'password.required' =>  'يجب عليك ادخال كلمة المرور'
        ];
    }
}
