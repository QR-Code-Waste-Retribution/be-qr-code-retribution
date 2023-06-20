<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerificationForm;
use App\Models\SubDistrict;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MasyarakatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public $user;

    public function __construct()
    {
        $this->user = new User();
    }

    public function show($id)
    {
        $user = $this->user->show($id);
        return view('pages.user.masyarakat.detail', compact('user'));
    }

    public function index(Request $request)
    {
        $search = $request->search ?? '';
        $sub_district = $request->sub_district ?? null;

        $masyarakat = User::where('role_id', 1)
            ->where('district_id', 1)
            ->where(function (Builder $query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phoneNumber', 'like', '%' . $search . '%');
            });
        // 

        if ($sub_district && $sub_district != 'all') {
            $masyarakat = $masyarakat->where('sub_district_id', $sub_district);
        }

        $masyarakat = $masyarakat->with('sub_district')
            ->paginate(10);

        $sub_districts = SubDistrict::where('district_id', 1)->get();

        return view('pages.user.masyarakat.index', compact('masyarakat', 'sub_districts'));
    }

    public function verificationDetail($pemungut_id)
    {
        $pemungut = $this->user->allMasyarakatByPemungut($pemungut_id);

        
        return view('pages.user.verification.detail', compact('pemungut'));
    }
    
    public function verificationCreate()
    {
        $pemunguts = $this->user->allMasyarakatByPemungut();
        
        return view('pages.user.verification.index', compact('pemunguts'));
    }

    public function changeStatusVerificationUser(VerificationForm $request)
    {
        try {
            $input = $request->validated();

            $this->user->changeVerficationStatusSelectedMasyarakat($input['selected_masyarakat_id']);

            return redirect()->route('masyarakat.verification')->with([
                'type' => 'success',
                'status' => 'Berhasil mengubah status verifikasi masyarakat',
            ]);
        } catch (Exception $err) {
            return $this->errorResponse([], 'Something went wrong');
        }
    }

    public function changeStatusUser(Request $request)
    {
        try {
            $user = User::find($request->user_id);
            $user->status = $user->status == 1 ? 0 : 1;
            $user->save();

            return $this->successResponse($user, 'Berhasil mengubah status ' . $user->name);
        } catch (Exception $err) {
            return $this->errorResponse([], 'Something went wrong');
        }
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
