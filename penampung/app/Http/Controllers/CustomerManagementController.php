<?php

namespace App\Http\Controllers;

require_once base_path('vendor/PhpSpreadsheet/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Response;

use Carbon\Carbon;
use App\Models\City;
use App\Models\Branch;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Regional;
use App\Models\CustomerChange;
use App\Models\Notif;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use DataTables;

class CustomerManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 3)->first();
        if($role->can_access == 'N'){
            return redirect()->route('dashboard');
         }
        $branch = Branch::where('is_delete', 'N')->get();
        return view('customer-management.index', compact('branch', 'role'));
    }


     public function getData(Request $request)
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 3)->first();
        if (Auth::user()->id_role != 1) {
            $customers = Customer::leftJoin('m_cabang', 'm_customer.kd_cabang', 'm_cabang.id_cabang')->select('m_customer.*' ,'m_cabang.nm_cabang')->where('m_customer.kd_cabang', Auth::user()->branch_code)->where('m_customer.is_delete', 'N');
        } else {
            $customers = Customer::leftJoin('m_cabang', 'm_customer.kd_cabang', 'm_cabang.id_cabang')->select('m_customer.*' ,'m_cabang.nm_cabang')->where('m_customer.is_delete', 'N');
        }
        if ($request->startDate && $request->endDate) {
            $customers->whereBetween('m_customer.created_date', [$request->startDate, $request->endDate]);
        }

        $customers = $customers->orderBy('m_customer.created_date', 'desc')->get(); 
    
        $no = 1;

        $status = [
            'Info' => 'bg-info',
            'Reject' => 'bg-danger',
            'Approve' => 'bg-primary',
            'Pending' => 'bg-warning',
            // 'Delete' => 'bi bi-trash text-warning',
            // 'DeleteApprove' => 'bi bi-trash text-success',
            // 'DeleteReject' => 'bi bi-trash text-danger',
        ];
        foreach ($customers as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;
            $btn = 'text-success fw-bold';

            if ($act->status_customer != 'Active') {
                $btn = 'text-danger fw-bold';
            }
            $act->no = $no++;
            $status_customer = "<span class=' " . $btn . "'> " . $act->status_customer . "</span>";
            $status_perubahan =  DB::table('tb_customer_changed')->where('kd_customer', $act->kd_customer)->where('is_delete', 'N')->orderBy('updated_date', 'desc')->first();

            if (!is_null($status_perubahan)) {

                $act->status_perubahan = '<span class="badge ' . $status[$status_perubahan->status_change] . '">' . $status_perubahan->status_change . '</span>';
            } else {

                $act->status_perubahan =  '';
            }
            $act->nama_cabang  = $act->nm_cabang ?? '-';
            $act->nama_customer = '<p style="margin-bottom: 5px ;">' . $act->nama_customer . ' </p><p style="margin-bottom: 5px ;">' . $status_customer .' </p> ';
            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $act->action =   "<a href='customers-management/lihat/" . $act->kd_customer . "' class='btn btn-sm'><i
                                                    class='bi bi-search'></i></a>  <a href='customers-management/edit/" . $act->kd_customer . "' class='btn btn-sm'><i class='bi bi-pencil-square'></i></a><button class='btn btn-sm fw-bold' onclick='customerDelete(\"" . $act->kd_customer . "\",\"" . $act->userid_customer . "\")'><i class='bi bi-trash' ></i></button>";
            } else if ($role->can_update == 'Y') {
                $act->action =   "<a href='customers-management/lihat/" . $act->kd_customer . "' class='btn btn-sm'><i class='bi bi-search'></i></a>  <a href='customers-management/edit/" . $act->kd_customer . "' class='btn btn-sm'><i class='bi bi-pencil-square'></i></a>";
            } else if ($role->can_delete == 'Y') {
                $act->action =   "<a href='customers-management/lihat/" . $act->kd_customer . "' class='btn btn-sm'><i
                                                    class='bi bi-search'></i></a> <button class='btn btn-sm fw-bold' onclick='customerDelete(\"" . $act->kd_customer . "\",\"" . $act->userid_customer . "\" )'><i class='bi bi-trash' ></i></button>";
            } else {
                $act->action =   "<a href='customers-management/lihat/" . $act->kd_customer . "' class='btn btn-sm'><i
                                                    class='bi bi-search'></i></a> ";
            }

          
        }
        return datatables::of($customers)->escapecolumns([])->make(true);
    }

    public function getLogEdit(Request $request)
    {
        $get_log = DB::table('tb_customer_changed')
            ->leftJoin('m_users as maker', 'tb_customer_changed.kd_maker', '=', 'maker.kd_user')
            ->leftJoin('m_users as approve', 'tb_customer_changed.kd_approved', '=', 'approve.kd_user')
            ->leftJoin('m_users as reject', 'tb_customer_changed.kd_reject', '=', 'reject.kd_user')
            ->select(
                'tb_customer_changed.*',
                'maker.nm_user as maker_name',
                'tb_customer_changed.maker_date as maker_date',
                'approve.nm_user as approve_name',
                'tb_customer_changed.approved_date as approve_date',
                'reject.nm_user as reject_name',
                'tb_customer_changed.reject_date as reject_date'
            )
            ->where('tb_customer_changed.is_delete', 'N')
            ->where('tb_customer_changed.kd_customer', $request->kd_customer)
            ->orderBy('tb_customer_changed.created_date', 'desc')
            ->get();

        $no = 1;
        foreach ($get_log as $data) {
            $data->no = $no++;
            $data->maker = $data->maker_name ?? '-';
            $data->maker_date = $data->maker_date ? Carbon::parse($data->maker_date)->translatedFormat('l, d F Y H:i') : '-';
            $data->approve = $data->approve_name ?? '-';
            $data->approve_date = $data->approve_date ? Carbon::parse($data->approve_date)->translatedFormat('l, d F Y H:i') : '-';
            $data->reject = $data->reject_name ?? '-';
            $data->reject_date = $data->reject_date ? Carbon::parse($data->reject_date)->translatedFormat('l, d F Y H:i') : '-';

            // Menentukan status dengan badge
            if ($data->status_change == 'Pending') {
                $data->status = '<span class="badge bg-warning">' . $data->status_change . '</span>';
            } elseif ($data->status_change == 'Reject') {
                $data->status = '<span class="badge bg-danger">' . $data->status_change . '</span>';
            } else {
                $data->status = '<span class="badge bg-primary">' . $data->status_change . '</span>';
            }
            if (strpos($data->title, 'Hapus') !== false) {
                // Menambahkan tombol aksi
                $data->act = '<button class="btn btn-primary btn-sm" onClick="detail_log_hapus(' . $data->id . ')"> <i class="bi bi-info-square"></i> Detail</button>';
            } else {
                $data->act = '<button class="btn btn-primary btn-sm" onClick="detail_log(' . $data->id . ')"> <i class="bi bi-info-square"></i> Detail</button>';
            }
        }

        return datatables::of($get_log)->escapeColumns([])->make(true);
    }

    public function getLogDetail(Request $request)
    {
        $get_log = DB::table('tb_customer_changed')->join('m_customer', 'tb_customer_changed.kd_customer', 'm_customer.kd_customer')->join('m_cabang', 'm_customer.kd_cabang', 'm_cabang.id_cabang')->select('tb_customer_changed.*', 'm_cabang.kd_cabang', 'm_cabang.nm_cabang')->where('id', $request->id)->first();

        return response()->json($get_log, 200);
    }
    public function submit(Request $request)
    {
        $jabatan = ['Pemimpin', 'Manajer'];
        $jabatan_name = false; // Inisialisasi dengan false
        foreach ($jabatan as $val) {
            if (strpos(auth()->user()->position_name, $val) !== false) {
                $jabatan_name = true; // Jika ditemukan, set menjadi true
                break; // Keluar dari loop
            }
        }
        if ($jabatan_name) {
            return response()->json(['status' => false, 'Message' => 'Kamu Tidak dapat melakukan aktivitas ini']);
        }
        $data  = $request->except(['_token']);
        if ($request->company_province) {
            $data['company_province'] = DB::table('m_provinsi')->where('kd_provinsi', $request->company_province)->first()->nm_provinsi;
        }
        if ($request->company_city) {
            $data['company_city'] = DB::table('m_kota')->where('kd_kota', $request->company_city)->first()->nm_kota;
        }
        if ($request->cabang) {
            $data['nm_cabang'] = DB::table('m_cabang')->where('id_cabang', $request->cabang)->first()->nm_cabang;
        }
        $hostUrl = request()->getHost();


        $dataNew = json_decode(json_encode($data), true); // Pastikan dalam bentuk array
        $cust = DB::table('m_customer')
            ->where('m_customer.is_delete', 'N')
            ->where('m_customer.kd_customer', $request->kd_customer)
            ->first();
            // return $cust;
        if ($cust->company_province) {

            $cust->company_province = DB::table('m_provinsi')->where('kd_provinsi', $cust->company_province)->first()->nm_provinsi;
        }
        if ($cust->company_city) {
            $cust->company_city = DB::table('m_kota')->where('kd_kota', $cust->company_city)->first()->nm_kota;
        }
        if ($cust->kd_cabang) {
            $cust->nm_cabang = DB::table('m_cabang')->where('id_cabang', $cust->kd_cabang)->first()->nm_cabang;
        }

        $dataOld = json_decode(json_encode($cust), true);
        $baru =  array_diff_assoc($dataNew, $dataOld); // Nilai di $dataNew yang tidak ada di $dataOld
        $lama =  array_diff_assoc($dataOld, $dataNew); // Nilai di $dataOld yang tidak ada di $dataNew
        $baru = json_encode($baru);
        $lama = json_encode($lama);


        $posisi = str_replace('Staf', 'Manajer', auth()->user()->position_name);
        $users = DB::table('m_users')->where('is_delete', 'N')->where('position_name', $posisi)->get();

        try {
            $cusChanged = new CustomerChange;
            $cusChanged->title = 'Perubahan Customer';
            $cusChanged->status_change = 'Pending';
            $cusChanged->kd_maker = auth()->user()->kd_user;
            $cusChanged->kd_customer = $request->kd_customer;
            $cusChanged->json_data = $baru;
            $cusChanged->before_data = $lama;
            $cusChanged->maker_date = now();
            $cusChanged->save();

            foreach ($users as $key => $user) {
                # code...
                $notif = new Notif();
                $notif->kd_user = $user->kd_user;
                $notif->keterangan = 'Mengajukan Perubahan pada customer oleh ' . auth()->user()->nm_user;
                $notif->status = 'Info';
                $notif->tautan = '/customers-management/lihat/' . $request->kd_customer;
                $notif->created_by = auth()->user()->nm_user;
                $notif->save();
            }
            return redirect()->route('customer-manager.index')->with('success', 'Berhasil diajukan');
        } catch (\Throwable $th) {
            // throw $th;

            // dd($th->getMessage());
            return redirect()->route('customer-manager.index')->with('success', 'Gagal diajukan');
        }
    }
    public function approve(Request $request)
    {
        $get_log = CustomerChange::where('id', $request->id_log)->first();

        $result_data = json_decode($get_log->json_data, true);
        $result_data['kd_cabang'] = $result_data['cabang'];
        unset($result_data['cabang']);
        unset($result_data['nm_cabang']);
        unset($result_data['wilayah']);
        $result_data['updated_by'] = auth()->user()->nm_user;
        // return $result_data;
        if ($request->action == 'reject') {
            try {
                $get_log->kd_reject = auth()->user()->kd_user;
                $get_log->reject_date = now();
                $get_log->status_change = 'Reject';
                $get_log->update();



                $notif = DB::table('t_notif')->insert([
                    'kd_user' => $get_log->kd_maker,
                    'keterangan' => 'Perubahan yang anda ajukan di Tolak oleh ' . auth()->user()->nm_user,
                    'status' => 'Reject',
                    'tautan' => '/customers-management/lihat/' . $get_log->kd_customer,
                    'created_by' => auth()->user()->nm_user,
                    'created_date' => now()
                ]);
                return back()->with('success', $request->action . ' berhasil');
            } catch (\Throwable $th) {
                //throw $th;
                return back()->with('danger', $request->action . ' Gagal');
                // dd($th->getMessage());
            }
        } else {
            try {
                $get_log->kd_approved = auth()->user()->kd_user;
                $get_log->approved_date = now();
                $get_log->status_change = 'Approve';
                $get_log->update();


                $notif = DB::table('t_notif')->insert([
                    'kd_user' => $get_log->kd_maker,
                    'keterangan' => 'Perubahan yang anda ajukan di Terima oleh ' . auth()->user()->nm_user,
                    'status' => 'Approve',
                    'tautan' => '/customers-management/lihat/' . $get_log->kd_customer,
                    'created_by' => auth()->user()->nm_user,
                    'created_date' => now()
                ]);

                $customer  = DB::table('m_customer')->where('kd_customer', $get_log->kd_customer)->update($result_data);
                // dd($customer);
                return back()->with('success', $request->action . ' berhasil');
            } catch (\Throwable $th) {
                //throw $th;

                return back()->with('danger', $request->action . ' Gagal');
            }
        }
    }

    public function getLogCustomer(Request $request){

        $log = DB::table('t_log_customer')->join('m_customer', 't_log_customer.kd_customer', 'm_customer.kd_customer')
            ->where('t_log_customer.is_delete', 'N')
            ->where('t_log_customer.kd_customer', $request->id_customer)
            ->select('t_log_customer.*', 'm_customer.nama_customer')
            ->orderBy('t_log_customer.created_date', 'desc')
            ->get();

        $no =1;

        foreach ($log as $data) {
           $data->no = $no++;

            $data->nama_customer = $data->nama_customer;
            $data->tanggal =  $data->created_date  ?  Carbon::parse($data->created_date)->translatedFormat('l, d F Y H:i') : '-';
        }

        return datatables::of($log)->escapecolumns([])->make(true);

    }

    public function getDataKota($id)
    {
        $cities = City::where('kd_provinsi', $id)->where('is_delete', 'N')->get();

        return response()->json($cities);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $wilayah = Regional::where('is_delete', 'N')->get();
        $provinsi = Province::where('is_delete', 'N')->get();
        return view('customer-management.create', compact('provinsi', 'wilayah'));
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
        //dd($request);
        $request->validate(
            [
                'nama_customer' => 'required',
                'userid_customer' => 'required|unique:m_customer',
                'email_customer' => 'required|unique:m_customer',
                'foto_customer' => 'image|mimes:jpg,png,jpeg,webp',
                'password' => 'required|confirmed|min:8'
            ],
            [
                'email.unique' => 'email sudah terdaftar',
                'file.mimes' => 'Foto harus jpg,png,jpeg,webp',
                'password.confirmed' => 'password tidak sama',
                'password.min' => 'password minimal 8 karakter',
            ]

        );

        $password = Hash::make($request->password);
        try {
            $customer = new Customer;
            $customer->nama_customer = $request->nama_customer;
            $customer->hp_customer = $request->hp_customer;
            $customer->email_customer = $request->email_customer;
            $customer->userid_customer = $request->userid_customer;
            $customer->password = $password;
            $customer->kd_cabang = $request->cabang;
            $customer->status_customer = $request->status_customer;
            if ($request['foto_customer']) {
                $filename = 'cust-' . uniqid() . '-' . $request->nama_customer . '.' . $request['foto_customer']->getClientOriginalExtension();
                $file  = $request->file('foto_customer');
                $file->move(base_path('../assets/img/customer/'),  $filename);
                $customer->foto_customer = $filename;
            }
            $customer->kd_referral_customer = $request->kode_referral_customer;
            $customer->company_name = $request->company_name;
            $customer->company_province = $request->company_province;
            $customer->company_city = $request->company_city;
            //$customer->terms = $request->terms;
            $customer->created_by = Auth::user()->nm_user;
            $customer->save();

            return redirect()->route('customer-manager.index')->with('success', 'Simpan data berhasil');
            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return back()->with('error', 'Simpan data gagal : ' . $e->getMessage());
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
        $kota = City::where('is_delete', 'N')->get();
        $provinsi = Province::where('is_delete', 'N')->get();
        // $customer = Customer::with(['Branch', 'Business'])->where('kd_customer', $id)->first();     
        // $customer = Customer::with(['Branch', 'Business', 'Province', 'City'])->where('kd_customer', $id)->first();
        $customer = Customer::leftJoin('m_kota' , 'm_customer.company_city' , 'm_kota.kd_kota')->leftJoin('m_provinsi', 'm_customer.company_province', 'm_provinsi.kd_provinsi')->where('m_customer.kd_customer', $id)
        ->select('m_customer.*' ,'m_kota.nm_kota', 'm_provinsi.nm_provinsi')->first();


        return view('customer-management.show', compact('customer', 'provinsi', 'kota'));
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
        $customer = Customer::with(['branch', 'city', 'province'])->where('kd_customer', $id)->first();
        $provinsi = Province::where('is_delete', 'N')->get();
        $wilayah = Regional::where('is_delete', 'N')->get();
        if ($customer->branch) {

            $wilayahId = Regional::where('id_kanwil', $customer->branch->kd_wilayah)->first();
            return view('customer-management.edit', compact('customer', 'provinsi', 'wilayah', 'wilayahId'));
        }
        $wilayahId = false;
        return view('customer-management.edit', compact('customer', 'provinsi', 'wilayah', 'wilayahId'));
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
        // dd($id);
        $request->validate(
            [
                'nama_customer' => 'required',
                'userid_customer' => 'required',
                'email_customer' => 'required',
                'foto_customer' => 'image|mimes:jpg,png,jpeg,webp',
            ],
            [
                'email.required' => 'email wajib diisi',
                'userid.required' => 'User Id wajib diisi',
                'foto_customer.mimes' => 'Foto harus jpg,png,jpeg,webp',
            ]

        );

        try {
            $customer = Customer::where('kd_customer', $id)->first();
            $customer->nama_customer = $request->nama_customer;
            $customer->hp_customer = $request->hp_customer;
            $customer->email_customer = $request->email_customer;
            $customer->userid_customer = $request->userid_customer;
            if ($request->password) {
                $request->validate(
                    [
                        'password' => 'required|confirmed'
                    ],
                    [
                        'password.confirmed' => 'password tidak sama'
                    ]

                );
                $password = Hash::make($request->password);
                $customer->password = $password;
            }
            $customer->kd_cabang = $request->cabang;
            $customer->status_customer = $request->status_customer;
            if ($request['foto_customer']) {
                $filename = 'cust-' . uniqid() . '-' . $request->nama_customer . '.' . $request['foto_customer']->getClientOriginalExtension();
                $file  = $request->file('foto_customer');
                $file->move(base_path('../assets/img/customer/'),  $filename);
                $customer->foto_customer = $filename;
            }
            $customer->kd_referral_customer = $request->kode_referral_customer;
            $customer->company_name = $request->company_name;
            $customer->company_province = $request->company_province;
            $customer->company_city = $request->company_city;
            //$customer->terms = $request->terms;
            $customer->updated_by = Auth::user()->nm_user;
            $customer->update();

            return redirect()->route('customer-manager.index')->with('success', 'Ubah data berhasil');
            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return back()->with('error', 'Simpan data gagal : ' . $e->getMessage());
            // return response()->json(['status' => $e->getMessage()], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        $get_log = CustomerChange::where('id', $request->id_log)->first();
        $date = Carbon::now();
        // dd($request);
        try {

            if ($request->action == 'reject') {
                $get_log->kd_reject = auth()->user()->kd_user;
                $get_log->reject_date = now();
                $get_log->status_change = 'Reject';
                $get_log->update();

                $notif = DB::table('t_notif')->insert([
                    'kd_user' => $get_log->kd_maker,
                    'keterangan' => 'Hapus Customer yang anda ajukan di Tolak oleh ' . auth()->user()->nm_user,
                    'status' => 'Reject',
                    'tautan' => '/customers-management/lihat/' . $get_log->kd_customer,
                    'created_by' => auth()->user()->nm_user,
                    'created_date' => now()
                ]);
                return redirect()->back()->with('success', 'Berhasil ditolak');
            } else {

                $get_log->kd_approved = auth()->user()->kd_user;
                $get_log->approved_date = now();
                $get_log->status_change = 'Approve';
                $get_log->update();


                $notif = DB::table('t_notif')->insert([
                    'kd_user' => $get_log->kd_maker,
                    'keterangan' => 'Hapus Customer yang anda ajukan di Terima oleh ' . auth()->user()->nm_user,
                    'status' => 'Approve',
                    'tautan' => '/customers-management',
                    'created_by' => auth()->user()->nm_user,
                    'created_date' => now()
                ]);
                $customer = Customer::where('kd_customer', $get_log->kd_customer)->first();
                $customer->updated_by = Auth::user()->nm_user;
                $customer->deleted_date = $date;
                $customer->is_delete = 'Y';
                $customer->update();
                return redirect()->route('customer-manager.index')->with('success', 'Berhasil dihapus');
            }
        } catch (\Exception $e) {

            return redirect()->route('customer-manager.index')->with('success', 'Gagal dihapus');
        }
    }

    public function submitDelete(Request $request)
    {
        $jabatan = ['Pemimpin', 'Staff', 'Staf'];
        $jabatan_name = false; // Inisialisasi dengan false
        foreach ($jabatan as $val) {
            if (strpos(auth()->user()->position_name, $val) !== false) {
                $jabatan_name = true; // Jika ditemukan, set menjadi true
                break; // Keluar dari loop
            }
        }
        if ($jabatan_name) {
            return response()->json(['status' => false, 'message' => 'Kamu Tidak dapat melakukan aktivitas ini']);
        }
        $cabang = str_replace('Kantor', '', auth()->user()->branch_name);
        $posisi = 'Pemimpin' . $cabang;
        $users = DB::table('m_users')->where('is_delete', 'N')->where('position_name', $posisi)->get();
        if (is_null($users)) {
            return response()->json('status', 'Terdapat kesalahan');
        }
        try {
            $cusChanged = new CustomerChange;
            $cusChanged->title = 'Hapus Customer';
            $cusChanged->status_change = 'Pending';
            $cusChanged->kd_maker = auth()->user()->kd_user;
            $cusChanged->kd_customer = $request->id;
            $cusChanged->maker_date = now();
            $cusChanged->save();

            foreach ($users as $key => $user) {
                # code...
                $notif = new Notif();
                $notif->kd_user = $user->kd_user;
                $notif->keterangan = 'Mengajukan Hapus customer oleh ' . auth()->user()->nm_user;
                $notif->status = 'Delete';
                $notif->tautan = '/customers-management/lihat/' . $request->id;
                $notif->created_by = auth()->user()->nm_user;
                $notif->save();
            }
            return response()->json(['status' => 'berhasil'], 200);
        } catch (\Throwable $th) {
            // throw $th;
            return response()->json(['status' => $th->getMessage()], 500);
        }
    }


    public function profile()
    {
        $customer = Customer::with(['Branch', 'Business', 'Province', 'City'])->where('kd_customer', Auth::user()->kd_customer)->first();
        $provinsi = Province::where('is_delete', 'N')->get();
        $wilayah = Regional::where('is_delete', 'N')->get();
        return view('profile.profile-customer', compact('customer', 'wilayah', 'provinsi'));
    }
    public function profileUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'nama_customer' => 'required',
                'userid_customer' => 'required',
                'email_customer' => 'required',
                'foto_customer' => 'image|mimes:jpg,png,jpeg,webp',
            ],
            [
                'email.required' => 'email wajib diisi',
                'userid.required' => 'User Id wajib diisi',
                'foto_customer.mimes' => 'Foto harus jpg,png,jpeg,webp',
            ]

        );

        try {
            $customer = Customer::where('kd_customer', $id)->first();
            $customer->nama_customer = $request->nama_customer;
            $customer->hp_customer = $request->hp_customer;
            $customer->email_customer = $request->email_customer;
            $customer->userid_customer = $request->userid_customer;
            $customer->kd_cabang = $request->cabang;
            if ($request['foto_customer']) {
                $filename = 'cust-' . uniqid() . '-' . $request->nama_customer . '.' . $request['foto_customer']->getClientOriginalExtension();
                $file  = $request->file('foto_customer');
                $file->move(base_path('/../assets/img/customer'),  $filename);
                $customer->foto_customer = $filename;
            }
            $customer->kd_referral_customer = $request->kode_referral_customer;
            $customer->company_name = $request->company_name;
            $customer->company_province = $request->company_province;
            $customer->company_city = $request->company_city;
            //$customer->terms = $request->terms;
            $customer->updated_by = Auth::user()->nm_user;
            $customer->update();

            return back()->with('success', 'Ubah data berhasil');
            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return back()->with('error', 'Simpan data gagal : ' . $e->getMessage());
            // return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate(
            [
                'password' => 'required|confirmed',
                'oldPassword' => 'required'

            ],
            [
                'password.confirmed'  => 'konfirmasi password tidak sama',
                'oldPassword.required' => 'password lama wajib diisi'
            ]
        );
        $customer = Customer::where('kd_customer', $id)->first();
        if (Hash::check($request->oldPassword, $customer->password)) {
            // dd('sama');
            try {

                $password = Hash::make($request->password);
                $customer->password = $password;
                $customer->updated_by = Auth::user()->nama_customer;
                $customer->update();
                // return response()->json(['status' => 'success'], 200);
                return back()->with('success', 'Ubah kata sandi berhasil');
            } catch (\Exception $e) {
                return back()->with('error', ' Ubah data gagal :' . $e->getMessage());
                // return response()->json(['status' => $e->getMessage()], 500);
            }
        } else {
            return back()->with('error', 'kata sandi tidak sesuai');
        }
    }

    public function cetakPdf(Request $request)
    {
        $customer = '';
        // if (Auth::user()->id_role != 1) {
        // $customers = Customer::with(['Branch'])->where('kd_cabang', Auth::user()->branch_code)->where('is_delete', 'N');
        //     } else {
        //         $customers = Customer::with(['Branch'])->where('is_delete', 'N');
        //     }
        // if ($request->startDate && $request->endDate) {
        //     $customers->whereBetween('created_date', [$request->startDate, $request->endDate]);
        // }
        // $customers->orderBy('created_date', 'desc')->get();
        if (Auth::user()->id_role != 1) {
            $customer = Customer::with(['city', 'province', 'Branch'])->where('kd_cabang', Auth::user()->branch_code)->where('is_delete', 'N')->whereBetween('created_date', [$request->start, $request->end])->get();
        } else {
            $customer = Customer::with(['city', 'province', 'Branch'])->where('is_delete', 'N')->get();
        }
        // $customer = customer::with(['city', 'province', 'branch'])->whereBetween('created_date', [$request->start, $request->end])->where('is_delete', 'N')->get();
        // return view('customer-management.export-pdf');


        //$pdf = PDF::loadview('customer-management.export-pdf', ['customer' => $customer, 'start' => $request->start, 'end' => $request->end])->setPaper('A4', 'landscape');
        //return $pdf->download('Pelanggan ' . $request->start . 'to' . $request->end . '.pdf');
        return view('customer-management.export-pdf', ['customer' => $customer, 'start' => $request->start, 'end' => $request->end]);
    }

    public function reportExcelOldies(Request $request)
    {
        // Buat spreadsheet baru
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $start = date('d-m-Y', strtotime($request->start));
        $end = date('d-m-Y', strtotime($request->end));

        // Menambahkan header
        $sheet->setCellValue('A1', 'Laporan Customer');
        $sheet->setCellValue('A2', 'Tanggal ' . $start . ' s/d ' . $end);
        $sheet->setCellValue('A4', 'No');
        $sheet->setCellValue('B4', 'Nama Customer');
        $sheet->setCellValue('C4', 'Cabang');
        $sheet->setCellValue('D4', 'Email');
        $sheet->setCellValue('E4', 'No. Hp');
        $sheet->setCellValue('F4', 'Nama Perusahaan');
        $sheet->setCellValue('G4', 'Provinsi Perusahaan');
        $sheet->setCellValue('H4', 'Kota Perusahaan');
        $sheet->setCellValue('I4', 'Status');

        // Mengatur ukuran kolom
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->getStyle('A2')->getFont()->setBold(true);
        $sheet->getStyle('A1')->getFont()->setSize(16);
        $sheet->getStyle('A2')->getFont()->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:I4')->getFont()->setBold(true);

        // Menambahkan data
        $customers = Customer::with(['city', 'province', 'branch'])
            ->whereBetween('created_date', [$request->start, $request->end])
            ->where('m_customer.is_delete', 'N')
            ->get();

        $row = 5; // Mulai dari baris ke-5 karena baris pertama adalah header
        $no = 1; // Mulai dari baris ke-5 karena baris pertama adalah header
        foreach ($customers as $item) {
            $sheet->setCellValue('A' . $row, $no);
            $sheet->setCellValue('B' . $row, $item->nama_customer);
            $sheet->setCellValue('C' . $row, $item->branch->nm_cabang ?? '-');
            $sheet->setCellValue('D' . $row, $item->email_customer);
            $sheet->setCellValue('E' . $row, $item->hp_customer);
            $sheet->setCellValue('F' . $row, $item->company_name);
            $sheet->setCellValue('G' . $row, $item->province->nm_provinsi ?? '-');
            $sheet->setCellValue('H' . $row, $item->city->nm_kota ?? '-');
            $sheet->setCellValue('I' . $row, $item->status_customer);

            // Menambahkan border pada data
            $sheet->getStyle('A4:I' . $row)->applyFromArray([
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => ['argb' => 'FF000000'],
                    ],
                ],
            ]);

            $row++;
            $no++;
        }

        // Simpan file ke dalam memori
        $writer = new Xlsx($spreadsheet);
        $fileName = 'Laporan Customer.xlsx';
        $temp_file = tempnam(sys_get_temp_dir(), $fileName);

        $writer->save($temp_file);

        return Response::download($temp_file, $fileName)->deleteFileAfterSend(true);
    }

    public function reportExcel(Request $request)
    {
        // $customer = customer::with(['city', 'province', 'branch'])->where('is_delete', 'N')->whereBetween('created_date', [$request->start, $request->end])->get();
        if (Auth::user()->id_role != 1) {
            $customer = Customer::with(['city', 'province', 'Branch'])->where('kd_cabang', Auth::user()->branch_code)->where('is_delete', 'N')->whereBetween('created_date', [$request->start, $request->end])->get();
        } else {
            $customer = Customer::with(['city', 'province', 'Branch'])->whereBetween('created_date', [$request->start, $request->end])->where('is_delete', 'N')->get();
        }
        $start = $request->start;
        $end = $request->end;

        return view('customer-management.export-excel', compact('customer', 'start', 'end'));
    }

    public function resetPassword(Request $request)
    {
        $kd_customer = $request->kd_customer;
        $newPassword = 'Jamkrindo123!';
        $hashPassword = Hash::make($newPassword);
        try {
            $customer = Customer::where('is_delete', 'N')->where('kd_customer', $kd_customer)->first();
            $customer->password = $hashPassword;
            $customer->update();
            return response()->json(['status' => 'success'], 200);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'gagal : ' . $th->getMessage()], 200);
        }
    }
}
