<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Invoice;
use App\Utils\Firebase\FirebaseCloudMessaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotificationController extends Controller
{
    public $invoice;

    public function __construct()
    {
        $this->invoice = new Invoice();
    }

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
        $validator = Validator::make($request->all(), [
            'title_notification' => 'required',
            'description_notification' => 'required',
        ], [
            'required' => ':attribute tidak boleh kosong',
        ]);
        
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error_modal', 'Something went error');
        }

        $firebaseToken = User::whereNotNull('device_token')
            ->where('role_id', 1)
            ->where('district_id', auth()->user()->district_id)
            ->pluck('device_token')->all();

        $this->invoice->generate();

        FirebaseCloudMessaging::send([
            'devices_token' => $firebaseToken,
            'message' => [
                'title' => $request->title_notification,
                'body' => $request->description_notification,
            ]
        ]);

        return redirect()->back()->with([
            'type' => 'success',
            'status' => 'Sukses mengirimkan notifikasi',
        ]);
    }
}
