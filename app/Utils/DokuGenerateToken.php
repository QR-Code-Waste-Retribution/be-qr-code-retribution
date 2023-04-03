<?php

namespace App\Utils;

use Illuminate\Support\Facades\Http;

class DokuGenerateToken
{

    public static function generateToken()
    {
        $clientId = env("DOKU_CLIENT_ID");
        $requestId = '93626957-8ebe-4e0e-9778-3a1a623ea18b';
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        $requestDate =  $dateTimeFinal;
        $targetPath = "/checkout/v1/payment"; 
        $secretKey = env("DOKU_SECRET_KEY");

        $requestBody = [
            "order" => [
                "amount" => 80000,
                "invoice_number" => "INV-2137823",
                "currency" => "IDR",
                "callback_url" => "http://doku.com/",
                "callback_url_cancel" => "https://doku.com",
                "language" => "EN",
                "auto_redirect" => true,
                "disable_retry_payment" => true,
                "line_items" => [
                    [
                        "id" => "001",
                        "name" => "Fresh flowers",
                        "quantity" => 1,
                        "price" => 40000,
                        "sku" => "FF01",
                        "category" => "gift-and-flowers",
                        "url" => "http://doku.com/",
                        "image_url" => "http://doku.com/",
                        "type" => "ABC"
                    ],
                    [
                        "id" => "002",
                        "name" => "T-shirt",
                        "quantity" => 1,
                        "price" => 40000,
                        "sku" => "T01",
                        "category" => "clothing",
                        "url" => "http://doku.com/",
                        "image_url" => "http://doku.com/",
                        "type" => "ABC"
                    ]
                ]
            ],
            "payment" => [
                "payment_due_date" => 60,
                "payment_method_types" => [
                    "VIRTUAL_ACCOUNT_BCA",
                    "VIRTUAL_ACCOUNT_BANK_MANDIRI",
                    "VIRTUAL_ACCOUNT_BANK_SYARIAH_MANDIRI",
                    "VIRTUAL_ACCOUNT_DOKU",
                    "VIRTUAL_ACCOUNT_BRI",
                    "VIRTUAL_ACCOUNT_BNI",
                    "VIRTUAL_ACCOUNT_BANK_PERMATA",
                    "VIRTUAL_ACCOUNT_BANK_CIMB",
                    "VIRTUAL_ACCOUNT_BANK_DANAMON",
                    "ONLINE_TO_OFFLINE_ALFA",
                    "CREDIT_CARD",
                    "DIRECT_DEBIT_BRI",
                    "EMONEY_SHOPEEPAY",
                    "EMONEY_OVO",
                    "QRIS",
                    "PEER_TO_PEER_AKULAKU",
                    "PEER_TO_PEER_KREDIVO",
                    "PEER_TO_PEER_INDODANA"
                ]
            ],
            "customer" => [
                "id" => "JC-01",
                "name" => "Zolanda",
                "last_name" => "Anggraeni",
                "phone" => "628121212121",
                "email" => "zolanda@example.com",
                "address" => "taman setiabudi",
                "postcode" => "120129",
                "state" => "Jakarta",
                "city" => "Jakarta Selatan",
                "country" => "ID"
            ],
            "shipping_address" => [
                "first_name" => "Zolanda",
                "last_name" => "Anggraeni",
                "address" => "Jalan Teknologi Indonesia No. 25",
                "city" => "Jakarta",
                "postal_code" => "12960",
                "phone" => "081513114262",
                "country_code" => "IDN"
            ],
            "billing_address" => [
                "first_name" => "Zolanda",
                "last_name" => "Anggraeni",
                "address" => "Jalan Teknologi Indonesia No. 25",
                "city" => "Jakarta",
                "postal_code" => "12960",
                "phone" => "081513114262",
                "country_code" => "IDN"
            ],
            "additional_info" => [
                "allow_tenor" => [
                    0,
                    3,
                    6,
                    12
                ],
                "close_redirect" => "www.doku.com",
                "doku_wallet_notify_url" => "https://dw-notify.free.beeceptor.com"
            ]
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
