<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'profile_photo_path' => 'required|mimes:jpeg,jpg,png,svg,gif'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The display name is required!',
            'password' => 'The password is required!',
            'password.min' => 'Password must be at least 6 characters!',
            'profile_photo_path' => 'The image is required!'
        ];
    }

    public function attributes()
    {
        return [
            'email' => 'email address'
        ];
    }
}
