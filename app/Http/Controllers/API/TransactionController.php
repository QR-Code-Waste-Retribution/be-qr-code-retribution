<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{

    public $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
        $this->middleware('uuid')->only('storeNonCash');
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
        try {
            $validator = Validator::make($request->all(), [
                "invoice_id" => 'required',
                "total_amount" =>  'required',
                "masyarakat_id" =>  'required',
                "pemungut_id" =>  'nullable',
                "category_id" =>  'required',
                "sub_district_id" =>  'required',
                "type" => 'required',
                "method" => 'nullable',
            ], [
                'required' => 'Input :attribute tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
            }

            $transaction = $this->transaction->storeTransactionInvoiceCash($request->all());
            return $this->successResponse($transaction, $transaction['message'], $transaction['code']);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something Went error');
        }
    }


    public function storeNonCash(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "invoice_id" => 'required',
                "total_amount" =>  'required',
                "masyarakat_id" =>  'required',
                "pemungut_id" =>  'nullable',
                "category_id" =>  'required',
                "sub_district_id" =>  'required',
                "type" => 'required',
                "method" => 'nullable',
            ], [
                'required' => 'Input :attribute tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
            }

            $transaction = $this->transaction->storeTransactionInvoiceNonCash($request->all());
            return $this->successResponse($transaction['transaction'], $transaction['message'], $transaction['code']);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something Went error');
        }
    }


    public function historyTransactionPemungut($id)
    {
        try {
            $transactions = Transaction::getHistoryTransactionOfPemungut($id);

            return $this->successResponse(TransactionResource::collection($transactions), 'Successfully to get transactions data');
        } catch (\Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), 500);
        }
    }

    public function getHistoryTransactionMasyarakat($id)
    {
        try {
            $transactions = Transaction::getHistoryTransactionOfMasyarakat($id);

            return $this->successResponse([
                'transaction' => TransactionResource::collection($transactions),
            ], 'Successfully to get transactions data');
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
        //
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
