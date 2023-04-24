<?php

namespace App\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class DokuGenerateToken
{
    /**
     * Show the form for creating a new resource.
     *
     * @return [
     *      'payments' => @string,
     *      'type' => @string,  
     * ]
     */
    public $method;
    public $uuid;

    public function __construct($method, $uuid) {
        $this->method = $method;
        $this->uuid = $uuid;
    }

    public function generateToken($lineItems, $customer)
    {
        $clientId = env("DOKU_CLIENT_ID");
        $requestId = $this->uuid;
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $requestDate =  $dateTimeFinal;
        $targetPath = "/checkout/v1/payment"; 
        $secretKey = env("DOKU_SECRET_KEY");

        $tax = [
            "name" => 'Pajak Pembayaran',
            "quantity" => 1,
            "price" => 3500,
        ];

        array_push($lineItems, $tax);

        $requestBody = [
            "order" => [
                "amount" => collect($lineItems)->sum('price'),
                "invoice_number" => "INV-2137823",
                "currency" => "IDR",
                "callback_url" => "http://doku.com/",
                "callback_url_cancel" => "https://doku.com",
                "language" => "EN",
                "auto_redirect" => true,
                "disable_retry_payment" => true,
                "line_items" => $lineItems,
            ],
            "payment" => [
                "payment_due_date" => 60,
                "payment_method_types" => [
                    "QRIS",
                ]
            ],
            "customer" => $customer,
        ];

        $digestValue = base64_encode(hash('sha256', json_encode($requestBody), true));

        $componentSignature = "Client-Id:" . $clientId . "\n" .
            "Request-Id:" . $requestId . "\n" .
            "Request-Timestamp:" . $requestDate . "\n" .
            "Request-Target:" . $targetPath . "\n" .
            "Digest:" . $digestValue;

        

        $signature = base64_encode(hash_hmac('sha256', $componentSignature, $secretKey, true));

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Client-Id' => $clientId,
            'Request-Id' => $requestId,
            'Request-Timestamp' => $dateTimeFinal,
            'Signature' => 'HMACSHA256=' . $signature,
        ])->post('https://api-sandbox.doku.com/checkout/v1/payment', $requestBody);

        $responseJson = json_decode($response->body());
        $httpCode = $response->status();

        return [
            'data' => $responseJson,
            'code' => $httpCode,
        ];
    }
}
