<?php

return [
    "BASE_URL" => [
        "sandbox" => "https://api-sandbox.doku.com",
        "production" => "https://api.doku.com",
    ],
    "PAYMENTS" => [
        "CHECKOUT" => [
            "QRIS" => [
                "payment.url" => "/checkout/v1/payment",
            ],
        ],
        "VIRTUAL_ACCOUNT" => [
            "BRI_VA" => [
                'payment.url' => '/bri-virtual-account/v2/payment-code',
                'bank_name' => [
                    'full_name' => 'Bank Rakyat Indonesia',
                    'short_name' => 'BRI',
                ],
                'va_type' => 'BRI_VA',
            ],
            "BNI_VA" => [
                'payment.url' => '/bni-virtual-account/v2/payment-code'
            ],
        ],
    ],
];
