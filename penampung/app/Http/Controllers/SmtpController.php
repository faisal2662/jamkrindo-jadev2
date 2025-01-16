<?php

namespace App\Http\Controllers;

use App\Models\Smtp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SmtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $smtp = Smtp::first();
        return view('smtp.index', compact('smtp'));
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'email_smtp' => 'required',
            'host_smtp' => 'required',
            'port_smtp' => 'required',
            'username_smtp' => 'required',
            'password_smtp' => 'required',
            'enkripsi_smtp' => 'required',
            'alamat_email_smtp' => 'required',
            'nama_email_smtp' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        try {
            $smtp = Smtp::where('id_smtp', $request->id_smtp)->first();
            $dataLama = $smtp;

            $dataRequest =  $request->except(['_token']);

            $dataOld = json_decode(json_encode($dataLama), true);
            $dataNew = json_decode(json_encode($dataRequest), true);
            $baru =  array_diff_assoc($dataNew, $dataOld); // Nilai di $dataNew yang tidak ada di $dataOld
            $lama =  array_diff_assoc($dataOld, $dataNew); // Nilai di $dataOld yang tidak ada di $dataNew

            $smtp->email_smtp = $request->email_smtp;
            $smtp->host_smtp = $request->host_smtp;
            $smtp->port_smtp = $request->port_smtp;
            $smtp->username_smtp = $request->username_smtp;
            $smtp->password_smtp = $request->password_smtp;
            $smtp->enkripsi_smtp = $request->enkripsi_smtp;
            $smtp->alamat_email_smtp = $request->alamat_email_smtp;
            $smtp->nama_email_smtp = $request->nama_email_smtp;
            $smtp->update();
            $this->logAuditTrail('update', $smtp, $lama, $baru);

            return back()->with('success', 'Data berhasil diubah');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Data gagal diubah');
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
    }
}
