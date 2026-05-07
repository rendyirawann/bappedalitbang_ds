<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVisimisiRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        // Set ke true agar request bisa diproses
        return true;
    }

    /**
     * SANITASI DATA SEBELUM DIVALIDASI
     * Ini menggantikan HtmlPurifier::process() dari Yii2
     */
    protected function prepareForValidation(): void
    {
        // Fungsi clean() berasal dari package mews/purifier
        // Kita cek dulu apakah request memiliki input teks tersebut sebelum dibersihkan
        $this->merge([
            'visiTeks' => $this->has('visiTeks') ? clean($this->visiTeks) : null,
            'misiTeks' => $this->has('misiTeks') ? clean($this->misiTeks) : null,
        ]);
    }

    /**
     * Aturan validasi setelah data disanitasi.
     */
    public function rules(): array
    {
        return [
            // Kolom sesuai dengan database Yii2 Anda
            'visiJudul' => ['nullable', 'string'],
            'visiTeks'  => ['nullable', 'string'],
            'misiJudul' => ['nullable', 'string'],
            'misiTeks'  => ['nullable', 'string'],
        ];
    }
}
