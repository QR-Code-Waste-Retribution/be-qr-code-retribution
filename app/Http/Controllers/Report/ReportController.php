<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReportRequest;
use App\Http\Requests\UpdateReportRequest;
use App\Models\Report;
use App\Models\User;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public $report;

    public function __construct()
    {
        $this->report = new Report();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $report = $this->report->showAll();
        return view('pages.reports.index', compact('report'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $pemungut = User::where('district_id', auth()->user()->district_id)
            ->with('pemungut_transactions', function($query){
                $query->where('status', 1)
                    ->withSum('masyarakat_transactions', 'price');
            })
            ->where('role_id', 2)->get();
        return view('pages.reports.create', compact('pemungut'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreReportRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreReportRequest $request)
    {   
        $this->report->storeReport($request);
        
        return redirect()->route('reports.index')->with([
            'type' => 'success',
            'status' => 'Berhasil menambahkan laporan baru',
        ]);
    }
}
