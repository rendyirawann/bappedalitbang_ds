<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreStrukturRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // UBAH JADI TRUE agar request diizinkan lewat
        return true;
    }

    /**
     * SANITASI DATA SEBELUM DIVALIDASI
     * Pengganti 'filter' => 'strip_tags' Yii2
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('namaFile')) {
            $this->merge([
                'namaFile' => strip_tags($this->namaFile)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            // Validasi namaFile setelah dibersihkan dari tag HTML
            'namaFile' => ['required', 'string'],

            // Validasi untuk file upload struktur (maks 10MB, hanya gambar tertentu)
            'file_doc' => [
                'nullable',
                'file',
                'mimes:jpg,jpeg,png,heic',
                'max:10240', // 10 MB
            ],
        ];
    }

    /**
     * Kustomisasi pesan error (Opsional, mirip dengan Yii2)
     */
    public function messages(): array
    {
        return [
            'file_doc.max' => 'Ukuran file tidak boleh lebih dari 10MB.',
            'file_doc.mimes' => 'Hanya file dengan format jpg, jpeg, png, heic yang diizinkan.',
        ];
    }
}
