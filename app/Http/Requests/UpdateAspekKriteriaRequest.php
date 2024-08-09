<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAspekKriteriaRequest extends FormRequest
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
            'slug' => 'required|integer|exists:aspek_kriterias,id',
            'nama' => 'sometimes|required|unique:aspek_kriterias,nama,' . $this->slug,
            'persentase' => 'required|sometimes|numeric|between:10,100',
            'bobot' => 'required|sometimes|numeric',
            'sub_nama_aspek' => 'nullable|array',
            'sub_nama_aspek.*' => 'required|string|max:50',
            'sub_bobot_aspek' => 'nullable|array',
            'sub_bobot_aspek.*' => 'required|numeric|between:1,50',
        ];
    }

    public function messages(): array
    {
        return [
            'sub_nama_aspek' => 'Nama Sub aspek Penilaian harus Di Isi.',
            'sub_nama_aspek.*.string' => 'Bobot Sub aspek Penilaian harus berupa teks.',
            'sub_nama_aspek.*.required' => 'Bobot Sub aspek Penilaian harus berupa angka.',

            'sub_bobot_aspek.*.numeric' => 'Bobot Sub aspek Penilaian harus berupa angka.',
            'sub_bobot_aspek.*.required' => 'Bobot Sub aspek Penilaian harus berupa angka.',
        ];
    }
}
