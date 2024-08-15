<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKeputusanRequest extends FormRequest
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
            'kategori_id'=> 'required|exists:kategori_penilaians,id',
            'staff'=> 'required|array',
            'staff.*.alasan' => 'required|string',
            // 'alasan'=> 'required',
            'tgl_putusan'=> 'required|date',
            // 'jenis_putusan'=> 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'kategori_id.required'=> 'Maaf Kategori Dari Penilaian tidak tersedia',
            'staff.required'=> 'Maaf data Staff/karyawan Hilang Hubungi Admin',
            'staff.array'=> 'Maaf data Staff/karyawan Hilang Hubungi Admin',
            'staff.*.alasan.required' => 'Alasan Pemberian Punishment/Reward Kosong Harap Di Isi',
        ];
    }
}
