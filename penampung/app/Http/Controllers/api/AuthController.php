<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;
use Hash;
use Mail;
use DB;

use App\Models\Customer;
use App\Models\CustomerToken;
use App\Models\Business;
use App\Models\City;
use App\Models\Branch;

use App\Mail\ResetPasswordOTPSending;

class AuthController extends Controller
{
    public function genpass()
    {
        $em = Customer::where('id_karyawan', '!=', '1')->get();

        foreach ($em as $employee) {
            User::where('id', $employee->id)->update([
                'password' => Hash::make('123456')
            ]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = Customer::where('email_customer', $request->email)->first();

        if (empty($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak terdaftar'
            ], 400);
        } else {
            if (!password_verify($request->password, $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Password salah'
                ], 400);
            } else {
                $token = app('hash')->make($request->email . '-' . microtime());
                CustomerToken::insert([
                    'customer_id' => $user->kd_customer,
                    'token' => $token,
                    'device_token' => $request->device_token ?? null,
                    'ip_address' => $this->getClientIP(),
                    'last_active_at' => date('Y-m-d H:i:s'),
                    'created_at' => date('Y-m-d H:i:s')
                ]);
                return response()->json([
                    'user' => $user,
                    'token' => $token
                ], 200);
            }
        }
    }

    public function registration(Request $request)
    {
        $credentials = $request->validate([
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'username' => 'required',
            'password' => 'required|string',
            'referral_code' => 'nullable',
            'kd_kota' => 'required',
        ]);

        $city = City::with('Provinsi')->findOrFail($request->kd_kota);

        $branch = Branch::whereHas('Wilayah', function ($query) use ($city) {
                $query->where([
                    'kd_kota' => $city->kd_kota,
                    'kd_provinsi' => $city->kd_provinsi,
                    'is_delete' => 'N'
                ]);
            })
            ->where('is_delete', 'N')
            ->first();

        // if (is_null($branch)) {
        //     return response()->json([
        //         'status' => 'error',
        //         'message' => 'Cabang tidak ditemukan'
        //     ], 400);
        // }

        $password = Hash::make($request->password);

        try {
            $customer = Customer::create([
                'nama_customer' => $request->name,
                'kd_cabang' => $branch->kd_cabang ?? -1,
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
                'kota_usaha' => $city->nm_kota,
                'provinsi_usaha' => $city->province->nm_provinsi,
                'created_by' => $customer->nama_customer,
            ]);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama_customer' => 'nullable|string',
            'hp_customer' => 'nullable|string',
            'email_customer' => 'nullable|email',
            'foto_customer' => 'nullable|image',
            'password' => 'nullable|password',
        ]);

        $customer = Auth::user();

        $data = [
            'nama_customer' => $request->nama_customer ?? $customer->nama_customer,
            'hp_customer' => $request->hp_customer ?? $customer->hp_customer,
            'email_customer' => $request->email_customer ?? $customer->email_customer,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto_customer')) {
            $rand = random_int(1000, 9999);
            $filename = uniqid() . '.' . $request->foto_customer->getClientOriginalExtension();
            $file  = $request->file('foto_customer');
            $file->move(base_path('../assets/img/customer'),  $filename);
            $data['foto_customer'] = $filename;
        }

        try {
            Customer::where('kd_customer', $customer->kd_customer)->update($data);
            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function getProfile()
    {
        $profile = Auth::user();
        if (!preg_match('/https?:\/\//', $profile->foto_customer)) {
            $profile->foto_customer = url('assets/img/customer/'.$profile->foto_customer);
        }

        return response()->json([
            'data' => $profile
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email_customer' => 'nullable|email',
        ]);

        $user = Customer::where('email_customer', $request->email_customer)->first();
        
        if (is_null($user)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email tidak terdaftar'
            ], 400);
        }

        $otp = random_int(1000, 9999);
        $token = app('hash')->make($request->email_customer . '-' . microtime());

        Mail::mailer('smtp')
            ->to($request->email_customer)
            ->send(new ResetPasswordOTPSending($otp));

        DB::table('m_reset_password')->insert([
            'email' => $request->email_customer,
            'verify_otp_token' => $token,
            'otp' => $otp,
            'created_at' => date('Y-m-d H:i:s')
        ]);

        return response()->json([
            'data' => [
                'verify_otp_token' => $token
            ]
        ]);
    }

    public function verifyOTPForgotPassword(Request $request)
    {
        $request->validate([
            'email_customer' => 'nullable|email',
            'otp' => 'required|numeric',
            'verify_otp_token' => 'required|string',
        ]);

        $resetPassword = DB::table('m_reset_password')
            ->where([
                'email' => $request->email_customer,
                'otp' => $request->otp,
                'verify_otp_token' => $request->verify_otp_token
            ])
            ->first();

        if (is_null($resetPassword)) {
            return response()->json([
                'status' => 'error',
                'message' => 'OTP tidak valid'
            ], 400);
        } else {
            $token = app('hash')->make($request->email_customer . '-' . microtime());
            DB::table('m_reset_password')
                ->where('id', $resetPassword->id)
                ->update([
                    'reset_password_token' => $token
                ]);
            return response()->json([
                'data' => [
                    'reset_password_token' => $token
                ]
            ]);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'reset_password_token' => 'required|string',
            'password' => 'required|string',
        ]);

        $resetPassword = DB::table('m_reset_password')
            ->where('reset_password_token', $request->reset_password_token)
            ->first();

        if (is_null($resetPassword)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token tidak valid'
            ], 400);
        } else {
            $user = Customer::where('email_customer', $resetPassword->email)->first();
            $password = Hash::make($request->password);

            Customer::where('kd_customer', $user->kd_customer)
                ->update([
                    'password' => $password
                ]);

            DB::table('m_reset_password')
                ->where('id', $resetPassword->id)
                ->delete();

            return response()->json([
                'status' => 'success'
            ]);
        }
    }
    
    public function logout(Request $request)
    {
        CustomerToken::where([
                'customer_id' => Auth::id(),
                'token' => $request->get('token')
            ])
            ->delete();
        return response()->json([
            'status' => 'success'
        ]);
    }

    function getClientIP()
    {
        if (getenv('HTTP_CLIENT_IP')) return  getenv('HTTP_CLIENT_IP');
        if (getenv('HTTP_X_FORWARDED_FOR')) return getenv('HTTP_X_FORWARDED_FOR');
        if (getenv('HTTP_X_FORWARDED')) return getenv('HTTP_X_FORWARDED');
        if (getenv('HTTP_FORWARDED_FOR')) return getenv('HTTP_FORWARDED_FOR');
        if (getenv('HTTP_FORWARDED')) return getenv('HTTP_FORWARDED');
        if (getenv('REMOTE_ADDR')) return getenv('REMOTE_ADDR');
        return null;
    }
}
