<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateKriteriaPenilaianRequest extends FormRequest
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
            'slug'=> 'required|exists:kriteria_penilaians,id',
            'aspek_id'=> 'required|exists:aspek_kriterias,id',
            'nama'=> 'required|string',
            'bobot'=> 'nullable|numeric',
            'factory'=> 'required',
            'nilai_target'=> 'required|numeric',
            'sub_nama_kriteria' => 'nullable|array',
            'sub_nama_kriteria.*' => 'required|string|max:50',
            'sub_bobot_kriteria' => 'nullable|array',
            'sub_bobot_kriteria.*' => 'required|numeric|between:1,5',
        ];
    }

    public function messages(): array
    {
        return [
            'sub_nama_kriteria' => 'Nama Sub kriteria Penilaian harus Di Isi.',
            'sub_nama_kriteria.*.string' => 'Bobot Sub kriteria Penilaian harus berupa teks.',
            'sub_nama_kriteria.*.required' => 'Bobot Sub kriteria Penilaian harus berupa angka.',

            'sub_bobot_kriteria.*.numeric' => 'Bobot Sub kriteria Penilaian harus berupa angka.',
            'sub_bobot_kriteria.*.required' => 'Bobot Sub kriteria Penilaian harus berupa angka.',
        ];
    }
}
