<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreStaffRequest extends FormRequest
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
            'kode_pegawai' => 'required|string|max:10|unique:staff,kode_pegawai',
            'name' => 'required|string|max:255',
            'no_telpon' => 'required|string|max:255',
            'alamat' => 'required|string',
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'string'],
            'jabatan'=> 'required|in:Kepala Bagian,Kepala Sekretariat,Staff',
            'departement_id'=> 'required|exists:departements,id',
        ];
    }
}
