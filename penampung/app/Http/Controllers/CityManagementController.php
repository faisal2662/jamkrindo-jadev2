<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Province;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CityManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 9)->first();
        if($role->can_access == 'N'){
            return redirect()->route('dashboard');
         }
        $provinces = Province::where('is_delete', 'N')->get();
        return view('city-management.index', compact('provinces', 'role'));
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


    public function getDataKotaAll()
    {
        $cities = City::where('is_delete', 'N')->get();

        return response()->json($cities);
    }

    public function getData()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 9)->first();
        $cities = City::with('Provinsi')->where('is_delete', 'N')->orderBy('created_date','desc')->get();

        // return response()->json($cities);
        $no = 1;
        foreach ($cities as $act) {

            $act->no = $no++;
            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $act->action =   "
                <button class='btn btn-sm fw-bold' onclick='cityEdit(\"" . $act->kd_kota . "\")' > <i
                                                    class='bi bi-pencil-square'></i></button>
                                                     <button class='btn btn-sm fw-bold' onclick='cityDelete(\"" . $act->kd_kota . "\" )'><i
                                                    class='bi bi-trash' ></i></button>
                                                    ";
            } else if ($role->can_update == 'Y') {
                $act->action =   "
                <button class='btn btn-sm fw-bold' onclick='cityEdit(\"" . $act->kd_kota . "\")' > <i
                                                    class='bi bi-pencil-square'></i></button>
                                                    ";
            } else if ($role->can_create == 'Y') {
                $act->action =   "<button class='btn btn-sm fw-bold' onclick='cityDelete(\"" . $act->kd_kota . "\" )'><i class='bi bi-trash' ></i></button>";
            } else {
                $act->action =   "-";
            }
        }
        return datatables::of($cities)->escapecolumns([])->make(true);
    }



    public function getDataKota($id)
    {
        $cities = City::where('kd_provinsi', $id)->where('is_delete', 'N')->get();

        return response()->json($cities);
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
            $city = new City;

            $city->kd_provinsi = $request->kd_provinsi;
            $city->tipe = $request->tipe;
            $city->nm_kota = $request->nm_kota;
            $city->postal_code = $request->postal_code;
            $city->created_by = Auth::user()->nm_user;
            $city->save();

            unset($city['kd_kota']);
            if($city['kd_provinsi']){
                $city['kd_provinsi'] = DB::table('m_provinsi')->where('is_delete', 'N')->where('kd_provinsi', $city->kd_provinsi)->first()->nm_provinsi;
            }
            $this->logAuditTrail('create', $city, null, $city->toArray());

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

        $city = City::with('Provinsi')->where('kd_kota', $id)->first();
        return response()->json($city);
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
            $city = City::where('kd_kota', $id)->first();
            $dataLama = $city;

            $dataRequest =  $request->except(['_token']);

            if (isset($dataRequest['kd_provinsi'])) {
                $dataRequest['kd_provinsi'] = DB::table('m_provinsi')->where('kd_provinsi', $dataRequest['kd_provinsi'])->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($dataLama['kd_provinsi'])) {
                $dataLama['kd_provinsi'] = DB::table('m_provinsi')->where('kd_provinsi', $dataLama['kd_provinsi'])->where('is_delete', 'N')->first()->nm_provinsi;
            }

            $dataOld = json_decode(json_encode($dataLama), true);
            $dataNew = json_decode(json_encode($dataRequest), true);
            $baru =  array_diff_assoc($dataNew, $dataOld); // Nilai di $dataNew yang tidak ada di $dataOld
            $lama =  array_diff_assoc($dataOld, $dataNew); // Nilai di $dataOld yang tidak ada di $dataNew

            $city->kd_provinsi = $request->kd_provinsi;
            $city->tipe = $request->tipe;
            $city->nm_kota = $request->nm_kota;
            $city->postal_code = $request->postal_code;
            $city->updated_by = Auth::user()->nm_user;
            $city->update();

            $this->logAuditTrail('update', $city, $lama, $baru);


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
        $date = Carbon::now();
        try {
            $city = City::where('kd_kota', $id)->first();
            $dataLama = $city;
            $city->deleted_by = Auth::user()->nm_user;
            $city->deleted_date = $date;
            $city->is_delete = "Y";
            $city->update();

            unset($dataLama['is_delete']);

            if (isset($dataLama->kd_provinsi)) {
                $dataLama->kd_provinsi = DB::table('m_provinsi')->where('kd_provinsi', $dataLama->kd_provinsi)->where('is_delete', 'N')->first()->nm_provinsi;
            }

            $this->logAuditTrail('delete', $city, $dataLama, null);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
