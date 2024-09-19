<?php

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OtpCodeRequest extends FormRequest
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
            'email' => 'required|min:3|max:128|email',
            'code' => 'required|min:4|max:6',
        ];
    }

    public function messages(): array
    {
        return [
            'email.email' => 'L\'adresse e-mail est invalide.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.min' => 'L\'e-mail doit contenir au minimum 3 caractères.',
            'email.max' => 'L\'e-mail doit contenir au maximum 128 caractères.',
            'code.required' => 'Le mot de passe est requis.',
            'code.min' => 'Le code doit contenir au minimum 4 caractères.',
            'code.max' => 'Le code doit contenir au maximum 6 caractères.',
        ];
    }
}
