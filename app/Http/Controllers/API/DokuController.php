<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DokuController extends Controller
{
    public function notifications(Request $request)
    {
        try {
            $notificationHeader = getallheaders();
            $notificationBody = file_get_contents('php://input');
            $notificationPath = 'http://35.213.170.85/api/payments/notifications'; // Adjust according to your notification path
            $secretKey = env("DOKU_SECRET_KEY"); // Adjust according to your secret key

            $digest = base64_encode(hash('sha256', $notificationBody, true));
            $rawSignature = "Client-Id:" . $notificationHeader['Client-Id'] . "\n"
                . "Request-Id:" . $notificationHeader['Request-Id'] . "\n"
                . "Request-Timestamp:" . $notificationHeader['Request-Timestamp'] . "\n"
                . "Request-Target:" . $notificationPath . "\n"
                . "Digest:" . $digest;

            $signature = base64_encode(hash_hmac('sha256', $rawSignature, $secretKey, true));
            $finalSignature = 'HMACSHA256=' . $signature;

            if ($finalSignature == $notificationHeader['Signature']) {
                // TODO: Process if Signature is Valid
                return response('OK', 200)->header('Content-Type', 'text/plain');

                // TODO: Do update the transaction status based on the `transaction.status`
            } else {
                // TODO: Response with 400 errors for Invalid Signature
                return response('Invalid Signature', 400)->header('Content-Type', 'text/plain');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }
}
