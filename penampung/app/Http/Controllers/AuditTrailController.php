<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use Dompdf\Dompdf;
use App\Models\Role;
use App\Models\AuditTrails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Arr;


require_once 'thirdparty/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

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
        $end = date('Y-m-d H:i:s', strtotime($request->tanggal_akhir  . '23:58:58'));
        $user = DB::table('t_log_user')->join('m_users', 't_log_user.kd_user', 'm_users.kd_user')->whereBetween('t_log_user.created_date', [$start, $end])->where('t_log_user.is_delete', 'N')->select('t_log_user.*', 'm_users.nm_user', 'm_users.branch_name', 'm_users.npp_user')->orderBy('t_log_user.created_date', 'asc')->get();

        $start = date('d-m-Y', strtotime($request->tanggal_awal));
        $end = date('d-m-Y', strtotime($request->tanggal_akhir));

        if ($request->export == 'excel') {
            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // ✅ Tambahkan kop surat (gambar PNG)
            $drawing = new Drawing();
            $drawing->setName('Kop ');
            $drawing->setDescription('Kop Jamkrindo');
            $drawing->setPath(asset('assets/img/kop-surat.png')); // Path ke file PNG kamu
            $drawing->setHeight(100); // Sesuaikan tinggi
            $drawing->setCoordinates('C1'); // Mulai dari sel A1
            $drawing->setWorksheet($sheet);

            // ✅ Mulai isi data setelah kop (misalnya dari baris 6)
            $sheet->setCellValue('A8', 'Tanggal / waktu');
            $sheet->setCellValue('B8', 'Keterangan');
            $sheet->setCellValue('C8', 'User');
            $sheet->setCellValue('D8', 'Cabang');
            $sheet->setCellValue('E8', 'Browser');
            $sheet->setCellValue('F8', 'Ip Address');
            $sheet->setCellValue('G8', 'Device');

            // style
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0070C0'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];

            $sheet->getStyle("A8:G8")->applyFromArray($headerStyle);
            $highestColumn = $sheet->getHighestColumn();
            foreach (range('A', $highestColumn) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            // Misal kamu punya data $user
            $row = 9;
            foreach ($user as $u) {
                $sheet->setCellValue("A{$row}", $u->created_date);
                $sheet->setCellValue("B{$row}", $u->keterangan);
                $sheet->setCellValue("C{$row}", $u->nm_user);
                $sheet->setCellValue("D{$row}", $u->branch_name);
                $sheet->setCellValue("E{$row}", $u->browser);
                $sheet->setCellValue("F{$row}", $u->ip_address);
                $sheet->setCellValue("G{$row}", $u->device);
                $row++;
            }
            $lastRow = $row - 1;
            $sheet->getStyle("A9:G{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);
            $writer = new Xlsx($spreadsheet);

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, 'Laporan Audit Trails Log Login.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            // $sheet->setCellValue('A4','Laporan Audit Trail');
            // $sheet->setCellValue('A5', 'Tanggal '. $start . 's/d' .$end);
            // $sheet->setCellValue('')
            // header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            // header("Content-type: application/x-msexcel; charset=utf-8");
            // header("Content-Disposition: attachment; filename=Laporan Audit Trail Login.xls");
            // header("Expires: 0");
            // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            // header("Cache-Control: private", false);
            return view('audit-trail.export-log-login-excel', compact('user', 'start', 'end'));
        } else {

            return  view('audit-trail.export-log-login-pdf', compact('user', 'start', 'end'));
            // $html = view('audit-trail.export-log-login-pdf', compact('user', 'start', 'end'))->render();
            // $dompdf = new Dompdf();
            // $dompdf->loadHtml($html);

            // // (Optional) Setup the paper size and orientation
            // $dompdf->setPaper('A4', 'landscape');

            // // Render the HTML as PDF
            // $dompdf->render();

            // // Output the generated PDF to Browser
            // $dompdf->stream('Laporan Audit Trail Login.pdf', array('Attachment' => false));
        }
    }

    public function ExportLogAktivitas(Request $request)
    {
        $start = date('Y-m-d H:i:s', strtotime($request->tanggal_awal . '00:00:00'));
        $end = date('Y-m-d H:i:s', strtotime($request->tanggal_akhir  . '23:58:58'));

        $audit = AuditTrails::with('user')->where('is_delete', 'N')->whereBetween('created_date', [$start, $end])->orderBy('created_date', 'asc')->get();
        $start = date('d-m-Y', strtotime($request->tanggal_awal));
        $end = date('d-m-Y', strtotime($request->tanggal_akhir));
        if ($request->export == 'excel') {
            // $before =[];
            // $after= [];
            $audit = $audit->map(function ($item) {

                // Decode JSON
                $jsonArrayBefore = json_decode($item->before, true);
                $jsonArrayAfter = json_decode($item->after, true);

                // Pastikan hasil decode adalah array, jika tidak, set kosong
                $jsonArrayBefore = is_array($jsonArrayBefore) ? $jsonArrayBefore : [];
                $jsonArrayAfter = is_array($jsonArrayAfter) ? $jsonArrayAfter : [];

                // Filter sebelum hanya yang ada di after
                $beforeFiltered = array_intersect_key($jsonArrayBefore, $jsonArrayAfter);

                // Ambil hanya value dari JSON, dan filter null
                $item->before = array_filter(array_values($beforeFiltered), fn($val) => !is_null($val));
                $item->after = array_filter(array_values($jsonArrayAfter), fn($val) => !is_null($val));

                return $item;
            });


            $spreadsheet = new Spreadsheet();
            $sheet = $spreadsheet->getActiveSheet();

            // ✅ Tambahkan kop surat (gambar PNG)
            $drawing = new Drawing();
            $drawing->setName('Kop ');
            $drawing->setDescription('Kop Jamkrindo');
            $drawing->setPath(asset('assets/img/kop-surat.png')); // Path ke file PNG kamu
            $drawing->setHeight(100); // Sesuaikan tinggi
            $drawing->setCoordinates('C1'); // Mulai dari sel A1
            $drawing->setWorksheet($sheet);

            // ✅ Mulai isi data setelah kop (misalnya dari baris 6)
            $sheet->setCellValue('A8', 'Tanggal / waktu');
            $sheet->setCellValue('B8', 'Before');
            $sheet->setCellValue('C8', 'After');
            $sheet->setCellValue('D8', 'User');
            $sheet->setCellValue('E8', 'Cabang');
            $sheet->setCellValue('F8', 'Browser');
            $sheet->setCellValue('G8', 'Device');

            // style
            $headerStyle = [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                    'size' => 12,
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '0070C0'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ];

            $sheet->getStyle("A8:G8")->applyFromArray($headerStyle);
            $highestColumn = $sheet->getHighestColumn();
            foreach (range('D', $highestColumn) as $col) {
                $sheet->getColumnDimension($col)->setAutoSize(true);
            }
            // Misal kamu punya data $user
            $row = 9;

            foreach ($audit as $u) {
                $before = is_array($u->before) ? implode(', ', Arr::flatten($u->before)) : $u->before;
                $after = is_array($u->after) ? implode(', ', Arr::flatten($u->after)) : $u->after;

                $sheet->setCellValue("A{$row}", $u->created_date);
                $sheet->setCellValue("B{$row}", $before);
                $sheet->setCellValue("C{$row}", $after);
                $sheet->setCellValue("D{$row}", $u->user->nm_user ?? '-');
                $sheet->setCellValue("E{$row}", $u->user->branch_name ?? '-');
                $sheet->setCellValue("F{$row}", $u->browser);
                $sheet->setCellValue("G{$row}", $u->device);
                $row++;
            }
            $lastRow = $row - 1;
            $sheet->getStyle("A9:G{$lastRow}")->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color' => ['rgb' => '000000'],
                    ],
                ],
            ]);
            $writer = new Xlsx($spreadsheet);

            return response()->streamDownload(function () use ($writer) {
                $writer->save('php://output');
            }, 'Laporan Audit Trails Log Aktivitas.xlsx', [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
            // $sheet->setCellValue('A4','Laporan Audit Trail');
            // $sheet->setCellValue('A5', 'Tanggal '. $start . 's/d' .$end);
            // $sheet->setCellValue('')
            // header("Content-Type: application/vnd.ms-excel; charset=utf-8");
            // header("Content-type: application/x-msexcel; charset=utf-8");
            // header("Content-Disposition: attachment; filename=Laporan Audit Trail Aktivitas.xls");
            // header("Expires: 0");
            // header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            // header("Cache-Control: private", false);
            return view('audit-trail.export-log-aktivitas-excel', compact('audit', 'start', 'end'));
        } else {
            $audit = $audit->map(function ($item) {

                // Decode JSON
                $jsonArrayBefore = json_decode($item->before, true);
                $jsonArrayAfter = json_decode($item->after, true);

                // Pastikan hasil decode adalah array, jika tidak, set kosong
                $jsonArrayBefore = is_array($jsonArrayBefore) ? $jsonArrayBefore : [];
                $jsonArrayAfter = is_array($jsonArrayAfter) ? $jsonArrayAfter : [];

                // Filter sebelum hanya yang ada di after
                $beforeFiltered = array_intersect_key($jsonArrayBefore, $jsonArrayAfter);

                // Ambil hanya value dari JSON, dan filter null
                $item->before = array_filter(array_values($beforeFiltered), fn($val) => !is_null($val));
                $item->after = array_filter(array_values($jsonArrayAfter), fn($val) => !is_null($val));

                return $item;
            });


            return view('audit-trail.export-log-aktivitas-pdf', compact('audit', 'start', 'end'));
        }
    }
}
