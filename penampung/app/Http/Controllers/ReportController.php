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
        foreach($customer as $cs){
            if(!in_array($cs->kd_customer, $idCustomer)){
                $idCustomer[] = $cs->kd_customer;
            }
        }
        // $idCustomer = [1];

        $pesan = DB::table('t_percakapan')->leftJoin('t_pesan', 't_percakapan.id', 't_pesan.conversation_id')
                ->leftJoin('m_customer','t_pesan.send_id', '=', 'm_customer.kd_customer')
                ->leftJoin('m_users','t_pesan.send_id', '=', 'm_users.kd_user')
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
        foreach($pesan as $psn){
            $arrPesan[$psn->kd_customer][] = $psn;
            $psn->firstMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '0')->orderBy('created_date', 'ASC')->first();
            $psn->secondMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '1')->orderBy('created_date', 'ASC')->first();
            $psn->lastMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->orderBy('created_date', 'DESC')->first();
            if(isset($psn->lastMessage)){
                $diffInSeconds = strtotime($psn->lastMessage->created_date) - strtotime($psn->firstMessage->created_date);
                $psn->hours = floor($diffInSeconds / 3600);
                $psn->minutes = floor(($diffInSeconds % 3600) / 60);
            }
        }
        // return $arrPesan;

        foreach($customer as $csd){
            $csd->detail = isset($arrPesan[$csd->kd_customer]) ? $arrPesan[$csd->kd_customer] : [];
            $csd->firstMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->firstMessage : '';
            $csd->lastMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->lastMessage : '';
            $csd->secondMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->secondMessage : '';
            // if($firstMessage != ''){
            // }
            // $csd->lastMessage = isset($lastMessage[$csd->kd_customer]) ? $lastMessage[$csd->kd_customer] : '[]';
            // if($lastMessage != ''){
            // }
            if(isset($arrPesan[$csd->kd_customer][0])){
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
        foreach($customer as $cs){
            if(!in_array($cs->kd_customer, $idCustomer)){
                $idCustomer[] = $cs->kd_customer;
            }
        }
        // $idCustomer = [1];

        $pesan = DB::table('t_percakapan')->leftJoin('t_pesan', 't_percakapan.id', 't_pesan.conversation_id')
                ->leftJoin('m_customer','t_pesan.send_id', '=', 'm_customer.kd_customer')
                ->leftJoin('m_users','t_pesan.send_id', '=', 'm_users.kd_user')
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
        foreach($pesan as $psn){
            $arrPesan[$psn->kd_customer][] = $psn;
            $psn->firstMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '0')->orderBy('created_date', 'ASC')->first();
            $psn->secondMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->where('status', '1')->orderBy('created_date', 'ASC')->first();
            $psn->lastMessage = DB::table('t_pesan')->where('conversation_id', $psn->conversation_id)->orderBy('created_date', 'DESC')->first();
            if(isset($psn->lastMessage)){
                $diffInSeconds = strtotime($psn->lastMessage->created_date) - strtotime($psn->firstMessage->created_date);
                $psn->hours = floor($diffInSeconds / 3600);
                $psn->minutes = floor(($diffInSeconds % 3600) / 60);
            }
        }
        // return $arrPesan;

        foreach($customer as $csd){
            $csd->detail = isset($arrPesan[$csd->kd_customer]) ? $arrPesan[$csd->kd_customer] : [];
            $csd->firstMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->firstMessage : '';
            $csd->lastMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->lastMessage : '';
            $csd->secondMessage = isset($arrPesan[$csd->kd_customer][0]) ? $arrPesan[$csd->kd_customer][0]->secondMessage : '';
            // if($firstMessage != ''){
            // }
            // $csd->lastMessage = isset($lastMessage[$csd->kd_customer]) ? $lastMessage[$csd->kd_customer] : '[]';
            // if($lastMessage != ''){
            // }
            if(isset($arrPesan[$csd->kd_customer][0])){
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