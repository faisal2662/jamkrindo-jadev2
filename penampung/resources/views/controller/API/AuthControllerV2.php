<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Carbon\Carbon;

use DB;
use Mail;
use Validator;
use Exception;

use App\Models\API\OTP;
use App\Models\API\Pegawai;
use App\Models\API\PegawaiToken;

class AuthControllerV2 extends Controller
{
    public function signIn(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npp_pegawai' => 'required',
            'password_pegawai' => 'required',
            'token_device' => 'required',
            'otp_code' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $employee = Pegawai::with([
                'headOfficeSection',
                'regionalOfficeSection',
                'branchOfficeSection',
                'headOffice',
                'regionalOffice',
                'branchOffice',
                'notifications' => function ($query) {
                    $query->orderBy('id_notifikasi', 'DESC');
                },
                'position'
            ])
            ->has('position')
            ->where([
                'employee_id' => $request->npp_pegawai,
                'status_pegawai' => 'Aktif',
                'delete_pegawai' => 'N'
            ])
            ->first();

        if ($employee == null) {
            return response()->json([
                'message' => 'Pegawai tidak terdaftar.'
            ], 404);
        }

        if ($employee->password != md5($request->password_pegawai)) {
            return response()->json([
                'message' => 'Password yang Anda masukkan salah.'
            ], 404);
        }

        if (is_null($request->otp_code)) {
            $this->generateOTP($employee->id_pegawai);
            return response()->json([
                'id_pegawai' => $employee->id_pegawai,
                'email' => $this->emailCensorship($employee->email)
            ]);
        } else {
            if (!env('INJECT_OTP', false)) {
                if (!$this->verifyOTP($employee->id_pegawai, $request->otp_code)) {
                    return response()->json([
                        'message' => 'OTP not valid.'
                    ], 400);
                }
            }
            
            $token = bcrypt($employee->id_pegawai.'-'.microtime());

            $employeeToken = PegawaiToken::where([
                    'id_pegawai' => $employee->id_pegawai,
                    'token_device' => $request->token_device,
                    'delete_pegawai_token' => 'N'
                ])
                ->first();

            DB::table('tb_log_pegawai')->insert([
                'id_pegawai' => $employee->id_pegawai,
                'tgl_log_pegawai' => date('Y-m-d H:i:s'),
            ]);

            if ($employeeToken == null) {
                PegawaiToken::create([
                    'id_pegawai' => $employee->id_pegawai,
                    'token' => $token,
                    'token_device' => $request->token_device,
                    'ip_address' => $this->getClientIP(),
                    'tgl_terakhir_aktif' => date('Y-m-d H:i:s'),
                    'tgl_pegawai_token' => date('Y-m-d H:i:s')
                ]);
            } else {
                $employeeToken->update([
                    'token' => $token,
                    'ip_address' => $this->getClientIP(),
                    'tgl_terakhir_aktif' => date('Y-m-d H:i:s')
                ]);
            }

            return response()->json([
                'employee' => $employee,
                'token' => $token
            ]);
        }
    }  

    public function signInWithSunfish(Request $request, $url = null)
    {
        $validator = Validator::make($request->all(), [
            'npp_pegawai' => 'required',
            'password_pegawai' => 'required',
            'token_device' => 'required',
            'otp_code' => 'nullable|string',
            'employee_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        if (is_null($request->otp_code)) {
            $employee = Pegawai::has('position')
                ->where([
                    'employee_id' => $request->npp_pegawai,
                    // 'status_pegawai' => 'Aktif',
                    'delete_pegawai' => 'N'
                ])
                ->first();

            if (is_null($employee)) {
                return response()->json([
                    'message' => 'Pegawai tidak terdaftar. Silahkan hubungi Admin.'
                ], 400);
            }

            $data = null;
            try {
                $data = SunfishController::loginUser(
                    $request->npp_pegawai,
                    $request->password_pegawai,
                    $url
                );
            } catch (Exception $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 400);
            }

            // $employeeId = $data->DATA->USER->EMP_ID ?? null;

            // $employee = Pegawai::has('position')
            //     ->where([
            //         'employee_id' => $employeeId,
            //         'status_pegawai' => 'Aktif',
            //         'delete_pegawai' => 'N'
            //     ])
            //     ->first();

            $this->generateOTP($employee->id_pegawai);
            
            return response()->json([
                'id_pegawai' => $employee->id_pegawai,
                'email' => $this->emailCensorship($employee->email)
            ]);
        } else {
            $employee = Pegawai::with([
                    'headOfficeSection',
                    'regionalOfficeSection',
                    'branchOfficeSection',
                    'headOffice',
                    'regionalOffice',
                    'branchOffice',
                    'notifications' => function ($query) {
                        $query->orderBy('id_notifikasi', 'DESC');
                    },
                    'position'
                ])
                ->has('position')
                ->where([
                    'employee_id' => $request->employee_id,
                    'status_pegawai' => 'Aktif',
                    'delete_pegawai' => 'N'
                ])
                ->first();
            
            if (!env('INJECT_OTP', false)) {
                if (!$this->verifyOTP($employee->id_pegawai, $request->otp_code)) {
                    return response()->json([
                        'message' => 'OTP not valid.'
                    ], 400);
                }
            }
            
            $token = bcrypt($employee->id_pegawai.'-'.microtime());

            $employeeToken = PegawaiToken::where([
                    'id_pegawai' => $employee->id_pegawai,
                    'token_device' => $request->token_device,
                    'delete_pegawai_token' => 'N'
                ])
                ->first();

            DB::table('tb_log_pegawai')->insert([
                'id_pegawai' => $employee->id_pegawai,
                'tgl_log_pegawai' => date('Y-m-d H:i:s'),
            ]);

            if ($employeeToken == null) {
                PegawaiToken::create([
                    'id_pegawai' => $employee->id_pegawai,
                    'token' => $token,
                    'token_device' => $request->token_device,
                    'ip_address' => $this->getClientIP(),
                    'tgl_terakhir_aktif' => date('Y-m-d H:i:s'),
                    'tgl_pegawai_token' => date('Y-m-d H:i:s')
                ]);
            } else {
                $employeeToken->update([
                    'token' => $token,
                    'ip_address' => $this->getClientIP(),
                    'tgl_terakhir_aktif' => date('Y-m-d H:i:s')
                ]);
            }

            return response()->json([
                'employee' => $employee,
                'token' => $token
            ]);
        }
    }

