<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegistrationController extends Controller
{
    public function registration(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|string',
            'referral_code' => 'nullable',
        ]);

        $password = Hash::make($request->password);

        try {
            $customer = Customer::create([
                'nama_customer' => $request->name,
                'hp_customer' => $request->phone,
                'email_customer' => $request->email,
                'userid_customer' => $request->username,
                'password' => $password,
                'kd_referral_customer' => $request->referral_code,
            ]);

            $business = Business::create([
                'nama_usaha' => $request->business_name,
                'kd_customer' => $customer->kd_customer,
                'npwp_usaha' => $request->npwp,
                'kota_usaha' => $request->city,
                'provinsi_usaha' => $request->province,
                'created_by' => $customer->nama_customer,
            ]);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }


    //
    public function fcm(Request $request)
    {
        Karyawan::where('id_karyawan', Auth::user()->karyawan->id_karyawan)->update([
            'fcm_token' => $request->fcm
        ]);
    }

    //
    public function remove_fcm(Request $request)
    {
        Karyawan::where('id_karyawan', Auth::user()->karyawan->id_karyawan)->update([
            'fcm_token' => null
        ]);
        Auth::logout();
    }


    //
    public function profile(Request $request)
    {
        $user = Auth::user()->karyawan;
        $user->nama_depan = $user->nama_depan == null ? '' : $user->nama_depan;
        $user->nama_belakang = $user->nama_belakang == null ? '' : $user->nama_belakang;

        $foto_profil = $user->foto_pas == "default.jpg" || $user->foto_pas == null ? "default" : asset("public/images/pasfoto/" . $user->foto_pas);
        $foto_ktp = $user->foto_ktp == "default.jpg" || $user->foto_ktp == null ? "default" : asset("public/images/fotoktp/" . $user->foto_ktp);
        $atasan = Karyawan::select('nama_depan', 'nama_belakang')->where('id_karyawan', $user->id_atasan_langsung)->first();

        return response()->json(['status' => 'success', 'atasan' => $atasan, 'foto_profil' => $foto_profil, 'foto_ktp' => $foto_ktp, 'data' => $user]);
    }

    //
    public function update_profile_picture(Request $request)
    {
        $attachment = $request->file('attachment');

        if ($attachment) {
            $attachment->move(public_path('images/pasfoto/'), 'profile_' . Auth::user()->karyawan->id_karyawan . '_' . date('Ymdhis') . $attachment->getClientOriginalExtension());
            Karyawan::where('id_karyawan', Auth::user()->karyawan->id_karyawan)->update(['foto_pas' => 'profile_' . Auth::user()->karyawan->id_karyawan . '_' . date('Ymdhis') . $attachment->getClientOriginalExtension()]);
        }

        return response()->json(['status' => 'success', 'data' => Auth::user()]);
    }

    //
    public function update_ktp(Request $request)
    {
        $attachment = $request->file('attachment');

        if ($attachment) {
            $attachment->move(public_path('images/fotoktp/'), 'ktp_' . date('Ymdhis') . $attachment->getClientOriginalExtension());
            Karyawan::where('id_karyawan', Auth::user()->karyawan->id_karyawan)->update(['foto_ktp' => 'ktp_' . date('Ymdhis') . $attachment->getClientOriginalExtension()]);
        }

        return response()->json(['status' => 'success', 'data' => Auth::user()]);
    }

    //
    public function update_password(Request $request)
    {

        $user = Auth::user();

        if (Hash::check($request->old_pass, $user->password)) {

            User::where('id', $user->id)->update([
                'password' => Hash::make($request->new_pass)
            ]);

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }

        // var_dump($request->all());

        // echo $user->password;

    }

    //
    public function reset_password(Request $request)
    {
        $user = Karyawan::where('no_telp', $request->no_hp)->where('nik', $request->nik)->first();

        if (!empty($user)) {

            User::where('username', $request->nik)->update([
                'password' => Hash::make($request->nik)
            ]);

            return response()->json(['status' => 'success']);
        } else {
            return response()->json(['status' => 'failed']);
        }

        // var_dump($request->all());

        // echo $user->password;

    }

    //
    public function user_list(Request $request)
    {
        return response()->json(User::all());
    }
}
