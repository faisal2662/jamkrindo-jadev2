<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class BusinessController extends Controller
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

    public function getData($id)
    {
        $business = Business::with(['kota', 'provinsi'])->where('is_delete', 'N')->where('kd_customer', $id)->get();
        // $business = 'df';
        // return response()->json($business);
        $no = 1;


        foreach ($business as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;

            $act->no = $no++;

            $act->action =   "<button class='btn btn-sm fw-bold' onclick='businessEdit(\"" . $act->kd_usaha . "\")' > <i class='bi bi-pencil-square'></i></button><button class='btn btn-sm fw-bold' onclick='businessDelete(\"" . $act->kd_usaha . "\")'><i class='bi bi-trash' ></i></button>";
        }
        return datatables::of($business)->escapecolumns([])->make(true);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            $business = new Business;
            $business->nama_usaha = $request->nama_usaha;
            $business->kd_customer = $request->kd_customer;
            $business->npwp_usaha = $request->npwp_usaha;
            $business->kota_usaha = $request->kota_usaha;
            $business->provinsi_usaha = $request->provinsi_usaha;
            $business->created_by = Auth::user()->nm_user;
            $business->save();

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
        //
        $business = Business::where('kd_usaha', $id)->first();
        return response()->json($business);
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
            $business =  Business::where('kd_usaha', $id)->first();
            $business->nama_usaha = $request->nama_usaha;
            $business->kd_customer = $request->kd_customer;
            $business->npwp_usaha = $request->npwp_usaha;
            $business->kota_usaha = $request->kota_usaha;
            $business->provinsi_usaha = $request->provinsi_usaha;
            $business->updated_by = Auth::user()->nm_user;
            $business->update();

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
        //
        $date = Carbon::now();
        try {
            $business =  Business::where('kd_usaha', $id)->first();
            $business->deleted_by = Auth::user()->nm_user;
            $business->deleted_date = $date;
            $business->is_delete = 'Y';
            $business->update();

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}