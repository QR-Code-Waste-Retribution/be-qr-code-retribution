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
            'price' => ['required', function ($attribute, $value, $fail) {
                $value = (int)str_replace(array('.', ','), '', $value);
                if ($value <= 0) {
                    $fail('Input jumlah setoran tidak boleh kurang dari dan sama dengan Rp. 0');
                }
            }],
            'date' => 'required',
            'image' => 'required',
            'notes' => 'nullable',
            'pemungut_id' => 'required',
            'sts_no' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'reports_name.required' => 'Nama setoran tidak boleh kosong',
            'price.required' => 'Jumlah setoran tidak boleh kosong',
            'price.min' => 'Jumlah setoran tidak boleh kurang dari Rp. 0',
            'date.required' => 'Tanggal tidak boleh kosong',
            'image.required' => 'Bukti bayar tidak boleh kosong',
            'pemungut_id.required' => 'Pemungut tidak boleh kosong',
            'sts_no.required' => 'Nomor STS tidak boleh kosong',
        ];
    }
}
