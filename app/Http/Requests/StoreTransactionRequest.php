<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
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
            "invoice_id" => 'required',
            "total_amount" =>  'required',
            "masyarakat_id" =>  'required',
            "pemungut_id" =>  'required',
            "category_id" =>  'required',
            "sub_district_id" =>  'required',
            "type" => 'required',
        ];
    }
}
