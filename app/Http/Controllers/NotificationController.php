<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public function saveToken(Request $request, $id)
    {
        try {
            $validator = Validator::make($request->all(), [
                'token' => 'required',
            ], [
                'required' => ':attribute tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Input harus valid', 422);
            }

            $user = User::find($id);

            $user->device_token = $request->token;
            $user->save();

            return $this->successResponse([], 'Successfully to save token', 201);
        } catch (\Throwable $th) {
            return $this->errorResponse([], 'Something went error', 500);
        }
    }

    public function sendNotification(Request $request)
    {
        $firebaseToken = User::whereNotNull('device_token')->pluck('device_token')->all();

        $SERVER_API_KEY = env('FCM_SERVER_KEY');

        $data = [
            "registration_ids" => $firebaseToken,
            "notification" => [
                "title" => $request->title,
                "body" => $request->body,
            ]
        ];
        $dataString = json_encode($data);

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

        return back()->with('success', 'Notification send successfully.');
    }
}
