<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\AuditTrails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuditTrailController extends Controller
{
    //

    public function index()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 30)->first();
        if(auth()->user()->id_role != 1){
            return redirect()->route('dashboard');
        }
        return view('audit-trail.index');
    }

    public function datatables ()
    {
        $audit = AuditTrails::with('user')->where('is_delete','N')->orderBy('created_date', 'desc')->get();
         $no = 1;
        foreach ($audit as $data) {
            $data->no = $no++;

            $model =  explode("\\", $data->model);
            $data->master = isset($model[2]) ? $model[2] : '';
            $data->nama_user = $data->user->nm_user;
            $data->npp = $data->user->npp_user;
            $data->tanggal = Carbon::parse($data->created_date)->translatedFormat('l, d F Y');
            $data->act = '<button class="btn btn-sm fw-bold" onclick="detail('. $data->id_audit_trails .')" ><i class="bi bi-search"></i></button>';
        }
        return Datatables::of($audit)->escapecolumns([])->make(true);

    }

    public function show($id)
    {
        $audit =AuditTrails::with('user')->where('id_audit_trails',$id)->where('is_delete','N')->first();

        return response()->json(['data' => $audit], 200);
    }
}
