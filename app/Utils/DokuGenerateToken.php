<?php

namespace App\Utils;

use App\Models\DokuCheckout;
use App\Models\DokuDirectApi;
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

    private $total_amount;
    private $config;
    private $dokuMode;

    private $invoice_number;

    public function __construct($method, $uuid)
    {
        $this->method = $method;
        $this->uuid = $uuid;
        $this->dokuMode = env('DOKU_MODE');
        // die($this->dokuMode);
        $this->config = config('doku');
    }

    public function generateToken($lineItems, $customer, $total_amount)
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

        $requestBody = $this->createRequestBody($lineItems, $customer, $total_amount);

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

        $responseJson = json_decode($response->body(), true);
        $httpCode = $response->status();

        $responseJson['bank'] = $this->config['PAYMENTS'][$methodPayments][$typePayments];

        return [
            'data' => $responseJson,
            'transaction' => [
                'invoice_number' => $this->invoice_number,
                'total_amount' => $this->total_amount,
            ],
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

    public function createRequestBody($lineItems, $customer, $total_amount)
    {

        $tax = [
            "name" => 'Biaya Layanan',
            "quantity" => 1,
            "price" => 3500,
        ];

        array_push($lineItems, $tax);

        $this->total_amount = $total_amount + $tax['price'];
        $this->invoice_number = "INV-" . time();

        if ($this->method['payments'] == 'VIRTUAL_ACCOUNT') {

            return [
                "order" => array(
                    "invoice_number" => $this->invoice_number,
                    "amount" => $this->total_amount
                ),
                "virtual_account_info" => array(
                    "billing_type" => "FIX_BILL",
                    "expired_time" => 60,
                    "reusable_status" => false,
                    'info1' => "Sistem Retribusi Pas",
                    "info2" => "ar Terima kasih sud",
                    "info3" => "ah membayar wajib re",
                    "info4" => "tribusi anda"
                ),
                "customer" => $customer->only('name', 'email')
            ];
        }

        if ($this->method['payments'] == 'CHECKOUT') {
            return [
                "order" => [
                    "amount" => $this->total_amount,
                    "invoice_number" => $this->invoice_number,
                    "currency" => "IDR",
                    "callback_url" => "qr_code_app://",
                    "callback_url_cancel" => "qr_code_app://cancel",
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