    public function signInDataOn(Request $request)
    {
        return $this->signInWithSunfish($request, 'https://sf7dev-pro.dataon.com/sfpro');
    }

    public function signInJamkrindo(Request $request)
    {
        return $this->signInWithSunfish($request, 'https://hris-pro.jamkrindo.co.id/sf7');
    }

    public function signOut(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $employeeToken = PegawaiToken::where([
                'token' => $request->token,
                'delete_pegawai_token' => 'N'
            ])
            ->first();

        if ($employeeToken == null) {
            return response()->json([
                'message' => 'Token tidak terdaftar.'
            ], 404);
        }

        $employeeToken->update([
            'delete_pegawai_token' => 'Y'
        ]);

        return response()->json([
            'message' => 'OK'
        ]);
    }

    public function me(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $employeeToken = PegawaiToken::with([
                'employee.headOfficeSection',
                'employee.regionalOfficeSection',
                'employee.branchOfficeSection',
                'employee.headOffice',
                'employee.regionalOffice',
                'employee.branchOffice',
                'employee.notifications' => function ($query) {
                    $query->orderBy('id_notifikasi', 'DESC');
                },
                'employee.position',
            ])
            ->where([
                'token' => $request->token,
                'delete_pegawai_token' => 'N'
            ])
            ->first();

        if ($employeeToken == null) {
            return response()->json([
                'message' => 'Token tidak terdaftar.'
            ], 404);
        }

        $employeeToken->update([
            'ip_address' => $this->getClientIP(),
            'tgl_terakhir_aktif' => date('Y-m-d H:i:s')
        ]);

        return $employeeToken->employee;
    }

    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'npp_pegawai' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->first(),
            ], 422);
        }

        $employee = Pegawai::where([
                'npp_pegawai' => $request->npp_pegawai
            ])
            ->first();

        if ($employee == null) {
            return response()->json([
                'message' => 'Pegawai tidak terdaftar.'
            ], 404);
        }

        if (env('MAIL_ENABLE', false)) {
            Mail::send('masuk.email', ['id' => $employee->id_pegawai], function ($message) use ($employee) {
                $message->to($employee->email)
                        ->subject('Lupa Password')
                        ->from(env('MAIL_FROM_ADDRESS'), 'Helpdesk - Jamkrindo');
            });
        }

        return response()->json([
            'message' => 'Silahkan cek email Anda.'
        ]);
    }

    public function getClientIP() {
        if (getenv('HTTP_CLIENT_IP')) return getenv('HTTP_CLIENT_IP');
        if (getenv('HTTP_X_FORWARDED_FOR')) return getenv('HTTP_X_FORWARDED_FOR');
        if (getenv('HTTP_X_FORWARDED')) return getenv('HTTP_X_FORWARDED');
        if (getenv('HTTP_FORWARDED_FOR')) return getenv('HTTP_FORWARDED_FOR');
        if (getenv('HTTP_FORWARDED')) return getenv('HTTP_FORWARDED');
        if (getenv('REMOTE_ADDR')) return getenv('REMOTE_ADDR');
        return null;
    }

    public function generateOTP($userId) {
        $otpCode = rand(0, 999999);
        $otpCode = str_pad($otpCode, 6, '0', STR_PAD_LEFT);
        $employee= Pegawai::where('id_pegawai', $userId)->first();

        OTP::create([
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'created_by' => $employee->employee_name,
            'expires_at' => Carbon::now()->addMinutes(30),
        ]);

        if (env('MAIL_ENABLE', false)) {
            Mail::send('login.email_otp', ['pegawai' => $employee, 'otpCode' => $otpCode], function ($message) use ($employee) {
                $emails = explode(',', $employee->email);
                foreach ($emails as $email) {
                    $message->to($email)
                        ->subject('Helpdesk Kode Masuk')
                        ->from(env('MAIL_FROM_ADDRESS'), 'Helpdesk - Jamkrindo');
                }
            });
        }
    }

    public function verifyOTP($userId, $otpCode)
    {
        $otp = OTP::where('user_id', $userId)
            ->where('otp_code', $otpCode)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        return !is_null($otp);
    }

    public function emailCensorship($email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            list($username, $domain) = explode('@', $email);
            $usernameLength = strlen($username);
            if ($usernameLength > 2) {
                $username = $username[0] . str_repeat('*', $usernameLength - 2) . $username[$usernameLength - 1];
            }
            return $username . '@' . $domain;
        } else {
            return $email;
        }
    }    
}
