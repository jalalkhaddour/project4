<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'username'  =>  'required|unique:users,username',
            'password' =>  'required|min:6',
            'fname' =>  'required|String',
            'lname' =>  'required|String',
            'Role'  =>  'required|String',
            'IsActive'  =>  'required|boolean',
        ];
    }
    public function messages()
    {
        return [
            'username.required'  =>  'يجب عليك ادخال اسم المستخدم ',
            'username.unique'  =>  ' اسم المستخدم موجود مسبقاً في قاعدة البيانات بإمكانك تضمين أرقام ضمن اسم المستخدم مثال somene7 ',
            'password.required' =>  'يجب عليك ادخال كلمة مرور ',
            'fname.required' => 'يجب عليك ادخال الاسم الأول  ',
            'lname.required' =>  'يجب عليك ادخال  النسبة ',
            'IsActive.required' =>  'يجب عليك تحديد أن حساب الموظف فعال أو لا ',
            'Role.required'  =>  'يجب عليك اختيار دور الموظف ',
                       'password.min' =>  'كلمة المرور قصيرة جداً',
        ];
    }
}
