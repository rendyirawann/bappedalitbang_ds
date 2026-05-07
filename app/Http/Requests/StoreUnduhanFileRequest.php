<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnduhanFileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    // Di dalam app/Http/Requests/StoreUnduhanFileRequest.php
    public function rules(): array
    {
        return [
            'refunduhan_id' => ['required', 'exists:unduhan,id'],

            // Aturan untuk UPLOAD BANYAK FILE (Max 5 file, Max 10MB per file)
            'file_docs' => ['nullable', 'array', 'max:5'],
            'file_docs.*' => [
                'file',
                'mimes:jpg,jpeg,png,heic,pdf,doc,docx,xls,xlsx,ppt,pptx', // Laravel otomatis mengecek MIME type dari ekstensi ini
                'max:10240', // 10 MB (dalam Kilobytes)
            ],
        ];
    }
}
