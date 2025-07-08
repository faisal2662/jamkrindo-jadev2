<?php

namespace App\Http\Controllers;

use DataTables;
use App\Models\City;
use App\Models\Province;
use App\Models\KanwilJamnation;
use App\Models\Regional;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RegionOfManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 8)->first();
        if($role->can_access == 'N'){
            return redirect()->route('dashboard');
         }
        $provinces = Province::where('is_delete', 'N')->get();
        $cities = City::where('is_delete', 'N')->get();
        return view('region-of-management.index', compact('provinces', 'cities', 'role'));
    }

    public function getData()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 8)->first();
        $regions = Regional::with(['Provinsi', 'Kota'])->where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        // $regions = KanwilJamnation::where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        // return response()->json($regions);
        $no = 1;


        foreach ($regions as $act) {

            $act->no = $no++;
            // if ($role->can_delete == 'Y' && $role->can_update == 'Y') {
            //     $act->action =   "  <tr><td> <a href='regions-of-management/lihat/" . $act->id_kanwil . "' class='btn'><i
            //                                         class='bi bi-search'></i></a>
            //   <a href='regions-of-management/edit/" . $act->id_kanwil . "' class='btn'><i
            //                                     class='bi bi-pencil-square'></i></a>
            //                                          <button class='btn btn-sm fw-bold' onclick='regionDelete(\"" . $act->id_kanwil . "\")'><i
            //                                         class='bi bi-trash' ></i></button>
            //                                         </td>
            //     </td> </tr>";
            // } else if ($role->can_update == 'Y') {
            //     $act->action =   "  <tr><td> <a href='regions-of-management/lihat/" . $act->id_kanwil . "' class='btn'><i
            //                                         class='bi bi-search'></i></a>
            //    <a href='regions-of-management/edit/" . $act->id_kanwil . "' class='btn'><i
            //                                     class='bi bi-pencil-square'></i></a>
            //                                         </td>
            //     </td> </tr>";
            // } else if ($role->can_delete == 'Y') {
            //     $act->action =   "  <tr><td> <a href='regions-of-management/lihat/" . $act->id_kanwil . "' class='btn'><i
            //                                         class='bi bi-search'></i></a>
            //                                          <button class='btn btn-sm fw-bold' onclick='regionDelete(\"" . $act->id_kanwil . "\")'><i
            //                                         class='bi bi-trash' ></i></button>
            //                                         </td>
            //     </td> </tr>";
            // } else {
                $act->action =   "  <tr><td> <a href='regions-of-management/lihat/" . $act->id_kanwil . "' class='btn'><i
                                                    class='bi bi-search'></i></a>
                </td> </tr>";
            // }
        }
        return datatables::of($regions)->escapecolumns([])->make(true);
    }

    public function getDataKota($id)
    {
        $cities = City::where('kd_provinsi', $id)->where('is_delete', 'N')->get();

        return response()->json($cities);
    }
 public function getDataWilayah($id)
    {
        $regions = Regional::where('kd_kota', $id)->where('is_delete', 'N')->get();

        return response()->json($regions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
         $provinces = Province::where('is_delete', 'N')->get();
        return view('region-of-management.create', compact('provinces'));
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
        // dd($request);
        $request->validate([
            'nama_wilayah' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required'
        ]);
        try {
            $region = new Regional;
            $region->nm_wilayah = $request->nama_wilayah;
            $region->kd_wilayah = $request->kode_wilayah;
            $region->kode_uker = $request->kode_uker;
            $region->desc_wilayah = $request->description;
            $region->latitude = $request->latitude;
            $region->longitude = $request->longitude;
            $region->alamat = $request->alamat;
            $region->telp = $request->telp;
            $region->fax = $request->fax;
            $region->email = $request->email;
            $region->kelas_uker = $request->kelas_uker;
            $region->kd_kota = $request->kota;
            $region->kd_provinsi = $request->provinsi;
            $region->created_by = Auth::user()->nm_user;
            $region->save();

            if (isset($region['kd_provinsi'])) {
                $region['kd_provinsi'] = DB::table('m_provinsi')->where('kd_provinsi', $region['kd_provinsi'])->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($region['kd_kota'])) {
                $region['kd_kota'] = DB::table('m_kota')->where('kd_kota', $region['kd_kota'])->where('is_delete', 'N')->first()->nm_kota;
            }
            unset($region['id_kanwil']);
            // unset($region['url_location']);
            $this->logAuditTrail('create', $region, null, $region->toArray());

            return redirect()->route('region-manager.index')->with('success', 'Simpan data berhasil');

            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return back()->with('error', 'Simpan data gagal :' . $e->getMessage());

            // return response()->json(['status' => $e->getMessage()], 500);
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
     $region = Regional::with(['Kota', 'Provinsi'])->where('id_kanwil', $id)->first();
    //  $region = KanwilJamnation::where('id_kanwil', $id)->first();

        return view('region-of-management.show', compact('region'));
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

       $provinces = Province::where('is_delete', 'N')->get();
        $region = Regional::with(['Kota', 'Provinsi'])->where('id_kanwil', $id)->where('is_delete', 'N')->first();
        // return response()->json($region);
        return view('region-of-management.edit', compact('region', 'provinces'));
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

         $request->validate([
            'nm_wilayah' => 'required',
            'alamat' => 'required',
            'kd_provinsi' => 'required',
            'kd_kota' => 'required'
        ]);
        try {
            $region = Regional::where('id_kanwil', $id)->first();
            $dataLama = $region;

            $dataRequest =  $request->except(['_token']);


            if (isset($dataRequest['kd_provinsi'])) {
                $dataRequest['kd_provinsi'] = DB::table('m_provinsi')->where('kd_provinsi', $dataRequest['kd_provinsi'])->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($dataRequest['kd_kota'])) {
                $dataRequest['kd_kota'] = DB::table('m_kota')->where('kd_kota', $dataRequest['kd_kota'])->where('is_delete', 'N')->first()->nm_kota;
            }

            if (isset($dataLama->kd_provinsi)) {
                $dataLama->kd_provinsi = DB::table('m_provinsi')->where('kd_provinsi', $dataLama->kd_provinsi)->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($dataLama->kd_kota)) {
                $dataLama->kd_kota = DB::table('m_kota')->where('kd_kota', $dataLama->kd_kota)->where('is_delete', 'N')->first()->nm_kota;
            }

            $dataOld = json_decode(json_encode($dataLama), true);
            $dataNew = json_decode(json_encode($dataRequest), true);
            $baru =  array_diff_assoc($dataNew, $dataOld); // Nilai di $dataNew yang tidak ada di $dataOld
            $lama =  array_diff_assoc($dataOld, $dataNew); // Nilai di $dataOld yang tidak ada di $dataNew
            $region->nm_wilayah = $request->nm_wilayah;
            $region->kd_wilayah = $request->kd_wilayah;
            $region->kode_uker = $request->kode_uker;
            $region->desc_wilayah = $request->desc_wilayah;
            $region->latitude = $request->latitude;
            $region->longitude = $request->longitude;
            $region->alamat = $request->alamat;
            $region->telp = $request->telp;
            $region->fax = $request->fax;
            $region->email = $request->email;
            $region->kelas_uker = $request->kelas_uker;
            $region->kd_kota = $request->kd_kota;
            $region->kd_provinsi = $request->kd_provinsi;
            $region->updated_by = Auth::user()->nm_user;
            $region->update();

            $this->logAuditTrail('update', $region, $lama, $baru);

            return redirect()->route('region-manager.index')->with('success', 'Ubah data berhasil');

            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return back()->with('error', 'Ubah data gagal :' . $e->getMessage());

            // return response()->json(['status' => $e->getMessage()], 500);
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
            $region = Regional::where('id_kanwil', '=', $id)->first();
            $dataLama = $region;
            $region->deleted_by = Auth::user()->nm_user;
            $region->deleted_date = $date;
            $region->is_delete = 'Y';
            $region->update();

            unset($dataLama['is_delete']);

            if (isset($dataLama->kd_provinsi)) {
                $dataLama->kd_provinsi = DB::table('m_provinsi')->where('kd_provinsi', $dataLama->kd_provinsi)->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($dataLama->kd_kota)) {
                $dataLama->kd_kota = DB::table('m_kota')->where('kd_kota', $dataLama->kd_kota)->where('is_delete', 'N')->first()->nm_kota;
            }
            $this->logAuditTrail('delete', $region, $dataLama, null);

            return response()->json(['status' => 'berhasil'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
