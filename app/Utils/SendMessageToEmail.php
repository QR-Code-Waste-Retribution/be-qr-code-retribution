<?php

namespace App\Utils;
use Illuminate\Support\Facades\Mail;

class SendMessageToEmail
{
    protected static $data = [
        'message' => '',
        'subject' => '',
        'data' => [],
    ];

    public static function sendToUser($view, $email, $data)
    {
        Mail::send($view, [
            'message' => $data['message'],
            'to' => $email,
            'data' => $data['data']
        ], function ($message) use ($email, $data) {
            $message->to($email)->subject($data['subject']);
        });
    }
}
