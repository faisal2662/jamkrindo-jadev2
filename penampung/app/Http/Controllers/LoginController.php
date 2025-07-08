<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Otp;
use App\Models\User;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Validator;

class LoginController extends Controller
{
    //
    public function index()
    {
        return view('auth.login');
    }




    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $user = User::where('npp_user', $request->npp_user)->first();
        if (is_null($user)) {

            return back()->withErrors([
                'npp_user' => 'NPP tidak terdaftar',
            ])->with('error', 'Login failed! Please check your NPP and password. w');;
        }
        if ($user->is_delete == "Y") {
            return back()->withErrors([
                'npp_user' => 'NPP tidak terdaftar',
            ])->with('error', 'Login failed! Please check your NPP and password .');;
        }
        $credentials = $request->validate([
            'npp_user' => ['required'],
        ]);

        $user = User::where('npp_user', $credentials['npp_user'])->where('is_delete', 'N')->first();
        
        if ($user->status_data != 'local') {
            $ids = $this->generateOtp($user->kd_user);
            $id = $ids->id_otps;
           

            return redirect()->route('login.confirm', [$id, encrypt($user->kd_user)]);
        }
        $pass = Hash::check($request->password, $user->password,);
        if ($user && $pass) {
            $ids = $this->generateOtp($user->kd_user);
            // return dd($ids);
            $id = $ids->id_otps;

            return redirect()->route('login.confirm', [$id, encrypt($user->kd_user)]);
        } else {
            return back()->withErrors([
                'npp_user' => 'NPP tidak terdaftar',
            ])->with('error', 'Login failed! Please check your NPP and password..');
        }


        return back()->withErrors([
            'npp_user' => 'NPP salah / tidak terdaftar',
        ])->with('error', 'Login failed! Please check your NPP and password.');;
    }

    public function confirm($id, $kd_user)
    {
        $id_user = decrypt($kd_user);
        
        $otp = Otp::where('id_otps', $id)->first();
        $time = $otp->expires_at;
        $user = User::where('kd_user', $id_user)->first();
        if ($user->status_data == 'local') {
            $emailAddress = $user->email;
        } else {
            $emailAddress   = $this->decryptssl($user->email, 'P/zqOYfEDWHmQ9/g8PrApw==');
        }

        return view('auth.confirm-otp', compact('emailAddress', 'otp', 'user', 'time'));
    }
    private function decryptssl($str, $key)
    {
        $str = base64_decode($str);
        $key = base64_decode($key);
        $decrypted = openssl_decrypt($str, 'AES-128-ECB', $key,  OPENSSL_RAW_DATA);
        return $decrypted;
    }
    function generateOtp($userId)
    {

        $smtp = DB::table('m_smtp')->first();
        // Menghasilkan kode OTP acak antara 0 dan 999999
        $otpCode = rand(0, 999999);

        // Memastikan kode OTP selalu 6 digit
        $otpCode = str_pad($otpCode, 6, '0', STR_PAD_LEFT);

        // Simpan OTP ke database
        $user = User::where('kd_user', $userId)->first();
        $expired = Carbon::now()->addMinutes(30)->toDateTimeString();
        // $expired = '2025-05-15 13:19:00';
        // return dd($expired);
        $otp =   Otp::create([
            'user_id' => $userId,
            'otp_code' => $otpCode,
            'created_by' => $user->kd_user,
            'expires_at' => $expired,
        ]);
        // return dd($otp); 


        // $emailAddress   = 'amimfaisal2@gmail.com,faisal.drift.3@gmail.com';
        if ($user->status_data == 'local') {
            $emailAddress   = $user->email;
        } else {
            $emailAddress   = $this->decryptssl($user->email, 'P/zqOYfEDWHmQ9/g8PrApw==');
        }
        // $emailAddress   = '';
        $subject = 'JADE Kode Masuk';
        $name = $user->nm_user;
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

            $mail->Body    = view('auth.mail.email_otp', compact('user', 'otpCode'));

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
            return back()->with('alert', 'kode wajib diisi');
            // return response()->json(['error' => $validator->errors()], 422);
        }
        $id = decrypt($request->id_user);
        $id_otp = decrypt($request->id_otp);
        $otp = Otp::where('id_otps', $id_otp)
            ->where('otp_code', $request->otp_code)
            ->where('expires_at', '>', Carbon::now()) 
            
            ->first();
            $user = User::where('kd_user', $id)->first();
     
        if ($otp) { 
            // if (true) {
           
            Auth::guard('web')->login($user);
            $log = DB::table('t_log_user')->insert([
                'kd_user' => $user->kd_user,
                'keterangan' => 'Login', 
                'created_by' => 'automatic',
                'created_date' => date('Y-m-d H:i:s'), 
                'browser_version'   => $agent->version($agent->browser()),
                'browser'           => $agent->browser(),
                'ip_address'        => request()->ip(),
                'platform'          => $agent->platform(),
                'platform_version'  => $agent->version($agent->platform()),
                'device'            => $agent->device()
            ]);

            $request->session()->regenerate();

            return redirect()->route('dashboard');
            // OTP valid, lanjutkan login
        } else {
            return back()->with('alert', 'OTP is Invalid or Expired');
            // OTP tidak valid atau kedaluwarsa
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('auth.forgot_password');
    }
    public function cekData(Request $request)
    {
        $user = User::where('npp_user', $request->npp)->whereNotNull('status_data')->first();
        if (is_null($user)) {
            return response()->json(['status' => 'error', 'message' => 'NPP / Password Salah']);
        }
        if ($user->is_delete == "Y") {
            return response()->json(['status' => 'error', 'message' => 'NPP tidak terdaftar']);
        }
        return response()->json(['status' => 'success', 'message' => 'Email terdaftar']);
    }

    public function forgotPasswordSend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with(['status' => __($status)])
            : back()->withErrors(['email' => __($status)]);
    }

    public function resetPassword(Request $request, $token, $email)
    {
        return view('auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);


        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
