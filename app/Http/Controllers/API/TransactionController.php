<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\TransactionResource;
use App\Http\Resources\TransactionWithInvoiceResource;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Throwable;

class TransactionController extends Controller
{

    public $transaction;

    public function __construct()
    {
        $this->transaction = new Transaction();
        $this->middleware('uuid')->only('storeNonCash');
    }

    public function store(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "invoices_id" => 'required',
                "total_amount" =>  'required',
                "masyarakat_id" =>  'required',
                "pemungut_id" =>  'nullable',
                "category_id" =>  'nullable',
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

    public function storeAddtionalRetribution(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "total_amount" =>  'required',
                "pemungut_id" =>  'nullable',
                "category_id" =>  'nullable',
                "sub_district_id" =>  'required',
                "type" => 'required',
                "method" => 'nullable',
            ], [
                'required' => 'Input :attribute tidak boleh kosong',
            ]);


            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
            }

            $transaction = $this->transaction->storeTransactionAdditionalCash($request->all());

            return $this->successResponse($transaction, "Pembayaran retribusi tambahan berhasil!!", 203);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something Went error', 500);
        }
    }


    public function storeNonCash(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "line_items" => 'required',
                "total_amount" =>  'required',
                "masyarakat_id" =>  'required',
                "pemungut_id" =>  'nullable',
                "category_id" =>  'nullable',
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

            return $this->successResponse($transactions, 'Successfully to get transactions data');
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


    public function updateNonCashStatusAfterPayment(Request $request, $transaction_id)
    {
        try {
            $validator = Validator::make($request->all(), [
                "invoice_id" => 'required',
            ], [
                'required' => 'Input :attribute tidak boleh kosong',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors(), 'Input tidak boleh ada yang kosong', 422);
            }

            $transaction = $this->transaction->updateTransactionAndInvoiceNonCash($request->invoice_id, $transaction_id);
            return $this->successResponse($transaction, "Pembayaran anda telah berhasil terimakasih", 203);
        } catch (\Throwable $th) {
            return $this->errorResponse($th->getMessage(), 'Something Went error');
        }
    }

    public function show($id)
    {
        try {
            $transactions = $this->transaction->getTransactionWithInvoiceByMasyarakat($id);

            return $this->successResponse(
                new TransactionWithInvoiceResource($transactions),
                'Berhasil mengambil data transaksi'
            );
        } catch (Throwable $th) {
            return $this->errorResponse([], $th->getMessage(), $th->getCode());
        }
    }
}
