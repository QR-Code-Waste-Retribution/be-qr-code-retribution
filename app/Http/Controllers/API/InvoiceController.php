<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
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
    public function show()
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getInvoiceOfUser(Request $request, $uuid)
    {
        $validator = Validator::make($request->all(), [
            "sub_district_id" => "required",
        ], [
            'required' => 'The :attribute is required.',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(), 'Missing id of sub district id', 422);
        }

        
        $sub_district_id = $request->sub_district_id;
        
        $invoice_user = Invoice::where('uuid_user', $uuid)
            ->where('category_id', function ($query) use ($sub_district_id) {
                $query->select("category_id")
                    ->from('users_categories')
                    ->where('users_categories.sub_district_id', $sub_district_id)
                    ->where('users_categories.user_id', DB::raw('invoice.user_id'));
            })
            ->get();

        return $this->successResponse(InvoiceResource::collection($invoice_user), "Successfully to get invoice category");
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
