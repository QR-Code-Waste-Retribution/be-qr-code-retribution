<?php

namespace App\Http\Resources\DokuFormat;

use Illuminate\Http\Resources\Json\JsonResource;

class DokuCheckoutResource extends JsonResource
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
            "message" => [
                "SUCCESS"
            ],
            "response" => [
                "order" => [
                    "amount" => null,
                    "invoice_number" => null,
                    "currency" => $this->checkout->currency,
                    "session_id" => $this->checkout->session_id,
                    "callback_url" => "https://doku.com/",
                    "line_items" => null,
                ],
                "payment" => [
                    "payment_method_types" => json_decode($this->checkout->payment_method_types, true),
                    "payment_due_date" => 60,
                    "token_id" => $this->checkout->payment_token_id,
                    "url" => $this->checkout->payment_url,
                    "expired_date" => $this->checkout->payment_expired_date,
                ],
                "customer" => [
                    "email" => null,
                    "phone" => null,
                    "name" => null,
                    "address" => null,
                    "country" => "ID"
                ],
                "additional_info" => [
                    "additional_info" => [
                        "doku_checkout" => true
                    ]
                ],
                "uuid" => $this->checkout->uuid,
                "headers" => [
                    "request_id" => null,
                    "signature" => null,
                    "date" => null,
                    "client_id" => null
                ]
            ],
            'merchant.transaction_id' => $this->id
        ];
    }
}
