<?php

namespace App\Http\Requests\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => 'required|min:3|max:128|unique:users',
            'email' => 'required|min:3|max:128|email|unique:users',
            'password' => 'required|min:6|max:64',
            'passwordConfirm' => 'same:password',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Le nom est requis.',
            'name.min' => 'Le nom doit contenir au minimum 3 caractères.',
            'name.max' => 'Le nom doit contenir au maximum 128 caractères.',
            'name.unique' => 'Le nom est déjà utilisé.',
            'email.email' => 'L\'adresse e-mail est invalide.',
            'email.required' => 'L\'adresse e-mail est requise.',
            'email.min' => 'L\'e-mail est doit contenir au minimum 3 caractères.',
            'email.max' => 'L\'e-mail est doit contenir au maximum 128 caractères.',
            'email.unique' => 'E-mail déjà utilisé.',
            'password.required' => 'Le mot de passe est requis.',
            'password.min' => 'Le mot de passe  doit contenir au minimum 6 caractères.',
            'password.max' => 'Le mot de passe  doit contenir au maximum 64 caractères.',
            'passwordConfirm.same' => 'Les deux mots de passe ne sont pas identiques.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Echec de validation.',
            'data'      => $validator->errors()
        ]));
    }
}
