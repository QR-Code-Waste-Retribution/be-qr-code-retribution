<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Http\Resources\UserResource;
use App\Models\Invoice;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public $invoice;
    public function __construct() {
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
        //
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
            return $this->successResponse($invoice, "Successfully to get invoice category");
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
            ], [
                'required' => 'The :attribute is required.',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Missing id of sub district id', 422);
            }

            $sub_district_id = $request->sub_district_id;
            $invoice_user = $this->invoice->getInvoiceById($uuid, $sub_district_id);
            $invoice_resource = InvoiceResource::collection($invoice_user);
            $result = $this->invoice->formatUserInvoice($invoice_resource);

            $user = User::where('uuid', $uuid)->with('role')->first();

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
