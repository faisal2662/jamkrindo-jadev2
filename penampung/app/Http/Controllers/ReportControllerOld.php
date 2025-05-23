<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Message;
use App\Models\Percakapan;
use App\Models\Role;
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
        if ($request->startDate && $request->endDate) {
            $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        } else {
            $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        }
        $start = $request->startDate;
        $end = $request->endDate;
        
        // foreach($customer as $cs){
        //     $percakapan = Percakapan::where('kd_customer', $cs->kd_customer)->first('receive_id');
        //     $messages = Message::with('user')->where('send_id', $cs->kd_customer)
        //         ->get();
        // }
        // return $messages;
        // // dd(Carbon::now()->subSecond(5));
        // $percakapan = Percakapan::where('kd_customer', $request->userId)->first('receive_id');
        // // dd($percakapan->receive_id);

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
        // $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->startDate, $request->endDate])->where('is_delete', 'N')->get();
        $start = $request->startDate;
        $end = $request->endDate;

        // // Query data customer dengan eager loading
        $customerQuery = Customer::with(['city', 'province', 'branch'])
            ->where('is_delete', 'N');

        if ($start && $end) {
            $customerQuery->whereBetween('created_date', [$start, $end]);
        }

        $customers = $customerQuery->get();

        // Ambil semua percakapan terkait customer
        $customerIds = $customers->pluck('kd_customer')->toArray();
        $conversations = DB::table('t_percakapan')
            ->whereIn('kd_customer', $customerIds)
            ->get()
            ->groupBy('kd_customer');

        $messages = [];

        foreach ($customers as $customer) {
            if (isset($conversations[$customer->kd_customer])) {
                foreach ($conversations[$customer->kd_customer] as $conversation) {
                    $conversationMessages = DB::table('t_pesan')
                        ->leftJoin('m_users', 't_pesan.send_id', '=', 'm_users.kd_user')
                        ->leftJoin('m_customer', 't_pesan.send_id', '=', 'm_customer.kd_customer')
                        ->where('conversation_id', $conversation->id)
                        ->select('t_pesan.*', 'm_users.employee_name', 'm_customer.nama_customer')
                        ->get();

                    $messages[$customer->kd_customer][] = $conversationMessages;
                }
            }
        }

        return view('report.customerPreview', compact('customers', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'start', 'end'));
    }
}
