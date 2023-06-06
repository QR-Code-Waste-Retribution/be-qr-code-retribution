<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentNotification;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class DokuController extends Controller
{
    public function notifications(Request $request)
    {
        try {
            $notificationHeader = getallheaders();
            $notificationBody = file_get_contents('php://input');
            $notificationPath = '/api/payments/notifications'; // Adjust according to your notification path
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

                $decodedBody = json_decode($notificationBody, true);

                $transaction = Transaction::where("invoice_number", $decodedBody['order']['invoice_number'])->with(['user:id,name,uuid'])->first();

                if ($transaction) {
                    $response = Http::post(env('WEBSOCKET_URL') . env('WEBSOCKET_PORT') . '/send-message/va', ['uuid' => $transaction->user->uuid, 'name' => $transaction->user->name]);
                    $httpCode = $response->status();

                    if ($httpCode == 200) {

                        $transaction->invoice()->update(['status' => '1']);
                        $transaction->status = 1;
                        $transaction->save();

                        PaymentNotification::create([
                            'masyarakat_transaction_id' => $transaction->id,
                            'acquirer' => $decodedBody['acquirer']['id'],
                            'channel' => $decodedBody['channel']['id'],
                            'status' => $decodedBody['transaction']['status'],
                            'amount' => $decodedBody['order']['amount'],
                            'original_request_id' => $decodedBody['virtual_account_info']['virtual_account_number'],
                            'date' => $decodedBody['transaction']['date'],
                        ]);
                    }

                    // return response('Websocket Not Working', 500)->header('Content-Type', 'text/plain');
                } else {
                    return response('Not Found', 404)->header('Content-Type', 'text/plain');
                }
                return response('OK', 200)->header('Content-Type', 'text/plain');
            } else {
                // TODO: Response with 400 errors for Invalid Signature
                return response('Invalid Signature', 400)->header('Content-Type', 'text/plain');
            }
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }
}
