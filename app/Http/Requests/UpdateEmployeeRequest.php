<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
        $id = $this->route('employee');
        return [
            "employeeid" => "required|unique:users,employee_id," . $id,
            "name" => "required",
            "email" => "required|email|unique:users,email,$id",
            "phone" => "required|min:9|max:11|unique:users,phone, $id",
            "nrc" => "required",
            "department" => "required",
            "birthday" => "required",
            "gender" => "required",
            "address" => "required",
            "dateOfJoin" => "required",
            "present" => "required"
        ];
    }
}
