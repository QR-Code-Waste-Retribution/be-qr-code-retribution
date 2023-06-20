<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\SubDistrict;
use Illuminate\Http\Request;

class SubDistrictController extends Controller
{
    public $sub_district;
    
    public function __construct() {
        $this->sub_district = new SubDistrict();
    }

    public function index(Request $request)
    {
        try {
            $district_id = $request->district_id ?? 1;
            $sub_districts = $this->sub_district->getSubDistrictByDistrictUserAPI($district_id);
            return $this->successResponse($sub_districts, 'Berhasil mengambil semua data', 200);
        } catch (\Throwable $err) {
            return $this->errorResponse('Something Went Error', $err->getMessage(), 401);
        }
    }
}
