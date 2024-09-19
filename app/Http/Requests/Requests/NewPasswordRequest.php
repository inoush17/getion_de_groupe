<?php

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|min:3|max:128|email|unique:users',
            'code' => 'required|min:4|max:6',
            'password' => 'required|min:6|max:64',
            'passwordConfirm' => 'same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe doit contenir au minimum 6 caractères.',
            'password.max' => 'Le mot de passe doit contenir au maximum 64 caractères.',
            'passwordConfirm.same' => 'Les deux mots de passe ne sont pas identiques.',
        ];
    }
}
