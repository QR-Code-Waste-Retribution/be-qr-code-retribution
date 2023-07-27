<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\UserResource;
use App\Models\Invoice;
use App\Models\User;
use App\Models\UserCategories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public $invoice;
    public function __construct()
    {
        $this->invoice = new Invoice();
    }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }


    public function getTotalAmountUnpaidAndPaidInvoice()
    {
        try {
            $invoice = $this->invoice->totalAmountUnpaidAndPaidInvoiceMonthly(1);
            return $this->successResponse($invoice, "Successfully to get total amount invoice category");
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $invoice_user = $this->invoice->getAllInvoiceById($id);
            $invoice_resource = InvoiceResource::collection($invoice_user);
            $invoice = $this->invoice->formatUserAllInvoice($invoice_resource);
            $response = [
                'invoice' => $invoice,
                'user' => null,
            ];
            return $this->successResponse($response, "Successfully to get invoice category");
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }

    public function getAllUserForInvoicePaidAndUnpaid($pemungut_id)
    {
        try {
            $users = $this->invoice->allUserForInvoicePaidAndUnpaid($pemungut_id);
            return $this->successResponse($users, "Successfully to get invoice category");
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getInvoiceOfUserByUUID(Request $request, $uuid)
    {
        try {
            $validator = Validator::make($request->all(), [
                "sub_district_id" => "required",
                "pemungut_id" => "required",
            ], [
                'required' => 'The :attribute is required.',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Missing id of sub district id', 422);
            }

            $user = User::where('uuid', $uuid)->with('role')->first();

            if (!$user) {
                return $this->errorResponse($validator->errors(), 'Kode tidak valid', 404);
            }
            
            $pemungut = User::where('id', $request->pemungut_id)->first();
            
            if ($user->district_id != $pemungut->district_id) {
                return $this->errorResponse([], 'Masyarakat ini tidak ada terdaftar di kabupaten anda', 401);
            }
            
            // $users_categories = UserCategories::where('user_id', $user->id)
            // ->where('pemungut_id', $pemungut->id)->first();
            
            // if (!$users_categories) {
            //     return $this->errorResponse($validator->errors(), 'Masyarakat tidak terdaftar sebagai wajib retribusi anda', 404);
            // }

            $sub_district_id = $request->sub_district_id;
            $invoice_user = $this->invoice->getInvoiceById($uuid, $sub_district_id);
            $invoice_resource = InvoiceResource::collection($invoice_user);
            $result = $this->invoice->formatUserInvoice($invoice_resource);


            $response = [
                'invoice' => $result,
                'user' =>  new UserResource($user),
            ];

            return $this->successResponse($response, "Successfully to get invoice category");
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
