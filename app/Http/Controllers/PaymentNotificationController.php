<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentNotificationRequest;
use App\Http\Requests\UpdatePaymentNotificationRequest;
use App\Models\PaymentNotification;

class PaymentNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePaymentNotificationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePaymentNotificationRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PaymentNotification  $paymentNotification
     * @return \Illuminate\Http\Response
     */
    public function show(PaymentNotification $paymentNotification)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentNotification  $paymentNotification
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentNotification $paymentNotification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePaymentNotificationRequest  $request
     * @param  \App\Models\PaymentNotification  $paymentNotification
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePaymentNotificationRequest $request, PaymentNotification $paymentNotification)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PaymentNotification  $paymentNotification
     * @return \Illuminate\Http\Response
     */
    public function destroy(PaymentNotification $paymentNotification)
    {
        //
    }
}
