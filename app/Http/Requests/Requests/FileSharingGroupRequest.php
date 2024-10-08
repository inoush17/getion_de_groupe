<?php

namespace App\Http\Requests\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileSharingGroupRequest extends FormRequest
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
            'file' => 'nullable|mimes:jpeg,png,mp4,jpg,pdf,doc,docx,xlsx|max:10048',
           
        ];
    }

    public function messages()
    {
        return [
            'file.mimes' => 'Le fichier doit être au format jpeg, png ou jpg',
            'file.max' => 'La taille du fichier doit être inférieure à 20MB',
        ];
    }
}
