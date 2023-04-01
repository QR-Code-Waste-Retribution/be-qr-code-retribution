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
            $invoice_user_current_month = Invoice::select('invoice.*', 'users_categories.user_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
                ->join('users_categories', function ($join) use ($sub_district_id) {
                    $join->on('invoice.user_id', '=', 'users_categories.user_id')
                        ->where('users_categories.sub_district_id', '=', $sub_district_id);
                })
                ->join('sub_districts', function ($join) {
                    $join->on('users_categories.sub_district_id', '=', 'sub_districts.id');
                })
                ->where('invoice.uuid_user', '=', $uuid)
                ->where(DB::raw('MONTH(invoice.created_at)'), '=', DB::raw('MONTH(CURRENT_DATE())'))
                ->whereColumn('invoice.category_id', '=', 'users_categories.category_id')
                ->orderBy('invoice.created_at');
    
            $invoice_user_previous_month = Invoice::select('invoice.*', 'users_categories.user_id', 'users_categories.address', 'sub_districts.name as sub_district_name')
                ->join('users_categories', function ($join) use ($sub_district_id) {
                    $join->on('invoice.user_id', '=', 'users_categories.user_id')
                        ->where('users_categories.sub_district_id', '=', $sub_district_id);
                })
                ->join('sub_districts', function ($join) {
                    $join->on('users_categories.sub_district_id', '=', 'sub_districts.id');
                })
                ->where('invoice.uuid_user', '=', $uuid)
                ->where('invoice.status', '=', 0)
                ->where(DB::raw('MONTH(invoice.created_at)'), '<', DB::raw('MONTH(CURRENT_DATE())'))
                ->whereColumn('invoice.category_id', '=', 'users_categories.category_id')
                ->orderBy('invoice.created_at')
                ->union($invoice_user_current_month)
                ->get();
    
            $invoice_user = $invoice_user_previous_month;
    
            $invoice_resource = InvoiceResource::collection($invoice_user);
            $result = Invoice::formatUserInvoice($invoice_resource);
    
            return $this->successResponse($result, "Successfully to get invoice category");
     
        } catch (\Throwable $th) {
            //throw $th;
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
