<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PemungutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'username' => 'required',
            'kecamatan' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Input :attribute tidak boleh kosong'
        ];
    }
}
