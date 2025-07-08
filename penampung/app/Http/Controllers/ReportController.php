<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Role;
use App\Models\Percakapan;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use DB;

require_once 'thirdparty/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function customer()
    {
        // $getCustomer = 
        return view('report.customer');
    }

    public function customerDataTables(Request $request)
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 3)->first();

        $startDate = $request->startDate;
        $endDate = $request->endDate;

        if ($startDate && $endDate) {
            $customers = Customer::with(['Branch', 'Business'])->whereBetween('created_date', [$startDate, $endDate])->where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        } else {
            $customers = Customer::with(['Branch', 'Business'])->where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        }

        $no = 1;


        foreach ($customers as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;
            $btn = 'text-bg-success';

            if ($act->status_customer != 'Active') {
                $btn = 'text-bg-danger';
            }
            $act->no = $no++;
            $act->register = Carbon::parse($act->created_date)->format('d-m-Y H:i:s');
            $act->status_customer = "<td ><span class='badge " . $btn . "'> " . $act->status_customer . "</span></td>";
            $act->action =   "<a href='customers-management/lihat/" . $act->kd_customer . "' class='btn'><i class='bi bi-search'></i></a> ";
        }

        return datatables::of($customers)->escapecolumns([])->make(true);
    }

    public function printPdf(Request $request)
    {
        // if ($request->startDate && $request->endDate) {
        //     $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        // } else {
        //     $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        // }
        $start = $request->startDate;
        $end = $request->endDate;


        $customer = DB::table('m_customer')
            ->leftJoin('m_kota', 'm_customer.company_city', '=', 'm_kota.kd_kota')
            ->leftJoin('m_provinsi', 'm_customer.company_province', '=', 'm_provinsi.kd_provinsi')
            ->leftJoin('m_cabang', 'm_customer.kd_cabang', '=', 'm_cabang.kd_cabang')
            ->where('m_customer.is_delete', 'N')
            ->whereBetween('m_customer.created_date', [$start, $end])
            ->get();

        $idCustomer = [];
        foreach ($customer as $cs) {
            if (!in_array($cs->kd_customer, $idCustomer)) {
                $idCustomer[] = $cs->kd_customer;
            }
        }
        // $idCustomer = [1];

        $pesan = DB::table('t_percakapan')->leftJoin('t_pesan', 't_percakapan.id', 't_pesan.conversation_id')
            ->leftJoin('m_customer', 't_pesan.send_id', '=', 'm_customer.kd_customer')
            ->leftJoin('m_users', 't_pesan.send_id', '=', 'm_users.kd_user')
            ->select(
                't_pesan.*',
                't_percakapan.id',
                't_percakapan.kd_customer',
                'm_customer.nama_customer',
                'm_users.employee_name'
            )
            // ->where('')
            ->whereIn('t_percakapan.kd_customer', $idCustomer)
            ->get();
        // return $pesan;
        $arrPesan = [];
        $firstMessage = '';
        $lastMessage = '';
        $secondMessage = '';
        $hours = '';
        $minutes = '';
        $diffInSeconds = '';
        foreach ($pesan as $psn) {
            $arrPesan[$psn->kd_customer][] = $psn;
            $psn->firstMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '0')->orderBy('created_date', 'ASC')->first();
            $psn->secondMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '1')->orderBy('created_date', 'ASC')->first();
            $psn->lastMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->orderBy('created_date', 'DESC')->first();
            if (isset($psn->lastMessage)) {
                $diffInSeconds = strtotime($psn->lastMessage->created_date) - strtotime($psn->firstMessage->created_date);
                $psn->hours = floor($diffInSeconds / 3600);
                $psn->minutes = floor(($diffInSeconds % 3600) / 60);
            }
        }
        // return $arrPesan;

        foreach ($customer as $csd) {
            $csd->detail = isset($arrPesan[$csd->kd_customer]) ? $arrPesan[$csd->kd_customer] : [];
            $csd->firstMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->firstMessage : '';
            $csd->lastMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->lastMessage : '';
            $csd->secondMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->secondMessage : '';
            // if($firstMessage != ''){
            // }
            // $csd->lastMessage = isset($lastMessage[$csd->kd_customer]) ? $lastMessage[$csd->kd_customer] : '[]';
            // if($lastMessage != ''){
            // }
            if (isset($arrPesan[$csd->kd_customer][0])) {
                $csd->hours = $arrPesan[$csd->kd_customer][0]->hours;
                $csd->minutes = $arrPesan[$csd->kd_customer][0]->minutes;
            }
        }

        return view('report.customerPdf', compact('customer', 'start', 'end'));
    }

    public function printExcel(Request $request)
    {
        $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        $start = $request->startDate;
        $end = $request->endDate;
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // ✅ Tambahkan kop surat (gambar PNG)
        $drawing = new Drawing();
        $drawing->setName('Kop ');
        $drawing->setDescription('Kop Jamkrindo');
        $drawing->setPath(base_path('../assets/img/kop-surat.png')); // Path ke file PNG kamu
        // $drawing->setPath(asset('assets/img/kop-surat.png')); // Path ke file PNG kamu
        $drawing->setHeight(100); // Sesuaikan tinggi
        $drawing->setCoordinates('G1'); // Mulai dari sel A1
        $drawing->setWorksheet($sheet);

        // ✅ Mulai isi data setelah kop (misalnya dari baris 6)
        $sheet->mergeCells('A7:N7');
        $sheet->setCellValue('A7', 'Laporan Customer');
        $sheet->getStyle('A7')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->setCellValue('A9', 'No.');
        $sheet->setCellValue('B9', 'Nama User Jade');
        $sheet->setCellValue('C9', 'Unit Kerja');
        $sheet->setCellValue('D9', 'Username');
        $sheet->setCellValue('E9', 'Email');
        $sheet->setCellValue('F9', 'No. Telpon');
        $sheet->setCellValue('G9', 'Kode Rederral'); 
        $sheet->setCellValue('H9', 'Nama Perusahaan');
        $sheet->setCellValue('I9', 'Provinsi Perusahaan');
        $sheet->setCellValue('J9', 'Kota Perusahaan');
        $sheet->setCellValue('K9', 'Start Chat');
        $sheet->setCellValue('L9', 'End Chat');
        $sheet->setCellValue('M9', 'Duration chat');
        $sheet->setCellValue('N9', 'Created Date');


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

        $sheet->getStyle("A9:N9")->applyFromArray($headerStyle);
        $highestColumn = $sheet->getHighestColumn();
        foreach (range('D', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // Misal kamu punya data $user
        $row = 10;
        $no =1;

        foreach ($customer as $item) {
        $getConversation = DB::table('t_percakapan')->where('kd_customer', $item->kd_customer)->first();
                    $conversation = DB::table('t_percakapan')->where('kd_customer', $item->kd_customer)->get();
                    $hours = '';
                    $minutes = '';
                    if ($getConversation) {
                        $firstMessage = DB::table('t_pesan')
                            ->where('conversation_id', $getConversation->id)
                            ->where('status', '0')
                            ->orderBy('created_date', 'ASC')
                            ->first();
                        $secondMessage = DB::table('t_pesan')
                            ->where('conversation_id', $getConversation->id)
                            ->where('status', '1')
                            ->orderBy('created_date', 'ASC')
                            ->first();
                        $lastMessage = DB::table('t_pesan')
                            ->where('conversation_id', $getConversation->id)
                            ->orderBy('created_date', 'DESC')
                            ->first();
                        $startTime = new \DateTime($firstMessage->created_date);
                        $endTime = new \DateTime($lastMessage->created_date);
                        $diffInSeconds =
                            strtotime($lastMessage->created_date) - strtotime($firstMessage->created_date);
                        $hours = floor($diffInSeconds / 3600);
                        $minutes = floor(($diffInSeconds % 3600) / 60);
                    }
            

            $sheet->setCellValue("A{$row}", $no++);
            $sheet->setCellValue("B{$row}", $item->nama_customer);


            $sheet->setCellValue("C{$row}", $item->branch ? $item->branch->nm_cabang : '');

            $sheet->setCellValue("D{$row}", $item->userid_customer ?? '-');
            $sheet->setCellValue("E{$row}", $item->email_customer ?? '-');
            $sheet->setCellValue("F{$row}", $item->hp_customer);
            $sheet->setCellValue("G{$row}", $item->kd_referral_customer);
            $sheet->setCellValue("H{$row}", $item->company_name);
            $sheet->setCellValue("I{$row}", $item->province ? $item->province->nm_provinsi : '');
            $sheet->setCellValue("J{$row}", $item->city ? $item->city->nm_kota : '');
        if($getConversation){

            $sheet->setCellValue("K{$row}", $firstMessage->created_date);
            $sheet->setCellValue("L{$row}", $lastMessage->created_date);
            $sheet->setCellValue("M{$row}", $hours . ' Jam ' . $minutes . ' Menit');
        }else {

            $sheet->setCellValue("K{$row}", '');
            $sheet->setCellValue("L{$row}", '');
            $sheet->setCellValue("M{$row}", '');

        }
            $sheet->setCellValue("N{$row}", date('d-m-Y', strtotime($item->created_date)));
            $row++;
        }
        $lastRow = $row - 1;
        $sheet->getStyle("A10:N{$lastRow}")->applyFromArray([
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
        }, 'Laporan Customer.xlsx', [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
        
        return view('report.customerExcel', compact('customer', 'start', 'end'));
    }

    public function printPreview(Request $request)
    {
        // $report = Percakapan::with('message')->get();
        // return $report;
        // $customer = customer::with(['city', 'province', 'branch', 'Percakapan.Message'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        // $customer = customer::join('t_percakapan', 'm_customer.kd_customer', 't_percakapan.kd_customer')->join()
        $start = $request->startDate;
        $end = $request->endDate;
        // $customers = DB::table('m_customer')
        // // ->leftJoin('m_kota', 'm_customer.company_city', '=', 'm_kota.kd_kota')
        // // ->leftJoin('m_provinsi', 'm_customer.company_province', '=', 'm_provinsi.kd_provinsi')
        // // ->leftJoin('m_cabang', 'm_customer.kd_cabang', '=', 'm_cabang.kd_cabang')
        // ->leftJoin('t_percakapan', 'm_customer.kd_customer', '=', 't_percakapan.kd_customer')
        // ->leftJoin('t_pesan', 't_percakapan.id', '=', 't_pesan.conversation_id')
        // ->select(
        //     'm_customer.nama_customer',
        //     'm_customer.email_customer',
        //     'm_customer.hp_customer',
        //     'm_customer.userid_customer',
        //     // 'm_customer.nama_customer',
        //     // 'cities.name as city_name',
        //     // 'provinces.name as province_name',
        //     // 'branches.name as branch_name',
        //     't_percakapan.id',
        //     't_pesan.message'
        // )
        // ->whereBetween('m_customer.created_date', [$start, $end])
        // ->where('m_customer.is_delete', 'N')
        // ->groupBy('m_customer.nama_customer','m_customer.hp_customer', 'm_customer.email_customer', 'm_customer.userid_customer', 't_percakapan.id', 't_pesan.message')
        // ->get();

        $customer = DB::table('m_customer')
            ->leftJoin('m_kota', 'm_customer.company_city', '=', 'm_kota.kd_kota')
            ->leftJoin('m_provinsi', 'm_customer.company_province', '=', 'm_provinsi.kd_provinsi')
            ->leftJoin('m_cabang', 'm_customer.kd_cabang', '=', 'm_cabang.kd_cabang')
            ->where('m_customer.is_delete', 'N')
            ->whereBetween('m_customer.created_date', [$start, $end])
            ->get();

        $idCustomer = [];
        foreach ($customer as $cs) {
            if (!in_array($cs->kd_customer, $idCustomer)) {
                $idCustomer[] = $cs->kd_customer;
            }
        }
        // $idCustomer = [1];

        $pesan = DB::table('t_percakapan')->leftJoin('t_pesan', 't_percakapan.id', 't_pesan.conversation_id')
            ->leftJoin('m_customer', 't_pesan.send_id', '=', 'm_customer.kd_customer')
            ->leftJoin('m_users', 't_pesan.send_id', '=', 'm_users.kd_user')
            ->select(
                't_pesan.*',
                't_percakapan.id',
                't_percakapan.kd_customer',
                'm_customer.nama_customer',
                'm_users.employee_name'
            )
            // ->where('')
            ->whereIn('t_percakapan.kd_customer', $idCustomer)
            ->get();
        // return $pesan;
        $arrPesan = [];
        $firstMessage = '';
        $lastMessage = '';
        $secondMessage = '';
        $hours = '';
        $minutes = '';
        $diffInSeconds = '';
        foreach ($pesan as $psn) {
            $arrPesan[$psn->kd_customer][] = $psn;
            $psn->firstMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '0')->orderBy('created_date', 'ASC')->first();
            $psn->secondMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '1')->orderBy('created_date', 'ASC')->first();
            $psn->lastMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->orderBy('created_date', 'DESC')->first();
            if (isset($psn->lastMessage)) {
                $diffInSeconds = strtotime($psn->lastMessage->created_date) - strtotime($psn->firstMessage->created_date);
                $psn->hours = floor($diffInSeconds / 3600);
                $psn->minutes = floor(($diffInSeconds % 3600) / 60);
            }
        }
        // return $arrPesan;

        foreach ($customer as $csd) {
            $csd->detail = isset($arrPesan[$csd->kd_customer]) ? $arrPesan[$csd->kd_customer] : [];
            $csd->firstMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->firstMessage : '';
            $csd->lastMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->lastMessage : '';
            $csd->secondMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->secondMessage : '';
            // if($firstMessage != ''){
            // }
            // $csd->lastMessage = isset($lastMessage[$csd->kd_customer]) ? $lastMessage[$csd->kd_customer] : '[]';
            // if($lastMessage != ''){
            // }
            if (isset($arrPesan[$csd->kd_customer][0])) {
                $csd->hours = $arrPesan[$csd->kd_customer][0]->hours;
                $csd->minutes = $arrPesan[$csd->kd_customer][0]->minutes;
            }
        }

        // return $customer;



        // $customers = DB::table('m_customer')
        // ->leftJoin('m_kota', 'm_customer.company_city', '=', 'm_kota.kd_kota') 
        // ->leftJoin('m_provinsi', 'm_customer.company_province', '=', 'm_provinsi.kd_provinsi') 
        // ->leftJoin('m_cabang', 'm_customer.kd_cabang', '=', 'm_cabang.kd_cabang')
        // ->leftJoin('t_percakapan', 'm_customer.kd_customer', '=', 't_percakapan.kd_customer')
        // ->leftJoin('t_pesan', 't_percakapan.id', '=', 't_pesan.conversation_id')
        // ->select(
        //     'm_customer.kd_customer',
        //     'm_customer.nama_customer',
        //     // 'm_kota.nama_kota as city_name',
        //     // 'm_provinsi.nama_provinsi as province_name',
        //     // 'm_cabang.nama_cabang as branch_name',
        //     DB::raw('GROUP_CONCAT(t_pesan.message) as messages') // Menggabungkan semua pesan
        // )
        // ->whereBetween('m_customer.created_date', [$start, $end])
        // ->where('m_customer.is_delete', 'N')
        // ->groupBy('m_customer.kd_customer', 'm_customer.nama_customer') // Grouping berdasarkan customer
        // ->get();
        //         return $customers;
        //     $customer = Customer::with(['city', 'province', 'branch', 'percakapan.message'])
        // ->whereBetween('created_date', [$request->startDate, $request->endDate])
        // ->where('is_delete', 'N')
        // ->chunk(100, function ($customers) {
        //     foreach ($customers as $customer) {
        //         // Proses setiap customer
        //     }
        // });

        // return 'ok';
        // $messages = '';

        // // Query data customer dengan eager loading
        // $customerQuery = Customer::with(['city', 'province', 'branch'])
        //     ->where('is_delete', 'N');

        // if ($start && $end) {
        //     $customerQuery->whereBetween('created_date', [$start, $end]);
        // }

        // $customers = $customerQuery->get();

        // // Ambil semua percakapan terkait customer
        // $customerIds = $customers->pluck('kd_customer')->toArray();
        // $conversations = DB::table('t_percakapan')
        //     ->whereIn('kd_customer', $customerIds)
        //     ->get()
        //     ->groupBy('kd_customer');

        // $messages = [];

        // foreach ($customers as $customer) {
        //     if (isset($conversations[$customer->kd_customer])) {
        //         foreach ($conversations[$customer->kd_customer] as $conversation) {
        //             $conversationMessages = DB::table('t_pesan')
        //                 ->leftJoin('m_users', 't_pesan.send_id', '=', 'm_users.kd_user')
        //                 ->leftJoin('m_customer', 't_pesan.send_id', '=', 'm_customer.kd_customer')
        //                 ->where('conversation_id', $conversation->id)
        //                 ->select('t_pesan.*', 'm_users.employee_name', 'm_customer.nama_customer')
        //                 ->get();

        //             $messages[$customer->kd_customer][] = $conversationMessages;
        //         }
        //     }
        // }
        // return $customers;

        return view('report.customerPreview', compact('customer', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'messages', 'start', 'end'));
    }
}


// $customers = Customer::with(['conversations.messages'])->get();
// return $customers;