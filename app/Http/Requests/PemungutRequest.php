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
            'name' => 'required|string|regex:/^[^0-9]+$/',
            'username' => 'required|unique:users',
            'kecamatan' => 'required',
            'jenis_kelamin' => 'required',
            'nomor_telepon' => 'required|max:13',
            'alamat' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'required' => ':attribute tidak boleh kosong',
            'name.required' => 'nama tidak boleh kosong',
            'unique' => ':attribute sudah digunakan',
            'regex' => 'nama tidak boleh memiliki angka',
        ];
    }
}
