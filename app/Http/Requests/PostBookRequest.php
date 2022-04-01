<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'isbn' => ['required', 'numeric', 'regex:/^(\d{13})$/', 'unique:books'],
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'authors' => ['required', 'array'],
            'authors.*' => ['integer', 'exists:App\Author,id'],
        ];
    }
}
