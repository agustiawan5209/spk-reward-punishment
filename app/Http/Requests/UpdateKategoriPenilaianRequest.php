<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKategoriPenilaianRequest extends FormRequest
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
            'slug'=> 'required|exists:kategori_penilaians,id',
            'nama'=> 'required|string|max:50',
            'tanggal'=> 'required|date|unique:kategori_penilaians,tanggal,'. $this->slug,
            'keterangan'=> 'required|string|max:1000',
            'status'=> 'required|in:aktif,tidak aktif',
            'data_karyawan'=> 'required|array',
            'data_karyawan.*.nama'=> 'required|string',
            'data_karyawan.*.jabatan'=> 'required|string',
            'data_karyawan.*.status'=> 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'data_karyawan.required' => 'Data Karyawan Harus Di Isi.',
            'data_karyawan.array' => 'Data Karyawan Harus Di Isi.',
            'data_karyawan.*.nama.required' => 'Nama Karyawan Harus Tersedia.',
            'data_karyawan.*.jabatan.required' => 'Jabatan Karyawan Harus Tersedia.',
            'data_karyawan.*.status.required' => 'Terjadi Masalah di Checkbox Karyawan .',
        ];

    }
}
