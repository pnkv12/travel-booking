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
            'username' => 'required|unique:users|min:6|max:12',
            'password' => 'required|min:6',
            'fullname' => 'required',
            'email'    => 'required',
            'phone'    => 'required|digits:10'
        ];
    }

    /**
     * customize msg error
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => 'Username is required',
            'username.minlength' => 'Must be 6-12 characters',
            'username.maxlength' => 'Must be 6-12 characters',
            'username.unique' => 'This username has already been taken',
            'password.required' => 'Password is required',
            'password.minlength' => 'Must be at least 6 characters',
            'fullname.required' => 'Full name is required',
            'email.required' => 'Email is required',
            'phone.required' => 'Phone is required',
            'phone.digits' => 'Must be 10 digits'
        ];
    }
}