<?php

namespace App\Http\Resources\DokuFormat;

use Illuminate\Http\Resources\Json\JsonResource;

class DokuDirectApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "order" => [
                "invoice_number" => $this->directApi->invoice_number
            ],
            "virtual_account_info" => [
                "virtual_account_number" => $this->directApi->virtual_account_number,
                "how_to_pay_page" => $this->directApi->how_to_pay_page,
                "how_to_pay_api" => $this->directApi->how_to_pay_api,
                "created_date" => $this->directApi->created_date,
                "expired_date" => $this->directApi->expired_date,
                "created_date_utc" => $this->directApi->created_date_utc,
                "expired_date_utc" => $this->directApi->expired_date_utc
            ],
            "bank" => [
                "payment.url" => "/bri-virtual-account/v2/payment-code",
                "bank_name" => [
                    "full_name" => $this->directApi->bank_name,
                    "short_name" => $this->directApi->bank_name_short
                ],
                "va_type" => $this->directApi->invoice_number
            ],
            "merchant.transaction_id" => $this->id
        ];
    }
}
