<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\City;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Province;
use App\Models\Regional;
use App\Models\OtpCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Agent\Agent;


class LoginCustomerController extends Controller
{
    //
    public function index()
    {
        return view('auth.login-customer');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email_customer' => ['required']
            
        ]);
        $customer = Customer::where('email_customer', $request->email_customer)->first();
        if (is_null($customer)) {
            return back()->withErrors([
                'email_customer' => 'email customer tidak terdaftar',
            ])->with('error', 'Login failed! kamu tidak terdaftar di database');;
        }
        if ($customer->is_delete == "Y") {
            return back()->withErrors([
                'email_customer' => 'email customer tidak terdaftar',
            ])->with('error', 'Login failed! kamu tidak terdaftar');
        }

        $customer = Customer::where('email_customer', $credentials)->where('is_delete', 'N')->where('status_customer', 'Active')->first();
        $pass = Hash::check($request->password, $customer->password,);
        // dd($pass);
        if ($request  && $pass) {

            $ids = $this->generateOtp($customer->kd_customer);
            $id = $ids->id_otps;

            return redirect()->route('login.confirm-customer', [$id, encrypt($customer->kd_customer)]);
            // return redirect()->intended('/customer/dashboard');
        }

        return back()->withErrors([
            'email_customer' => 'email customer tidak terdaftar',
        ])->with('error', 'Login failed! Please check your Email and password.');;
    }

    public function confirm($id, $kd_customer)
    {
        $id_user = decrypt($kd_customer);
        $time = OtpCustomer::where('id_otps', $id)->first()->expires_at;
        $customer = Customer::where('kd_customer', $id_user)->first();
        $emailAddress = $customer->email_customer;

        return view('auth.confirm-otp-customer', compact('emailAddress', 'customer', 'time'));
    }
    private function decryptssl($str, $key)
    {
        $str = base64_decode($str);
        $key = base64_decode($key);
        $decrypted = openssl_decrypt($str, 'AES-128-ECB', $key,  OPENSSL_RAW_DATA);
        return $decrypted;
    }
    function generateOtp($customerId)
    {

        $smtp = DB::table('m_smtp')->first();
        // Menghasilkan kode OTP acak antara 0 dan 999999
        $otpCode = rand(0, 999999);

        // Memastikan kode OTP selalu 6 digit
        $otpCode = str_pad($otpCode, 6, '0', STR_PAD_LEFT);

        // Simpan OTP ke database
        $customer = Customer::where('kd_customer', $customerId)->first();
        $expired = Carbon::now()->addMinutes(30);
        $otp =   OtpCustomer::create([
            'customer_id' => $customerId,
            'otp_code' => $otpCode,
            'created_by' => $customer->nama_customer,
            'expires_at' => $expired,
        ]);


        // $emailAddress   = 'amimfaisal2@gmail.com,faisal.drift.3@gmail.com';

        $emailAddress   = $customer->email_customer;

        // $emailAddress   = '';
        $subject = 'JADE Kode Masuk';
        $name = $customer->nama_customer;
        $mail = new PHPMailer(true);                              // Passing true enables exceptions
        try {
            // Pengaturan Server
            //    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $smtp->host_smtp;                  // Specify main and backup SMTP servers
            $mail->SMTPAuth = true;                               // Enable SMTP authentication
            $mail->Username = $smtp->username_smtp;                 // SMTP username
            $mail->Password = $smtp->password_smtp;                           // SMTP password
            $mail->SMTPSecure = $smtp->enkripsi_smtp;                            // Enable TLS encryption, ssl also accepted
            $mail->Port = $smtp->port_smtp;                                    // TCP port to connect to
            // $mail->SMTPDebug = 2;
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Siapa yang mengirim email
            $mail->setFrom($smtp->alamat_email_smtp, 'JADE - Jamkrindo');
            $emails = explode(',', $emailAddress);

            // Tambahkan setiap email ke penerima
            foreach ($emails as $email) {
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $mail->addAddress(trim($email));
                }
                // $mail->addAddress(trim($email)); // trim() untuk menghapus spasi ekstra
            }

            // Siapa yang akan menerima email
            // $mail->addAddress($emailAddress, $name);     // Add a recipient

            // Embedded Image
            $mail->addEmbeddedImage(base_path('../assets/img/logo-jamkrindo.png'), 'logo_cid');

            //Content
            $mail->isHTML(true);                                  // Set email format to HTML
            $mail->Subject = $subject;

            $mail->Body    = view('auth.mail.email_otp', compact('customer', 'otpCode'));

            $mail->send();
            // echo 'Message  sent.';
        } catch (Exception $e) {
            // echo 'Message could not be sent.';
            //echo 'Mailer Error: ' . $mail->ErrorInfo;
            // echo $e;
            // die;
        }
        // Kirim OTP ke pengguna (via SMS atau email)
        // Contoh: Mail::to($user->email)->send(new OtpMail($otpCode));
        return $otp;
    }
    function verifyOtp(Request $request)
    {
        $agent = new Agent();
        $validator = Validator::make($request->all(), [
            'otp_code' => 'required', // Validasi untuk memastikan 6 digit
        ]);

        if ($validator->fails()) {
            return back()->with('alert', 'danger_kode wajib diisi');
            // return response()->json(['error' => $validator->errors()], 422);
        }
        $id = decrypt($request->id_user);
        $otp = OtpCustomer::where('customer_id', $id)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        $customer = Customer::where('kd_customer', $id)->first();
        if ($otp) {
            Auth::guard('customer')->login($customer);
            $log = DB::table('t_log_customer')->insert(['kd_customer' => $customer->kd_customer, 'keterangan' => 'Login', 'created_by' => 'automatic', 'created_date' => date('Y-m-d H:i:s'),
            'browser_version'   => $agent->version($agent->browser()),
            'browser'           => $agent->browser(),
            'ip_address'        => request()->ip(),
            'platform'          => $agent->platform(),
            'platform_version'  => $agent->version($agent->platform()),
            'device'            => $agent->device()]);
            $request->session()->regenerate();

            return redirect()->route('dashboard-customer');
            // OTP valid, lanjutkan login
        } else {
            return redirect()->route('login-customer')->with('alert', 'danger_Kode OTP tidak valid atau kadaluarsa');
            // OTP tidak valid atau kedaluwarsa
        }
    }

    public function registrasi()
    {
        $province = Province::where('is_delete', 'N')->get();
        $cities = City::where('is_delete', 'N')->get();
        $wilayah = Regional::where('is_delete', 'N')->get();
        return view('auth.registrasi-customer', compact('province', 'cities', 'wilayah'));
    }

    public function registrasiStore(Request $request)
    {
        // dd($request);

        $request->validate(
            [
                'nm_customer' => 'required',
                'userid_customer' => 'required|unique:m_customer',
                'email_customer' => 'required|unique:m_customer',
                'password' => 'required|confirmed|min:8'
            ],
            [
                'userid_customer.unique' => 'user id sudah ada',
                'email.unique' => 'email sudah terdaftar',
                'password.confirmed' => 'password tidak sama',
                'password.min' => 'password kurang dari 8 karakter'
            ]

        );

        $password = Hash::make($request->password);
        try {
            $customer = new Customer;
            $customer->nama_customer = $request->nm_customer;
            $customer->hp_customer = $request->no_hp;
            $customer->email_customer = $request->email_customer;
            $customer->userid_customer = $request->userid_customer;
            $customer->password = $password;
            $customer->kd_cabang = $request->cabang;
            $customer->status_customer = "Active";

            $customer->kd_referral_customer = $request->kode_referral;
            $customer->company_name = $request->nm_perusahaan;
            $customer->company_province = $request->provinsi_usaha;
            $customer->company_city = $request->kota_usaha;
            $customer->created_by = "Customer";
            $customer->save();

            return back()->with('success', 'Berhasil terdaftar silahkan ');

            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return back()->with('error', 'Simpan data gagal : ' . $e->getMessage());
            // return response()->json(['status' => $e->getMessage()], 500);
        }
    }
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }

    public function updateCabang(Request $request)
    {
        $request->validate([
            'cabang' => 'required',
        ]);

        try {
            //code...
            $customer =  Customer::where("kd_customer", $request->customer)->first();
            $customer->kd_cabang = $request->cabang;
            $customer->updated_by = Auth::user()->nm_customer;
            $customer->update();
            return redirect()->route('dashboard-customer');
        } catch (\Throwable $th) {
            //throw $th;
            return back()->with('error', 'Cabang gagal diperbaharui');
        }
    }
}
