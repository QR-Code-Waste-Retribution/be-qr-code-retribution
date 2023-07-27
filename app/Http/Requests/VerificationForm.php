<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerificationForm extends FormRequest
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
            'selected_masyarakat_id' => "required"
        ];
    }


    public function messages(): array
    {
        return [
            'selected_masyarakat_id.required' => 'Pilih setidaknya 1 masyarakat yang akan diverifikasi',
        ];
    }
}
