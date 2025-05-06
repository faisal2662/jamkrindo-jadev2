<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\AuditTrails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;


class AuditTrailController extends Controller
{
    //

    public function index()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 30)->first();
        if (auth()->user()->id_role != 1) {
            return redirect()->route('dashboard');
        }
        return view('audit-trail.index');
    }

    public function datatables()
    {
        $audit = AuditTrails::with('user')->where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        // $user = DB::table('t_log_user')->join('m_users', 't_log_user.kd_user', 'm_users.kd_user')->where('t_log_user.is_delete', 'N')->select('t_log_user.*' , 'm_users.nm_user', 'm_users.branch_name', 'm_users.npp_user')->orderBy('t_log_user.created_date', 'desc')->get();
        // $audit = $audit->merge($user);
        $no = 1;
        foreach ($audit as $data) {
            $data->no = $no++;

            $model =  explode("\\", $data->model);
            $data->master = isset($model[2]) ? $model[2] : '';
            $data->nama_user = $data->user->nm_user;
            $data->npp = $data->user->npp_user;
            $data->tanggal = Carbon::parse($data->created_date)->translatedFormat('l, d F Y');
            $data->act = '<button class="btn btn-sm fw-bold" onclick="detail(' . $data->id_audit_trails . ')" ><i class="bi bi-search"></i></button>';
        }
        return Datatables::of($audit)->escapecolumns([])->make(true);
    }

    public function show($id)
    {
        $audit = AuditTrails::with('user')->where('id_audit_trails', $id)->where('is_delete', 'N')->first();

        return response()->json(['data' => $audit], 200);
    }


    public function loginDatatable()
    {
        $user = DB::table('t_log_user')->join('m_users', 't_log_user.kd_user', 'm_users.kd_user')->where('t_log_user.is_delete', 'N')->select('t_log_user.*', 'm_users.nm_user', 'm_users.branch_name', 'm_users.npp_user')->orderBy('t_log_user.created_date', 'desc')->get();

        $no = 1;
        foreach ($user as $data) {
            $data->no = $no++;
            $data->tanggal = Carbon::parse($data->created_date)->translatedFormat('l, d F Y');
            // $data->jam = Carbon::parse($data->created_date)->translatedFormat('H:i:s');
            $data->act = '-';
            // $data->act = '<button class="btn btn-sm fw-bold" onclick="detail('. $data->id_log_user .')" ><i class="bi bi-search"></i></button>';
        }

        return Datatables::of($user)->escapecolumns([])->make(true);
    }


    public function ExportLogLogin(Request $request)
    {
        $start = date('Y-m-d H:i:s', strtotime($request->tanggal_awal . '00:00:00'));
        $end = date('Y-m-d H:i:s', strtotime($request->tanggal_akhir  . '00:00:00'));
        $user = DB::table('t_log_user')->join('m_users', 't_log_user.kd_user', 'm_users.kd_user')->whereBetween('t_log_user.created_date', [$start, $end])->where('t_log_user.is_delete', 'N')->select('t_log_user.*', 'm_users.nm_user', 'm_users.branch_name', 'm_users.npp_user')->orderBy('t_log_user.created_date', 'asc')->get();
        $start = date('d-m-Y', strtotime($request->tanggal_awal));
        $end = date('d-m-Y', strtotime($request->tanggal_akhir));

        // $spreadsheet = new Spreadsheet();
        // $sheet = $spreadsheet->getActiveSheet();
        if ($request->export == 'excel') {

            // $sheet->setCellValue('A4','Laporan Audit Trail');
            // $sheet->setCellValue('A5', 'Tanggal '. $start . 's/d' .$end);
            // $sheet->setCellValue('')
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-type: application/x-msexcel; charset=utf-8");
            header("Content-Disposition: attachment; filename=Laporan Audit Trail Login.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            return view('audit-trail.export-log-login-excel', compact('user', 'start', 'end'));
        } else {
            return view('audit-trail.export-log-login-pdf', compact('user', 'start', 'end'));
        }
    }

    public function ExportLogAktivitas(Request $request)
    {
        $start = date('Y-m-d H:i:s', strtotime($request->tanggal_awal . '00:00:00'));
        $end = date('Y-m-d H:i:s', strtotime($request->tanggal_akhir  . '00:00:00'));

         $audit = AuditTrails::with('user')->where('is_delete','N')->whereBetween('created_date', [$start, $end])->orderBy('created_date', 'asc')->get();
         $start = date('d-m-Y', strtotime($request->tanggal_awal));
         $end = date('d-m-Y', strtotime($request->tanggal_akhir));
        //  return $audit;
        if ($request->export == 'excel') {

            // $sheet->setCellValue('A4','Laporan Audit Trail');
            // $sheet->setCellValue('A5', 'Tanggal '. $start . 's/d' .$end);
            // $sheet->setCellValue('')
            header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            header("Content-type: application/x-msexcel; charset=utf-8");
            header("Content-Disposition: attachment; filename=Laporan Audit Trail Aktivitas.xls");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            return view('audit-trail.export-log-aktivitas-excel', compact('audit', 'start', 'end'));
        } else {
            return view('audit-trail.export-log-aktivitas-pdf', compact('audit', 'start', 'end'));
        }
    }
}
