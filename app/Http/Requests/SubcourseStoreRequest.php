<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubcourseStoreRequest extends FormRequest
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
            'name' => 'required',
            'lesson_file_path' => 'nullable|file|mimes:pdf|max:10240', // PDF files, max 10MB
        ];
        if(request()->isMethod('post')) {
            return [
                'name' => 'required',
                'lesson_file_path' => 'nullable|file|mimes:pdf|max:10240', // PDF files, max 10MB
            ];
        } else {
            return [
                'name' => 'required',
                'lesson_file_path' => 'nullable|file|mimes:pdf|max:10240', // PDF files, max 10MB
            ];
        }
    }

    public function messages()
    {
        if(request()->isMethod('post')) {
            return [
                'name.required' => 'Name is required!',
                'lesson_file_path.required' => 'Lesson_File_Path is required!',
            ];
        } else {
            return [
                'name.required' => 'Name is required!',
                'lesson_file_path.required' => 'Lesson_File_Path is required!',
            ];   
        }
    }
}
