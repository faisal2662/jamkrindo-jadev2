<?php

namespace App\Http\Controllers;

use DataTables;

use Carbon\Carbon;
use App\Models\Province;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProvinceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 10)->first();
        if($role->can_access == 'N'){
            return redirect()->route('dashboard');
         }
        return view('province-management.index', compact('role'));
    }

    public function getData()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 10)->first();
        $provincies = Province::where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        // return response()->json($provincies);
        $no = 1;


        foreach ($provincies as $act) {

            $act->no = $no++;
            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $act->action =   "  <tr>
                <button class='btn btn-sm fw-bold' onclick='provinceEdit(" . $act->kd_provinsi . ")' > <i
                                                    class='bi bi-pencil-square'></i></button>
                                                     <button class='btn btn-sm fw-bold' onclick='provinceDelete(" . $act->kd_provinsi . ")'><i
                                                    class='bi bi-trash' ></i></button>
                                                    </td>
                </td> </tr>";
            } else if ($role->can_update == 'Y') {
                $act->action =   "  <tr>
                <button class='btn btn-sm fw-bold' onclick='provinceEdit(" . $act->kd_provinsi . ")' > <i
                                                    class='bi bi-pencil-square'></i></button>
                                                    </td>
                </td> </tr>";
            } else if ($role->can_delete == 'Y') {
                $act->action =   "<tr><button class='btn btn-sm fw-bold' onclick='provinceDelete(" . $act->kd_provinsi . ")'><i
                                                    class='bi bi-trash' ></i></button>
                                                    </td>
                </td> </tr>";
            } else {
                $act->action =   "  <tr> - </td></tr>";
            }
        }
        return datatables::of($provincies)->escapecolumns([])->make(true);
    }

    public function getDataKota($id)
    {
        $provincies = Province::with('city')->where('kd_provinsi', $id)->where('is_delete', 'N')->first();
        return response()->json($provincies);
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

        try {
            $province = new Province;
            $province->nm_provinsi = $request->nama_provinsi;
            $province->created_by = Auth::user()->nm_user;
            $province->save();
            unset($province['kd_province']);
            // unset($province['url_location']);
            $this->logAuditTrail('create', $province, null, $province->toArray());

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
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

        $province = Province::where('kd_provinsi', $id)->first();
        return response()->json($province);
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
        try {
            $province = Province::where('kd_provinsi', $id)->first();
            $dataLama = $province;
            $dataRequest =  $request->except(['_token']);
            $dataOld = json_decode(json_encode($dataLama), true);
            $dataNew = json_decode(json_encode($dataRequest), true);
            $baru =  array_diff_assoc($dataNew, $dataOld); // Nilai di $dataNew yang tidak ada di $dataOld
            $lama =  array_diff_assoc($dataOld, $dataNew); // Nilai di $dataOld yang tidak ada di $dataNew
            $province->nm_provinsi = $request->nm_provinsi;
            $province->updated_by = Auth::user()->nm_user;
            $province->update();
            $this->logAuditTrail('update', $province, $lama, $baru);



            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
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
        $date = Carbon::now();
        try {
            $province = Province::where('kd_provinsi', $id)->first();
            $dataLama = $province;
            $province->is_delete = "Y";
            $province->deleted_by = Auth::user()->nm_user;
            $province->deleted_date = $date;
            $province->update();
            unset($dataLama['is_delete']);

            $this->logAuditTrail('delete', $province, $dataLama, null);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
