<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
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
            "name" => "required|max:40|alpha:ascii",
            "email" => "required|email|unique:users,email|max:40",
            "phone" => "required|unique:users,phone|digits:11|starts_with:01",
            "password" => "required|confirmed|min:6", // password_confirmation
        ];
    }
}
