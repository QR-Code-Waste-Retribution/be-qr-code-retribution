<?php

namespace App\Http\Controllers\Invoice;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;


class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search ?? '';

        $invoices = User::selectRaw("id,name,nik,phoneNumber,address")
            ->with(['invoices.users_categories'])
            ->with(['invoices.category' => function ($query) {
                $query->selectRaw("id,name,price,status,type")
                    ->where('status', 1);
            }])
            ->whereHas('invoices', function ($query) {
                $query
                    ->where('status', 0)
                    ->whereHas('category', function ($categoryQuery) {
                        $categoryQuery->where('status', 1);
                    });
            })
            ->where('district_id', auth()->user()->district_id)
            ->where('role_id', 1)
            ->where('verification_status', 1)
            ->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            });

        $invoices = $invoices->paginate(10);

        return view('pages.invoice.index', compact('invoices'));
    }
}
