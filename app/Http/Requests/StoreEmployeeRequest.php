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
            "employeeid" => "required",
            "name" => "required",
            "email" => "required|email",
            "phone" => "required|min:9|max:11",
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
