<?php

namespace App\Utils;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;

class DokuGenerateToken
{
    /**
     * $method.
     *
     * @return [
     *      'payments' => @string,
     *      'type' => @string,  
     * ]
     */
    public $method;
    public $uuid;

    private $config;
    private $dokuMode;

    public function __construct($method, $uuid)
    {
        $this->method = $method;
        $this->uuid = $uuid;
        $this->dokuMode = env('DOKU_MODE');
        $this->config = config('doku');
    }

    public function generateToken($lineItems, $customer)
    {
        $clientId = env("DOKU_CLIENT_ID");
        $basePath = $this->config["BASE_URL"][$this->dokuMode];

        $requestId = $this->uuid;
        $requestDate =  $this->makeDate();

        // Payment Type [Checkout || Virtual Account]
        $methodPayments = $this->method['payments'];
        $typePayments = $this->method['type'];

        $targetPath = $this->config['PAYMENTS'][$methodPayments][$typePayments]['payment.url'];

        $secretKey = env("DOKU_SECRET_KEY");

        $requestBody = $this->createRequestBody($lineItems, $customer);

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
            'Request-Timestamp' => $requestDate,
            'Signature' => 'HMACSHA256=' . $signature,
        ])->post("$basePath$targetPath", $requestBody);

        $responseJson = json_decode($response->body());
        $httpCode = $response->status();

        return [
            'data' => $responseJson,
            'code' => $httpCode,
        ];
    }

    public function makeDate()
    {
        $dateTime = gmdate("Y-m-d H:i:s");
        $isoDateTime = date(DATE_ISO8601, strtotime($dateTime));
        $dateTimeFinal = substr($isoDateTime, 0, 19) . "Z";
        return $dateTimeFinal;
    }

    public function createRequestBody($lineItems, $customer)
    {

        $tax = [
            "name" => 'Pajak Pembayaran',
            "quantity" => 1,
            "price" => 3500,
        ];

        array_push($lineItems, $tax);

        if ($this->method['payments'] == 'VIRTUAL_ACCOUNT') {
            $amount = collect($lineItems)->sum('price');

            $requestBody = [
                "order" => array(
                    "invoice_number" => "INV-" . time(),
                    "amount" => $amount,
                ),
                "virtual_account_info" => array(
                    "billing_type" => "FIX_BILL",
                    "expired_time" => 60,
                    "reusable_status" => false,
                    'info1' => "Sistem Retribusi Pas",
                    "info2" => "ar Terima kasih sud",
                    "info3" => "ah membayar wajib re",
                    "info4" => "tribusi anda",
                ),
                "customer" => array(
                    "name" => "Anton Budiman",
                    "email" => "anton@example.com"
                )
            ];
            return $requestBody;
        }

        if ($this->method['payments'] == 'CHECKOUT') {
            return [
                "order" => [
                    "amount" => collect($lineItems)->sum('price'),
                    "invoice_number" => "INV-" . time(),
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
        }
    }
}
