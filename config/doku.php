<?php

return [
    'BASE_URL' => [
        'sandbox' => 'https://api-sandbox.doku.com',
        'production' => 'https://api.doku.com',
    ],
    'PAYMENTS' => [
        'CHECKOUT' => [
            'payment.url' => '/checkout/v1/payment',
            "currency" => "IDR",
            "callback_url" => "http://doku.com/",
            "callback_url_cancel" => "https://doku.com",
            "language" => "EN",
            "auto_redirect" => true,
            "disable_retry_payment" => true,
            "payment" => [
                "payment_due_date" => 60,
                "payment_method_types" => [
                    "QRIS",
                ]
            ],
        ],
        'DIRECT_API' => [],
    ],
];
