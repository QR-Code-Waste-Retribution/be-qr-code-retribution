<?php

namespace App\Utils\Firebase;

class FirebaseCloudMessaging
{
    public static function send($data)
    {
        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $body = [
            "registration_ids" => $data['devices_token'],
            "notification" => [
                "title" => $data['message']['title'],
                "body" => $data['message']['body'],
            ]
        ];

        $dataString = json_encode($body);

        $headers = [
            'Authorization: key=' . $SERVER_API_KEY,
            'Content-Type: application/json',
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);

        $response = curl_exec($ch);
    
        return $response;
    }
}
