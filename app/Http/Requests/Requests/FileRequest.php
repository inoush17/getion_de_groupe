<?php

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileRequest extends FormRequest
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
            'file' => 'required|min:940|max:10240|file',
        ];
    }

    public function messages(): array
    {
        return [
            'file.file' => 'Le fichier n\'est pas autorisé.',
            'file.required' => 'Le fichier est requis.',
            'file.min' => 'La taille minimum du fichier doit être 940.',
            'file.max' => 'La taille maximum du fichier doit être 10240.',
        ];
    }
}
