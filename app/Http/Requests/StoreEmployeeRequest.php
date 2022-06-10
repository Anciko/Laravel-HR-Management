<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            "employeeid" => "required|unique:users,employee_id",
            "name" => "required",
            "email" => "required|email|unique:users,email",
            "phone" => "required|min:9|max:11|unique:users,phone",
            "nrc" => "required|unique:users,nrc_number|min:7",
            "department" => "required",
            "birthday" => "required",
            "gender" => "required",
            "address" => "required",
            "dateOfJoin" => "required",
            "pincode" => "required|unique:users,pin_code|digits:6",
            "present" => "required"
        ];
    }
}
