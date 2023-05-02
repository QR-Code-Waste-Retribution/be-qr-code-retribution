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
                'payment.url' => '/bri-virtual-account/v2/payment-code'
            ],
            "BNI_VA" => [
                'payment.url' => '/bni-virtual-account/v2/payment-code'
            ],
        ],
    ],
];
