<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReportRequest extends FormRequest
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
            'reports_name' => 'required',
            'price' => 'required',
            'date' => 'required',
            'image' => 'required',
            'notes' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'reports_name.required' => 'Input nama setoran tidak boleh kosong',
            'price.required' => 'Input jumlah setoran tidak boleh kosong',
            'date.required' => 'Input tanggal tidak boleh kosong',
            'image.required' => 'Bukti bayar tidak boleh kosong',
        ];
    }
}
