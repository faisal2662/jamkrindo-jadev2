<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\City;
use App\Models\Role;
use App\Models\User;
use App\Models\Branch;
use App\Models\Province;
use App\Models\Regional;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;



class UserManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Auth::user();
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 2)->first();
        $regions = Regional::where('is_delete', 'N')->get();

        return view('user-management.index', compact('regions', 'role'));
    }

    public function pageApi(Request $request)
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 2)->first();
        $regions = Regional::where('is_delete', 'N')->get();

        return view('user-management.page-api', compact('regions', 'role'));
    }

    public function lastSync()
    {
        $user = DB::table('m_users')->where('is_delete', 'N')->orderBy('updated_date', 'desc')->first();

        $last = carbon::parse($user->created_date)->translatedFormat('l, d F Y H:i');
        return response()->json(['data' => $last, 'status' => 'success'], 200);
    }

    public function getApi(Request $request)
    {
        //  return response()->json($this->fetchAllData());
        //     $result = $this->fetchAllData();
        $filePath = base_path('../data/data_api_dev_sunfish.json');
        // $data_api = null;
        $jsonContent = File::get($filePath);

        // // Mengonversi konten JSON menjadi array (true untuk mengembalikan array, false untuk objek)
        $result = json_decode(
            $jsonContent,
            true
        );


        $kantorCabang = DB::table('m_cabang')->where('is_delete', 'N')->pluck('id_cabang', 'nm_cabang')->toArray();
        $kantorWilayah = DB::table('m_wilayah')->where('is_delete', 'N')->pluck('id_kanwil', 'nm_wilayah')->toArray();
        return $kantorCabang;

        $id_menu = ['1', '3', '4', '19', '20', '21'];

        foreach ($result as $user) {

            try {
                //code...

                $get_user = DB::table('m_users')->where('npp_user', $user['EMPLOYEE_ID'])->first();
                if (!is_null($get_user)) {
                    $user['npp_user'] = $user['EMPLOYEE_ID'];
                    DB::table('m_users')->where('npp_user', $user['EMPLOYEE_ID'])->update($user);
                } else {
                    $user['npp_user'] = $user['EMPLOYEE_ID'];
                    $user['nm_user'] = $user['EMPLOYEE_NAME'];
                    $user['status_user'] = 'Active';
                    $user['nm_perusahaan'] = $user['COMPANY_CODE'];
                    if ($user['BRANCH_NAME'] == 'Kantor Pusat') {
                        $user['id_branch'] = $kantorCabang['Kantor Pusat'];
                        $id_user =  DB::table('m_users')->insertGetId($user);
                        foreach ($id_menu as $menu) {
                            $role = DB::table('t_role')->insert([
                                'id_account' => $id_user,
                                'id_menu' => $menu,
                                'can_access' => 'Y',
                                'can_update' => 'Y',
                                'can_delete' => 'Y',
                            ]);
                        }
                    } else if (array_key_exists($user['BRANCH_NAME'], $kantorCabang)) {
                        $user['id_branch'] = $kantorCabang[$user['BRANCH_NAME']];
                        $user['wilayah_perusahaan'] = DB::table('m_cabang')->where('id_cabang', $user['id_branch'])->first()->kd_wilayah;
                        $id_user =  DB::table('m_users')->insertGetId($user);
                        foreach ($id_menu as $menu) {
                            $role = DB::table('t_role')->insert([
                                'id_account' => $id_user,
                                'id_menu' => $menu,
                                'can_access' => 'Y',
                                'can_update' => 'Y',
                                'can_delete' => 'Y',
                            ]);
                        }
                    } else if (array_key_exists($user['BRANCH_NAME'], $kantorWilayah)) {
                        $user['wilayah_perusahaan'] = $kantorWilayah[$user['BRANCH_NAME']];
                        $id_user = DB::table('m_users')->insertGetId($user);
                        foreach ($id_menu as $menu) {
                            $role = DB::table('t_role')->insert([
                                'id_account' => $get_user,
                                'id_menu' => $menu,
                                'can_access' => 'Y',
                                'can_update' => 'Y',
                                'can_delete' => 'Y',
                            ]);
                        }
                    }
                }
            } catch (\Throwable $th) {
                //throw $th;
                return response()->json(['status' => $th->getMessage()], 500);
            }
            # code...
        }
    }


    public function getLoguser(Request $request)
    {

        $log = DB::table('t_log_user')->join('m_users', 't_log_user.kd_user', 'm_users.kd_user')->where('t_log_user.is_delete', 'N')->where('t_log_user.kd_user', $request->id_user)->select('t_log_user.*', 'm_users.nm_user')->orderBy('t_log_user.created_date', 'desc')->get();

        $no = 1;

        foreach ($log as $data) {
            $data->no = $no++;

            $data->nama_user = $data->nm_user;
            $data->tanggal =  $data->created_date  ?  Carbon::parse($data->created_date)->translatedFormat('l, d F Y') : '-';
        }

        return datatables::of($log)->escapecolumns([])->make(true);
    }
    public function getLog(Request $request)
    {
        $log = DB::table('t_log_user')->join('m_users', 't_log_user.kd_user', 'm_users.kd_user')->where('t_log_user.is_delete', 'N')->where('t_log_user.kd_user', auth()->user()->kd_user)->select('t_log_user.*', 'm_users.nm_user')->orderBy('t_log_user.created_date', 'desc')->get();

        $no = 1;

        foreach ($log as $data) {
            $data->no = $no++;

            $data->nama_user = $data->nm_user;
            $data->tanggal = Carbon::parse($data->created_date)->translatedFormat('l, d F Y');
        }

        return datatables::of($log)->escapecolumns([])->make(true);
    }


    private function fetchData($page)
    {

        $token = $this->login();

        $token = $token['DATA']['JWT_TOKEN'];

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sf7dev-pro.dataon.com/sfpro/?qlid=HrisUser.getEmployee',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
                    "page_number" : "' . $page . '"
                }',
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $token,
                'Cookie: JSESSIONID=1D874707C6E28326AA74FA53FF48D8CE; LANG=en; _BDC=JSESSIONID,LANG'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);
        // $data = $data['DATA'];
        // dd($data);

        curl_close($curl);
        // echo $response;

        return $data;
    }
    // Fungsi untuk mengambil semua data dari setiap halaman
    private function fetchAllData()
    {
        $allData = [];
        $currentPage = 1;
        $perPage = 10;
        $totalPages = 1;

        do {
            // Ambil data dari API
            $response = $this->fetchData($currentPage);

            if (!$response) {
                return false; // Jika ada error, return false
            }

            // Gabungkan data dari halaman saat ini ke allData
            $allData = array_merge($allData, $response['DATA']['DATA']);

            // Hitung total halaman
            $totalPages = ceil($response['DATA']['TOTAL'] / $perPage);

            $currentPage++;
        } while ($currentPage <= $totalPages);

        return $allData;
    }

    private function decryptssl($str, $key)
    {
        $str = base64_decode($str);
        $key = base64_decode($key);
        $decrypted = openssl_decrypt($str, 'AES-128-ECB', $key,  OPENSSL_RAW_DATA);
        return $decrypted;
    }

    private function login()
    {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://sf7dev-pro.dataon.com/sfpro/?ofid=sfSystem.loginUser&originapp=hris_jamkrindo',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => '{
            "USERPWD": "777FF8B018AB23EEE048D13978E0D1FCFF94D326",
            "USERNAME":"jamkrindo",
            "ACCNAME":"jamkrindo",
            "TIMESTAMP": "' . date('Y-m-d H:i:s') . ' +0700"
            }',
            CURLOPT_HTTPHEADER => array(
                'Accept-Language: en-US,en;q=0.9,id;q=0.8',
                'Language: en',
                'Origin: https://workplaze.dataon.com',
                'Referer: https://workplaze.dataon.com/auth',
                'Sec-Fetch-Dest: empty',
                'Sec-Fetch-Mode: cors',
                'User-Agent: Mozilla5.0 (X11; Linux x86_64) AppleWebKit537.36 (KHTML, like Gecko) Chrome125.0.0.0 Safari537.36',
                'sec-ch-ua: "Google Chrome";v="125", "Chromium";v="125", "Not.ABrand";v="24"',
                'sec-ch-ua-mobile: ?0',
                'sec-ch-ua-platform: "Linux"',
                'Content-Type: application/json',
                'Cookie: JSESSIONID=C18D3CB96739FBBB5DD807CBDEB0FA51; LANG=en; _BDC=LANG'
            ),
        ));

        $response = curl_exec($curl);
        $data = json_decode($response, true);

        // dd($data);
        curl_close($curl);
        // echo $response;

        return $data;
    }
    // public function fetchData($page, $token)
    // {
    //     // $url = 'http://172.27.1.52:5252/hris/api/user/01342';
    //     // $url = 'http://172.27.1.52:5252/hris/api/user?pageNumber=' . $page;
    //     $url = 'http://172.27.1.52:5252/hris/api/user?size=10000';

    //     // Inisialisasi cURL
    //     $ch = curl_init($url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Authorization: Bearer ' . $token,
    //         'Content-Type: application/json'
    //     ]);
    //         // Mengatur batas waktu koneksi (dalam detik)
    //         curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

    //         // Mengatur batas waktu eksekusi total (dalam detik)
    //         curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

    //     // Eksekusi cURL
    //     $response = curl_exec($ch);

    //     // Memeriksa error pada cURL
    //     if (curl_errno($ch)) {
    //         return false;
    //     }

    //     curl_close($ch);

    //     // Mengubah JSON menjadi array PHPdd9
    //     $data = json_decode($response,true);

    //     foreach ($data['data'] as $key => $value) {
    //         # code...
    //         $decrypted_address = $this->decryptssl($value['primary_address'],'jP.J#8A6VDy[QH$d' );
    //         $decrypted_birthday = $this->decryptssl($value['birthday'],'jP.J#8A6VDy[QH$d' );
    //         $decrypted_gmail = $this->decryptssl($value['email'],'jP.J#8A6VDy[QH$d' );
    //         $decrypted_phone = $this->decryptssl($value['primary_phone'],'jP.J#8A6VDy[QH$d' );

    //         $cekUser = User::where('npp_user', $value['employee_id'])->first();

    //         if($cekUser){
    //             try {
    //                 $user = [
    //                     'nm_user' => $value['employee_name'],
    //                     // 'npp_user' => $value['employee_id'],
    //                     'nm_perusahaan' => $value['company_code'],
    //                     // 'id_role' => 2,
    //                     // 'wilayah_perusahaan => $request->wilayah,
    //                     'email' => $decrypted_gmail,
    //                     'employee_status' => 'Inactive',
    //                     'primary_address' => $decrypted_address,
    //                     'primary_phone' => $decrypted_phone,
    //                     'primary_city' => $value['primary_city'],
    //                     'birthday' => $decrypted_birthday,
    //                     'company_code' => $value['company_code'],
    //                     'management_code' => $value['management_code'],
    //                     'management_name' => $value['management_name'],
    //                     'division_code' => $value['division_code'],
    //                     'division_name' => $value['division_name'],
    //                     'department_code' => $value['department_code'],
    //                     'department_name' => $value['department_name'],
    //                     'sub_department_code' => $value['sub_department_code'],
    //                     'sub_department_name' => $value['sub_department_name'],
    //                     'section_code' => $value['section_code'],
    //                     'section_name' => $value['section_name'],
    //                     'position_code' => $value['position_code'],
    //                     'position_name' => $value['position_name'],
    //                     'grade_code' => $value['grade_code'],
    //                     'branch_name' => $value['branch_name'],
    //                     'branch_code' => $value['branch_code'],
    //                     'functional_code' => $value['functional_code'],
    //                     'functional_name' => $value['functional_name'],
    //                     'sub_section_code' => $value['sub_section_code'],
    //                     'functional_code_atasan_satu' => $value['functional_code_atasan_satu'],
    //                     'functional_name_atasan_satu' => $value['functional_name_atasan_satu'],
    //                     'npp_atasan_satu' => $value['npp_atasan_satu'],
    //                     'name_atasan_satu' => $value['name_atasan_satu'],
    //                     'functional_code_atasan_dua' => $value['functional_code_atasan_dua'],
    //                     'functional_name_atasan_dua' => $value['functional_name_atasan_dua'],
    //                     'npp_atasan_satu' => $value['npp_atasan_dua'],
    //                     'name_atasan_satu' => $value['name_atasan_dua'],

    //                     'created_by' => 'api-hris',

    //                 ];
    //                 // return $user;
    //                 User::where('npp_user', $value['employee_id'])->update($user);
    //             } catch (\Exception $e) {
    //                 return response()->json_encode('error', 'Simpan data gagal : ' . $e->getMessage());
    //                 // return response()->json(['status' => $e->getMessage()], 500);
    //             }
    //         }else{
    //             try {
    //                 $user = new User;
    //                 $user->nm_user = $value['employee_name'];
    //                 $user->npp_user = $value['employee_id'];
    //                 $user->nm_perusahaan = $value['company_code'];
    //                 $user->id_role = 2;
    //                 // $user->wilayah_perusahaan = $request->wilayah;
    //                 $user->email = $decrypted_gmail;
    //                 $user->employee_status = 'Inactive';
    //                 $user->primary_address = $decrypted_address;
    //                 $user->primary_phone = $decrypted_phone;
    //                 $user->primary_city = $value['primary_city'];
    //                 $user->birthday = $decrypted_birthday;
    //                 $user->company_code = $value['company_code'];
    //                 $user->management_code = $value['management_code'];
    //                 $user->management_name = $value['management_name'];
    //                 $user->division_code = $value['division_code'];
    //                 $user->division_name = $value['division_name'];
    //                 $user->department_code = $value['department_code'];
    //                 $user->department_name = $value['department_name'];
    //                 $user->sub_department_code = $value['sub_department_code'];
    //                 $user->sub_department_name = $value['sub_department_name'];
    //                 $user->section_code = $value['section_code'];
    //                 $user->section_name = $value['section_name'];
    //                 $user->position_code = $value['position_code'];
    //                 $user->position_name = $value['position_name'];
    //                 $user->grade_code = $value['grade_code'];
    //                 $user->branch_name = $value['branch_name'];
    //                 $user->branch_code = $value['branch_code'];
    //                 $user->functional_code = $value['functional_code'];
    //                 $user->functional_name = $value['functional_name'];
    //                 $user->sub_section_code = $value['sub_section_code'];
    //                 $user->functional_code_atasan_satu = $value['functional_code_atasan_satu'];
    //                 $user->functional_name_atasan_satu = $value['functional_name_atasan_satu'];
    //                 $user->npp_atasan_satu = $value['npp_atasan_satu'];
    //                 $user->name_atasan_satu = $value['name_atasan_satu'];
    //                 $user->functional_code_atasan_dua = $value['functional_code_atasan_dua'];
    //                 $user->functional_name_atasan_dua = $value['functional_name_atasan_dua'];
    //                 $user->npp_atasan_satu = $value['npp_atasan_dua'];
    //                 $user->name_atasan_satu = $value['name_atasan_dua'];

    //                 $user->created_by = 'api-hris';
    //                 // return $user;
    //                 $user->save();
    //             } catch (\Exception $e) {
    //                 return response()->json_encode('error', 'Simpan data gagal : ' . $e->getMessage());
    //                 // return response()->json(['status' => $e->getMessage()], 500);
    //             }
    //         }
    //         // echo $decrypted_address;
    //         // die;
    //     }
    //     // echo $data;
    //     // die;

    //     return json_decode($response, true);
    // }

    // // Fungsi untuk mengambil semua data dari setiap halaman
    // public function fetchAllData($token)
    // {
    //     $allData = [];
    //     $currentPage = 1;
    //     $perPage = 10;
    //     $totalPages = 1;

    //     // do {
    //         // Ambil data dari API
    //         $response = $this->fetchData($currentPage, $token);

    //         if (!$response) {
    //             return false; // Jika ada error, return false
    //         }
    //         return $response;

    //         // Gabungkan data dari halaman saat ini ke allData
    //         $allData = array_merge($allData, $response['data']);

    //         // Hitung total halaman
    //     //     $totalPages = ceil($response['total'] / $perPage);

    //     //     $currentPage++;
    //     // } while ($currentPage <= $totalPages);

    //     return $allData;
    // }

    // public function getApi()
    // {
    //     // $curl = curl_init();

    //     // curl_setopt_array($curl, array(
    //     //     CURLOPT_URL => 'http://172.27.1.52:5252/hris/api/user',
    //     //     CURLOPT_RETURNTRANSFER => true,
    //     //     CURLOPT_HTTPHEADER => array(
    //     //         'Authorization: Bearer  eyJhbGciOiJIUzI1NiJ9.eyJzdWIiOiIwMTM0MiIsImlhdCI6MTcyNzMyMDkyMiwiZXhwIjoxNzI3NDA3MzIyfQ._xUOWgdYQzHyH2qrJzh_MlMo_3L-2PWYZlci0yQA-Q4'
    //     //     ),
    //     // ));
    //     // $response = curl_exec($curl);

    //     // if ($response === false) {
    //     //     // Jika curl_exec gagal, tampilkan error curl
    //     //     $curl_error = curl_error($curl);
    //     //     curl_close($curl);
    //     //     return response()->json(['error' => 'CURL Error: ' . $curl_error], 500);
    //     // }

    //     // curl_close($curl);

    //     // // Decode JSON response menjadi array PHP
    //     // $data = json_decode($response, true);

    //     // // Periksa apakah hasil decode adalah array
    //     // if ($data === null) {
    //     //     // Jika json_decode gagal, mungkin format JSON tidak valid
    //     //     return response()->json(['error' => 'Invalid JSON format'], 500);
    //     // }

    //     // // Pastikan key 'data' ada dalam response
    //     // if (!isset($data['data'])) {
    //     //     // Jika tidak ada key 'data', respons API tidak sesuai yang diharapkan
    //     //     return response()->json(['error' => 'Data not found in API response'], 404);
    //     // }

    //     // echo $data;
    //     // // Ambil nama employee
    //     // $employee_name = $data['data']['employee_name'];
    //     // echo 'Employee Name: ' . $employee_name . "\n";

    //     // $data = json_decode($response, true);

    //     // if (isset($data['data'])) {
    //     //     $employee_name = $data['data']['employee_name'];
    //     //     $employee_address = $data['data']['primary_address'];
    //     //     // $employee_gmail = $data['data']['email'];
    //     //     // $birthday = $data['data']['birthday'];
    //     //     // $employee_phone = $data['data']['primary_phone'];
    //     //     $key = 'jP.J#8A6VDy[QH$d';
    //     //     try {

    //     //         $decrypted_address = $this->decryptssl($employee_address, $key);
    //     //         // $decrypted_gmail = $this->decryptssl($employee_gmail, $key);
    //     //         // $decrypted_birthday = $this->decryptssl($birthday, $key);
    //     //         // $decrypted_phone = $this->decryptssl($employee_phone, $key);
    //     //     } catch (\Exception $e) {
    //     //         return response()->json(['error ' => $e->getMessage()], 500);
    //     //     }

    //     //     return response()->json([
    //     //         'employee_name' => $employee_name,
    //     //         'decrypted_address' => $decrypted_address,
    //     //         // 'decrypted_email' => $decrypted_gmail,
    //     //         // 'decrypted_birthday' => $decrypted_birthday,
    //     //         // 'decrypted_phone' => $decrypted_phone,
    //     //     ]);
    //     // } else {
    //     //     return response()->json(['error' => 'Data not found'], 404);
    //     // }

    //     $url = "http://172.27.1.52:5252/hris/api/auth/signin";

    //     $data = [
    //         'username' => '01342',
    //         'password' => 'Jamkrindo123',
    //     ];

    //     // Inisialisasi cURL
    //     $ch = curl_init($url);

    //     curl_setopt($ch, CURLOPT_POST, true);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, [
    //         'Content-Type: application/json',
    //         'Accept: application/json',
    //     ]);
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    //     $response = curl_exec($ch);

    //     // Periksa apakah ada error
    //     if (curl_errno($ch)) {
    //         echo 'Error:' . curl_error($ch);
    //     }

    //     $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    //     curl_close($ch);

    //     $responseData = json_decode($response, true);

    //     // Token Bearer
    //     $token = $responseData['token']; // Ganti dengan token Bearer kamu
    //     $data = $this->fetchAllData($token);
    //     // $data =   $decrypt = decrypts($data['data']['primary_address'], $key);
    //     // return response()->json($data);
    //     dd($data);
    // }

    // private function decryptString($str, $key)
    // {
    //     $str = base64_decode($str);
    //     $key = substr(hash('sha256', $key, true), 0, 16);
    //     $decrypted = openssl_decrypt($str, 'aes-128-ecb', $key, OPENSSL_RAW_DATA);
    //     $pad = ord($decrypted[strlen($decrypted) - 1]);
    //     return substr($decrypted, 0, -$pad);
    // }

    // function decrypts($str, $key){
    //     $str = base64_decode($str);
    //     $str = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $str, MCRYPT_MODE_ECB);
    //     $block = mcrypt_get_block_size('rijndael_128', 'ecb');
    //     $pad = ord($str[($len = strlen($str)) - 1]);
    //     $len = strlen($str);
    //     $pad = ord($str[$len-1]);
    //     return substr($str, 0, strlen($str) - $pad);
    // }

    // function decrypti($str, $key)
    // {
    //     // Dekode dari base64
    //     $str = base64_decode($str);
    //     $key = substr(hash('sha256', $key, true), 0, 16);

    //     // Dekripsi menggunakan OpenSSL AES-128-ECB
    //     $decrypted = openssl_decrypt($str, 'aes-128-ecb', $key, OPENSSL_RAW_DATA);

    //     // Memeriksa apakah dekripsi gagal
    //     if ($decrypted === false) {
    //         throw new \Exception('Decryption failed: ' . openssl_error_string());
    //     }

    //     // Menghapus padding PKCS7
    //     $pad = ord($decrypted[strlen($decrypted) - 1]);
    //     $decrypted = substr($decrypted, 0, -$pad);

    //     return $decrypted;
    // }

    // function decryptssl($str, $key){
    //     $str = base64_decode($str);
    //     $decrypted = openssl_decrypt($str, 'AES-128-ECB', $key,  OPENSSL_RAW_DATA);
    //     return $decrypted;
    //     }



    public function getData(Request $request)
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 2)->first();
        $users = User::with(['wilayah', 'cabang'])->where('is_delete', 'N');

        if ($request->startDate && $request->endDate) {
            $users->whereBetween('created_date', [$request->startDate, $request->endDate]);
        }
        $users = $users->orderBy('created_date', 'desc')->get();
        //$users = User::with('wilayah', 'cabang')->where('is_delete', 'N')->orderBy('created_date', 'desc')->get();
        // return response()->json($users);

        $no = 1;


        foreach ($users as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;

            $btn = 'text-bg-success ';

            if ($act->status_user != 'Active') {
                $btn = 'text-bg-danger ';
            }
            $act->no = $no++;
            $act->user_status = "<td ><span class='badge " . $btn . "'> " . $act->status_user . "</span></td>";

            // if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
            //     $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a> <button class='btn btn-sm fw-bold' onclick='userDelete(\"" . $act->kd_user . "\")'><i class='bi bi-trash' ></i></button>";
            // }  else if ($role->can_delete == 'Y') {
            //     $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a> <button class='btn btn-sm fw-bold' onclick='userDelete(\"" . $act->kd_user . "\")'><i class='bi bi-trash' ></i></button>";
            // } else {
            //     $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a> ";
            // }
            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a>  <a href='users-management/edit/" . $act->kd_user . "' class='btn'><i class='bi bi-pencil-square'></i></a><button class='btn btn-sm fw-bold' onclick='userDelete(\"" . $act->kd_user . "\")'><i class='bi bi-trash' ></i></button>";
            } else if ($role->can_update == 'Y') {
                $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a>  <a href='users-management/edit/" . $act->kd_user . "' class='btn'><i class='bi bi-pencil-square'></i></a>";
            } else if ($role->can_delete == 'Y') {
                $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a> <button class='btn btn-sm fw-bold' onclick='userDelete(\"" . $act->kd_user . "\")'><i class='bi bi-trash' ></i></button>";
            } else {
                $act->action =   "<a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i class='bi bi-search'></i></a> ";
            }
            // $act->action =   "  <a href='users-management/lihat/" . $act->kd_user . "' class='btn'><i
            //                                    class='bi bi-search'></i></a> <a href='users-management/edit/" . $act->kd_user . "' class='btn'><i class='bi bi-pencil-square'></i></a><button class='btn btn-sm fw-bold' onclick='userDelete(\"" . $act->kd_user . "\")'><i class='bi bi-trash' ></i></button>";
        }
        return datatables::of($users)->escapecolumns([])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $provinsi = Province::where('is_delete', 'N')->get();
        $wilayah = Regional::where('is_delete', 'N')->get();

        return view('user-management.create', compact('provinsi', 'wilayah'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
        $request->validate(
            [
                'npp_user' => 'required|unique:m_users',
                'email' => 'required|unique:m_users',
                'password' => 'required | confirmed|min:8',

            ],
            [
                'npp_user.unique' => 'NPP sudah terdaftar',
                'email.unique' => 'email sudah terdaftar',
                'password.confirmed' => 'Password tidak sama',
                'password.min' => 'Password mininal harus 8 karakter'
            ]
        );
        $password = Hash::make($request->password);

        try {
            $user = new User;
            // $user->kd_user = 'userId1';
            $user->nm_user = $request->nm_user;
            $user->npp_user = $request->npp_user;
            $user->nm_perusahaan = $request->company_name;
            $user->wilayah_perusahaan = $request->wilayah;
            $user->email = $request->email;
            $user->employee_status = $request->employee_status;
            $user->primary_address = $request->primary_address;
            $user->primary_phone = $request->primary_phone;
            $user->primary_city = $request->kota;
            $user->birthday = $request->birthday;
            $user->company_code = $request->company_code;
            $user->management_code = $request->management_code;
            $user->management_name = $request->management_name;
            $user->division_code = $request->division_code;
            $user->division_name = $request->division_name;
            $user->department_code = $request->department_code;
            $user->department_name = $request->department_name;
            $user->sub_department_code = $request->sub_department_code;
            $user->sub_department_name = $request->sub_department_name;
            $user->section_code = $request->section_code;
            $user->section_name = $request->section_name;
            $user->position_code = $request->position_code;
            $user->position_name = $request->position_name;
            $user->grade_code = $request->grade_code;
            $user->branch_name = $request->branch_name;
            $user->branch_code = $request->cabang;
            if ($request->id_role) {
                $user->id_role = $request->id_role;
            }
            // $user->functional_code = $request->functional_code;
            // $user->functional_name = $request->functional_name;
            // $user->sub_section_code = $request->sub_section_code;
            // $user->functional_code_atasan_satu = $request->functional_code_atasan_satu;
            // $user->functional_name_atasan_satu = $request->functional_name_atasan_satu;
            // $user->npp_atasan_satu = $request->npp_atasan_satu;
            // $user->name_atasan_satu = $request->name_atasan_satu;
            // $user->functional_code_atasan_dua = $request->functional_code_atasan_dua;
            // $user->functional_name_atasan_dua = $request->functional_name_atasan_dua;
            // $user->npp_atasan_satu = $request->npp_atasan_dua;
            // $user->name_atasan_satu = $request->name_atasan_dua;

            $user->password = $password;
            $user->updated_by = Auth::user()->nm_user;
            $user->save();

            $newUser = User::orderBy('kd_user', 'desc')->first();

            $menu = [1, 2, 3, 4, 5, 6, 7, 8, 12, 14, 15, 16];

            for ($i = 0; $i < count($menu); $i++) {
                $role = new Role();
                $role->id_account = $newUser->kd_user;
                $role->id_menu = $menu[$i];
                $role->can_access = 'Y';
                $role->save();
            }

            // return response()->json(['status' => 'success'], 200);
            return redirect()->route('user-manager.index')->with('success', 'Simpan data berhasil');
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

        $user = user::with('wilayah', 'cabang', 'kota')->where('kd_user', $id)->first();
        $user['email'] = $this->decryptssl($user['email'], 'P/zqOYfEDWHmQ9/g8PrApw==');
        $user['primary_address'] = $this->decryptssl($user['primary_address'], 'P/zqOYfEDWHmQ9/g8PrApw==');
        $user['primary_phone'] = $this->decryptssl($user['primary_phone'], 'P/zqOYfEDWHmQ9/g8PrApw==');

        return view('user-management.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::where('is_delete', 'N')->where('kd_user', $id)->first();
        $user['email'] = $this->decryptssl($user['email'], 'P/zqOYfEDWHmQ9/g8PrApw==');
        $user['primary_address'] = $this->decryptssl($user['primary_address'], 'P/zqOYfEDWHmQ9/g8PrApw==');
        $user['primary_phone'] = $this->decryptssl($user['primary_phone'], 'P/zqOYfEDWHmQ9/g8PrApw==');
        $user['birthday'] = $this->decryptssl($user['birthday'], 'P/zqOYfEDWHmQ9/g8PrApw==');

        return view('user-management.edit', compact('user'));

        // return response()->json($users);
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

        $request->validate([
            'npp_user' => 'required|exists:m_users,npp_user',
        ]);

        try {
            $user =  User::where('kd_user', $id)->first();
            // dd($user);
            // $user->kd_user = 'userId1';
            // $user->nm_user = $request->nm_user;
            // $user->npp_user = $request->npp_user;
            // $user->nm_perusahaan = $request->nm_perusahaan;
            // $user->wilayah_perusahaan = $request->wilayah;
            // $user->email = $request->email;
            // $user->status_user = $request->status_user;
            // $user->primary_address = $request->primary_address;
            // $user->primary_phone = $request->primary_phone;
            // $user->primary_city = $request->kota;
            // $user->birthday = $request->birthday;
            // $user->company_code = $request->company_code;
            // $user->management_code = $request->management_code;
            // $user->management_name = $request->management_name;
            // $user->division_code = $request->division_code;
            // $user->division_name = $request->division_name;
            // $user->department_code = $request->department_code;
            // $user->department_name = $request->department_name;
            // $user->sub_department_code = $request->sub_department_code;
            // $user->sub_department_name = $request->sub_department_name;
            // $user->section_code = $request->section_code;
            // $user->section_name = $request->section_name;
            // $user->sub_section_code = $request->sub_section_code;
            // $user->position_code = $request->position_code;
            // $user->position_name = $request->position_name;
            // $user->grade_code = $request->grade_code;

            // $user->functional_code = $request->functional_code;
            // $user->functional_name = $request->functional_name;
            // $user->sub_section_code = $request->sub_section_code;
            // $user->functional_code_atasan_satu = $request->functional_code_atasan_satu;
            // $user->functional_name_atasan_satu = $request->functional_name_atasan_satu;
            // $user->npp_atasan_satu = $request->npp_atasan_satu;
            // $user->name_atasan_satu = $request->name_atasan_satu;
            // $user->functional_code_atasan_dua = $request->functional_code_atasan_dua;
            // $user->functional_name_atasan_dua = $request->functional_name_atasan_dua;
            // $user->npp_atasan_satu = $request->npp_atasan_dua;
            // $user->name_atasan_satu = $request->name_atasan_dua;
            if ($request->id_role) {
                $user->id_role = $request->id_role;
            }
            // if ($request->password) {
            //     $request->validate(
            //         [
            //             'password' => 'required | confirmed',

            //         ],
            //         [
            //             'password.confirmed' => 'Password tidak sama'
            //         ]
            //     );
            //     $password = Hash::make($request->password);
            //     $user->password = $password;
            // }

            $user->updated_by = Auth::user()->kd_user;
            $user->update();
            if ($request->id_role == '1') {
                $menu = [1, 2, 3, 4, 5, 6, 7, 8, 12, 14, 15, 16, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];

                foreach ($menu as $idMenu) {
                    // Cari role berdasarkan id_account dan id_menu
                    $role = Role::where('id_account', $id)
                        ->where('id_menu', $idMenu)
                        ->first();
                    
                    if (!$role) {
                        // Jika belum ada, buat baru
                        $role = new Role();
                        $role->id_account = $id;
                        $role->id_menu = $idMenu;
                    }

                    // Set hak akses
                    $role->can_access  = 'Y';
                    $role->can_create  = 'Y';
                    $role->can_approve = 'Y';
                    $role->can_update  = 'Y';
                    $role->update(); // gunakan save() karena bisa insert atau update
                }
            } else {


                $menu = [ 2,  5, 6, 7, 8, 12, 14, 15, 16,  22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
                foreach ($menu as $idMenu) {
                    // Cari role berdasarkan id_account dan id_menu
                    $role = Role::where('id_account', $id)
                        ->where('id_menu', $idMenu)
                        ->first();

                    if (!$role) {
                        // Jika belum ada, buat baru
                        $role = new Role();
                        $role->id_account = $id;
                        $role->id_menu = $idMenu;
                    }

                    // Set hak akses
                    $role->can_access  = 'N';
                    $role->can_create  = 'N';
                    $role->can_approve = 'N';
                    $role->can_update  = 'N';
                    $role->update(); // gunakan save() karena bisa insert atau update
                }
            }

            // return response()->json(['status' => 'success'], 200);
            return redirect()->route('user-manager.index')->with('success', 'Ubah data berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Simpan data gagal :' . $e->getMessage());
            // return response()->json(['status' => $e->getMessage()], 500);
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
            $user =  User::where('kd_user', $id)->first();
            $user->deleted_date = $date;
            $user->deleted_by = Auth::user()->nm_user;
            $user->is_delete = "Y";
            $user->update();

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function profile()
    {
        $user = User::with('wilayah', 'cabang', 'kota')->where('kd_user', Auth::user()->kd_user)->first();
        // dd($request);
        $provinsi = Province::where('is_delete', 'N')->get();
        $provinsiId = Province::where('kd_provinsi', $user->wilayah->kd_provinsi)->first();
        // $cabang = Branch::where('kd_cabang', $user->branch_code)->first();
        $kota = City::where('kd_provinsi', $provinsiId->kd_provinsi)->first();
        $wilayah = Regional::where('kd_provinsi', $provinsiId->kd_provinsi)->first();
        $wilayahAll = Regional::where('is_delete', 'N')->get();
        // $kota = City::where('kd_kota', $user->primary_city)->first();
        return view('profile.profile-user', compact('user', 'provinsi', 'provinsiId', 'kota', 'wilayah', 'wilayahAll'));
    }

    public function profileUpdate(Request $request, $id)
    {
        $request->validate(
            [
                'npp_user' => 'required|exists:m_users,npp_user',

            ]
        );
        try {
            $user =  User::where('kd_user', $id)->first();
            // dd($user);
            // $user->kd_user = 'userId1';
            $user->nm_user = $request->nm_user;
            $user->npp_user = $request->npp_user;
            $user->nm_perusahaan = $request->nm_perusahaan;
            $user->wilayah_perusahaan = $request->wilayah;
            $user->email = $request->email;
            $user->employee_status = $request->employee_status;
            $user->primary_address = $request->primary_address;
            $user->primary_phone = $request->primary_phone;
            $user->primary_city = $request->kota;
            $user->birthday = $request->birthday;
            $user->company_code = $request->company_code;
            // $user->management_code = $request->management_code;
            // $user->management_name = $request->management_name;
            // $user->division_code = $request->division_code;
            // $user->division_name = $request->division_name;
            // $user->department_code = $request->department_code;
            // $user->department_name = $request->department_name;
            // $user->sub_department_code = $request->sub_department_code;
            // $user->sub_department_name = $request->sub_department_name;
            // $user->section_code = $request->section_code;
            // $user->section_name = $request->section_name;
            // $user->sub_section_code = $request->sub_section_code;
            // $user->position_code = $request->position_code;
            // $user->position_name = $request->position_name;
            // $user->grade_code = $request->grade_code;
            $user->branch_name = $request->branch_name;
            $user->branch_code = $request->cabang;
            // $user->functional_code = $request->functional_code;
            // $user->functional_name = $request->functional_name;
            // $user->sub_section_code = $request->sub_section_code;
            // $user->functional_code_atasan_satu = $request->functional_code_atasan_satu;
            // $user->functional_name_atasan_satu = $request->functional_name_atasan_satu;
            // $user->npp_atasan_satu = $request->npp_atasan_satu;
            // $user->name_atasan_satu = $request->name_atasan_satu;
            // $user->functional_code_atasan_dua = $request->functional_code_atasan_dua;
            // $user->functional_name_atasan_dua = $request->functional_name_atasan_dua;
            // $user->npp_atasan_satu = $request->npp_atasan_dua;
            // $user->name_atasan_satu = $request->name_atasan_dua;


            $user->updated_by = Auth::user()->nm_user;
            $user->update();
            // dd(
            //     $request
            // );

            // return response()->json(['status' => 'success'], 200);
            return back()->with('success', 'Ubah data berhasil');
        } catch (\Exception $e) {
            return back()->with('error', 'Simpan data gagal :' . $e->getMessage());
            // return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function changePassword(Request $request, $id)
    {
        $request->validate([
            'password' => 'required|confirmed',

        ]);
        $user = User::where('kd_user', $id)->first();
        if (Hash::check($request->currentPassword, $user->password)) {
            try {

                $password = Hash::make($request->password);
                $user->password = $password;
                $user->updated_by = Auth::user()->nm_user;
                $user->update();
                // return response()->json(['status' => 'success'], 200);
                return back()->with('success', 'Ubah kata sandi berhasil');
            } catch (\Exception $e) {
                return back()->with('error', ' Ubah data gagal :' . $e->getMessage());
                // return response()->json(['status' => $e->getMessage()], 500);
            }
        };
    }

    public function cetakPdf(Request $request)
    {
        $users = User::with(['wilayah', 'cabang'])->whereBetween('created_date', [$request->start, $request->end])->get();
        // return view('customer-management.export-pdf');


        //$pdf = PDF::loadview('user-management.export-pdf', ['users' => $users, 'start' => $request->start, 'end' => $request->end])->setPaper('A4', 'landscape');
        //return $pdf->download('Admin ' . $request->start . 'to' . $request->end . '.pdf');
        return view('user-management.export-pdf', ['users' => $users, 'start' => $request->start, 'end' => $request->end]);
    }

    public function cetakExcel(Request $request)
    {
        $users = User::with(['wilayah', 'cabang'])->whereBetween('created_date', [$request->start, $request->end])->get();
        // return view('customer-management.export-pdf');


        return view('user-management.export-excel', ['users' => $users, 'start' => $request->start, 'end' => $request->end]);
    }
}
