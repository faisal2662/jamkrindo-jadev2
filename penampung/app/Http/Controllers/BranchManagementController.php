<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Branch;
use App\Models\KancaJamnation;
use App\Models\Regional;
use App\Models\City;
use App\Models\Province;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DataTables;

class BranchManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //  
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 7)->first();
        if ($role->can_access == 'N') {
            return redirect()->route('dashboard');
        }
        $regional = Regional::where('is_delete', 'N')->get();
        $provinsi = Province::where('is_delete', 'N')->get();
        return view('branch-management.index', compact('regional', 'provinsi', 'role'));
    }

    public function getData()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 7)->first();
        $branchsKanca = KancaJamnation::leftJoin('m_kanwil_jamnation', 'm_kanca_jamnation.id_mst_kanwil', 'm_kanwil_jamnation.id_kanwil')->whereNull('m_kanca_jamnation.kup')->select('m_kanca_jamnation.*', 'm_kanwil_jamnation.nama_uker as nm_kanwil')->orderBy('m_kanca_jamnation.created_date', 'desc')->get();
        $branchsKup = KancaJamnation::leftJoin('m_kanca_jamnation as kanca', 'm_kanca_jamnation.id_mst_kanca', 'kanca.id_kanca')->whereNotNull('m_kanca_jamnation.kup')->select('m_kanca_jamnation.*', 'kanca.nm_cabang as nm_kanwil')->orderBy('m_kanca_jamnation.created_date', 'desc')->get();

        // $branchs = $branchsKanca->merge($branchsKup);
        $branchs = collect(); // buat koleksi kosong 

        $branchs = $branchs->concat($branchsKanca)->concat($branchsKup)->values();
        // return response()->json($branchs->count());
        // return response()->json($branchsKup->count());

        $no = 1;


        foreach ($branchs as $act) {


            $act->no = $no++;
            // $act->location_string = "<a href='" . $act->url_location . "' >Link Gmaps</a>";
            // if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
            //     $act->action =   " <a href='branchs-management/lihat/" . $act->id_cabang . "' class='btn'><i
            //                                         class='bi bi-search'></i></a>
            //    <a href='branchs-management/edit/" . $act->id_cabang . "' class='btn'><i class='bi bi-pencil-square'></i></a>
            //                                          <button class='btn btn-sm fw-bold' onclick='branchDelete(" . $act->id_cabang . " )'><i
            //                                         class='bi bi-trash' ></i></button>
            //                                         ";
            // } else if ($role->can_update == 'Y') {
            //     $act->action =   " <a href='branchs-management/lihat/" . $act->id_cabang . "' class='btn'><i
            //                                         class='bi bi-search'></i></a>
            //     <a href='branchs-management/edit/" . $act->id_cabang . "' class='btn'><i class='bi bi-pencil-square'></i></a>";
            // } else if ($role->can_delete == 'Y') {
            //     $act->action =   " <a href='branchs-management/lihat/" . $act->id_cabang . "' class='btn'><i
            //                                         class='bi bi-search'></i></a>
            //                                          <button class='btn btn-sm fw-bold' onclick='branchDelete(" . $act->id_cabang . " )'><i
            //                                         class='bi bi-trash' ></i></button>";
            // } else {
            $act->action =   " <a href='branchs-management/lihat/" . $act->id_cabang . "' class='btn'><i
                                                    class='bi bi-search'></i></a>";
            // }
        }
        return datatables::of($branchs)->escapecolumns([])->make(true);
    }

    public function getDataCabang($id)
    {
        $branch = Branch::where('kd_wilayah', $id)->where('is_delete', "N")->get();
        return response()->json($branch);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response 
     */
    public function create()
    {
        //
        $kota = City::where('is_delete', 'N')->get();
        $wilayah = Regional::where('is_delete', 'N')->get();
        $provinsi = Province::where('is_delete', 'N')->get();
        return view('branch-management.create', compact('kota', 'wilayah', 'provinsi'));
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
        try {
            $branch = new Branch;
            $branch->nm_cabang = $request->nm_cabang;
            $branch->kd_cabang = $request->kd_cabang;
            $branch->kd_wilayah = $request->wilayah;
            //$branch->kode_uker = $request->kode_uker;
            //$branch->kelas_uker = $request->kelas_uker;
            $branch->desc_cabang = $request->deskripsi;
            $branch->latitude_cabang = $request->latitude;
            $branch->longitude_cabang = $request->longitude;
            $branch->url_location = $request->url_location;
            $branch->kd_kota = $request->kota;
            $branch->kd_provinsi = $request->provinsi;
            $branch->alamat_cabang  = $request->alamat;
            $branch->telp_cabang = $request->telp;
            $branch->email = $request->email;
            $branch->fax = $request->fax;
            $branch->created_by = Auth::user()->nm_user;
            $branch->save();
            if (isset($branch['kd_wilayah'])) {
                $branch['kd_wilayah'] = DB::table('m_wilayah')->where('id_kanwil', $branch['kd_wilayah'])->where('is_delete', 'N')->first()->nm_wilayah;
            }
            if (isset($branch['kd_provinsi'])) {
                $branch['kd_provinsi'] = DB::table('m_provinsi')->where('kd_provinsi', $branch['kd_provinsi'])->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($branch['kd_kota'])) {
                $branch['kd_kota'] = DB::table('m_kota')->where('kd_kota', $branch['kd_kota'])->where('is_delete', 'N')->first()->nm_kota;
            }
            unset($branch['id_cabang']);
            unset($branch['url_location']);
            // unset($branch['url_location']);
            $this->logAuditTrail('create', $branch, null, $branch->toArray());

            return redirect()->route('branch-manager.index')->with('success', 'Simpan data berhasil');
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
        $cek = KancaJamnation::where('m_kanca_jamnation.id_cabang', $id)->first();
        if($cek->kup){
            $branch = KancaJamnation::where('m_kanca_jamnation.id_cabang', $id)->leftJoin('m_kanca_jamnation as kanca' , 'm_kanca_jamnation.id_mst_kanca', 'kanca.id_kanca')->select('m_kanca_jamnation.*', 'kanca.nm_cabang as nm_kanwil')->first();
            
        }else {
            $branch = KancaJamnation::where('m_kanca_jamnation.id_cabang', $id)->leftJoin('m_kanwil_jamnation', 'm_kanca_jamnation.id_mst_kanwil', 'm_kanwil_jamnation.id_kanwil')->select('m_kanca_jamnation.*', 'm_kanwil_jamnation.nama_uker as nm_kanwil')->first();

        }
        
        return view('branch-management.show', compact('branch'));
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

        $cabang = Branch::with(['Wilayah', 'Kota', 'Provinsi'])->where('id_cabang', $id)->first();
        $wilayah = Regional::where('is_delete', 'N')->get();
        $provinsi = Province::where('is_delete', 'N')->get();
        return view('branch-management.edit', compact('cabang', 'provinsi', 'wilayah'));
        // return response()->json($branch);
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
        // dd($request);
        try {
            $branch = Branch::where('id_cabang', $id)->first();
            $dataLama = $branch;

            $dataRequest =  $request->except(['_token']);

            if (isset($dataRequest['kd_wilayah'])) {
                $dataRequest['kd_wilayah'] = DB::table('m_wilayah')->where('id_kanwil', $dataRequest['kd_wilayah'])->where('is_delete', 'N')->first()->nm_wilayah;
            }
            if (isset($dataRequest['kd_provinsi'])) {
                $dataRequest['kd_provinsi'] = DB::table('m_provinsi')->where('kd_provinsi', $dataRequest['kd_provinsi'])->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($dataRequest['kd_kota'])) {
                $dataRequest['kd_kota'] = DB::table('m_kota')->where('kd_kota', $dataRequest['kd_kota'])->where('is_delete', 'N')->first()->nm_kota;
            }
            if (isset($dataLama->kd_wilayah)) {
                $dataLama->kd_wilayah = DB::table('m_wilayah')->where('id_kanwil', $dataLama->kd_wilayah)->where('is_delete', 'N')->first()->nm_wilayah;
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

            $branch->nm_cabang = $request->nm_cabang;
            $branch->kd_cabang = $request->kd_cabang;
            $branch->kd_wilayah = $request->kd_wilayah;
            //$branch->kode_uker = $request->kode_uker;
            //$branch->kelas_uker = $request->kelas_uker;
            $branch->desc_cabang = $request->desc_cabang;
            $branch->latitude_cabang = $request->latitude_cabang;
            $branch->longitude_cabang = $request->longitude_cabang;
            $branch->url_location = $request->url_location;
            $branch->kd_kota = $request->kd_kota;
            $branch->kd_provinsi = $request->kd_provinsi;
            $branch->alamat_cabang  = $request->alamat_cabang;
            $branch->telp_cabang = $request->telp_cabang;
            $branch->email = $request->email;
            $branch->fax = $request->fax;
            $branch->updated_by = Auth::user()->nm_user;
            $branch->update();

            $this->logAuditTrail('update', $branch, $lama, $baru);

            // return response()->json(['status' => 'success'], 200);
            return redirect()->route('branch-manager.index')->with('success', 'Ubah data berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Simpan data gagal :' . $e->getMessage());
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
            $branch = Branch::where('id_cabang', $id)->first();
            $dataLama =  $branch;
            $branch->deleted_by = Auth::user()->nm_user;
            $branch->deleted_date = $date;
            $branch->is_delete = 'Y';
            $branch->update();
            unset($dataLama['kode_uker']);
            unset($dataLama['kelas_uker']);
            unset($dataLama['url_location']);
            unset($dataLama['is_delete']);
            if (isset($dataLama->kd_wilayah)) {
                $dataLama->kd_wilayah = DB::table('m_wilayah')->where('id_kanwil', $dataLama->kd_wilayah)->where('is_delete', 'N')->first()->nm_wilayah;
            }
            if (isset($dataLama->kd_provinsi)) {
                $dataLama->kd_provinsi = DB::table('m_provinsi')->where('kd_provinsi', $dataLama->kd_provinsi)->where('is_delete', 'N')->first()->nm_provinsi;
            }
            if (isset($dataLama->kd_kota)) {
                $dataLama->kd_kota = DB::table('m_kota')->where('kd_kota', $dataLama->kd_kota)->where('is_delete', 'N')->first()->nm_kota;
            }
            $this->logAuditTrail('delete', $branch, $dataLama, null);


            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
