<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\KancaJamnation;
use App\Models\KanwilJamnation;
use App\Models\KckJamnation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use GuzzleHttp\Client;

class JamnationController extends Controller
{
    public function kanwil()
    {
        $getToken = $this->getToken();
        // return $getToken;
        $token = $getToken["access_token"];
        $url = 'http://10.220.70.26/api/external/master/kanwil/';

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        // Mengatur batas waktu koneksi (dalam detik)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

        // Mengatur batas waktu eksekusi total (dalam detik)
        curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response, true);

        foreach ($data["data"] as $key => $value) {
            $cekKanwil = KanwilJamnation::where('id_kanwil', $value['id'])->first();

            if ($cekKanwil) {
                $dataKanwil = [
                    'id_kanwil' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nama_uker' => $value["namaUker"],
                    'kelas_uker' => $value["kelasUker"],
                    'latitude' => $value["latitude"],
                    'longitude' => $value["longitude"],
                    'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KanwilJamnation::where('id_kanwil', $value['id'])->update($dataKanwil);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil diupdate'], 200);
            } else {
                // $dataKanwil = [
                //     'id_kanwil' => $value["id"],
                //     'kode_uker' => $value["kodeUker"],
                //     'nama_uker' => $value["namaUker"],
                //     'kelas_uker' => $value["kelasUker"],
                //     'latitude' => $value["latitude"],
                //     'longitude' => $value["longitude"],
                //     'created_date' => date('Y-m-d H:i:s'),
                //     'is_deleted' => 'N'
                // ];
                $kanwil = new KanwilJamnation;
                $kanwil->id_kanwil = $value["id"];
                $kanwil->kode_uker = $value["kodeUker"];
                $kanwil->nama_uker = $value["namaUker"];
                $kanwil->kelas_uker = $value["kelasUker"];
                $kanwil->latitude = $value["latitude"];
                $kanwil->longitude = $value["longitude"];
                $kanwil->created_date = date('Y-m-d H:i:s');
                $kanwil->is_deleted = 'N';
                $kanwil->save();
                // KanwilJamnation::create($dataKanwil);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil disimpan'], 200);
            }
        }
    }

    public function kanwilDetail()
    {
        // $getToken = $this->getToken();
        // $token = $getToken["access_token"];
        $getKanwil = KanwilJamnation::get();

        foreach ($getKanwil as $gk) {
            return $gk->kode_uker;
        }
        $url = 'http://10.220.70.26/api/external/master/kanwil/';

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        // Mengatur batas waktu koneksi (dalam detik)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

        // Mengatur batas waktu eksekusi total (dalam detik)
        curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response, true);

        foreach ($data["data"] as $key => $value) {
            $cekKanwil = KanwilJamnation::where('id_kanwil', $value['id'])->first();

            if ($cekKanwil) {
                $dataKanwil = [
                    'id_kanwil' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nama_uker' => $value["namaUker"],
                    'kelas_uker' => $value["kelasUker"],
                    'latitude' => $value["latitude"],
                    'longitude' => $value["longitude"],
                    'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KanwilJamnation::where('id_kanwil', $value['id'])->update($dataKanwil);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil diupdate'], 200);
            } else {
                // $dataKanwil = [
                //     'id_kanwil' => $value["id"],
                //     'kode_uker' => $value["kodeUker"],
                //     'nama_uker' => $value["namaUker"],
                //     'kelas_uker' => $value["kelasUker"],
                //     'latitude' => $value["latitude"],
                //     'longitude' => $value["longitude"],
                //     'created_date' => date('Y-m-d H:i:s'),
                //     'is_deleted' => 'N'
                // ];
                $kanwil = new KanwilJamnation;
                $kanwil->id_kanwil = $value["id"];
                $kanwil->kode_uker = $value["kodeUker"];
                $kanwil->nama_uker = $value["namaUker"];
                $kanwil->kelas_uker = $value["kelasUker"];
                $kanwil->latitude = $value["latitude"];
                $kanwil->longitude = $value["longitude"];
                $kanwil->created_date = date('Y-m-d H:i:s');
                $kanwil->is_deleted = 'N';
                $kanwil->save();
                // KanwilJamnation::create($dataKanwil);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil disimpan'], 200);
            }
        }
    }

    public function kanca()
    {
        $getToken = $this->getToken();
        $token = $getToken["access_token"];
        $url = 'http://10.220.70.26/api/external/master/kanca/';

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        // Mengatur batas waktu koneksi (dalam detik)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

        // Mengatur batas waktu eksekusi total (dalam detik)
        curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response, true);

        foreach ($data["data"] as $key => $value) {
            $cekKanca = KancaJamnation::where('id_kanca', $value['id'])->first();

            if ($cekKanca) {
                // return 'ok';
                $dataKanca = [
                    'id_kanca' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nm_cabang' => $value["namaUker"],
                    'kelas_uker' => $value["kelasUker"],
                    'latitude_cabang' => $value["latitude"],
                    'longitude_cabang' => $value["longitude"],
                    'wilker' => $value["wilker"],
                    'id_mst_kanwil' => $value["id_mst_kanwil"],
                    'nama_kanwil' => $value["nama_kanwil"],
                    // 'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KancaJamnation::where('id_kanca', $value['id'])->update($dataKanca);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil diupdate'], 200);
            } else {
                // return 'not ok';
                $dataKanca = [
                    'id_kanca' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nm_cabang' => $value["namaUker"],
                    'kelas_uker' => $value["kelasUker"],
                    'latitude_cabang' => $value["latitude"],
                    'longitude_cabang' => $value["longitude"],
                    'wilker' => $value["wilker"],
                    'id_mst_kanwil' => $value["id_mst_kanwil"],
                    'nama_kanwil' => $value["nama_kanwil"],
                    // 'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KancaJamnation::create($dataKanca);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil disimpan'], 200);
            }
        }

        $url = 'http://10.220.70.26/api/external/master/kup/';

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        // Mengatur batas waktu koneksi (dalam detik)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

        // Mengatur batas waktu eksekusi total (dalam detik)
        curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response, true);

        foreach ($data["data"] as $key => $value) {
            $cekKanca = KancaJamnation::where('id_kup', $value['id'])->first();

            if ($cekKanca) {
                // return 'ok';
                $dataKanca = [
                    'id_kup' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nm_cabang' => $value["namaUker"],
                    // 'kelas_uker' => $value["kelasUker"],
                    'latitude_cabang' => $value["latitude"],
                    'longitude_cabang' => $value["longitude"],
                    'wilker' => $value["wilker"],
                    'id_mst_knca' => $value["id_mst_kanca"],
                    'nama_kanwil' => $value["nama_kanca"],
                    'kup'  => true,
                    // 'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KancaJamnation::where('id_kup', $value['id'])->update($dataKanca);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil diupdate'], 200);
            } else {
                // return 'not ok';
                $dataKanca = [
                    'id_kup' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nm_cabang' => $value["namaUker"],
                    // 'kelas_uker' => $value["kelasUker"],
                    'latitude_cabang' => $value["latitude"],
                    'longitude_cabang' => $value["longitude"],
                    'wilker' => $value["wilker"],
                    'id_mst_kanca' => $value["id_mst_kanca"],
                    'nama_kanwil' => $value["nama_kanca"],
                    'kup'  => true,
                    // 'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KancaJamnation::create($dataKanca);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil disimpan'], 200);
            }
        }
    }

    public function kancaDetail()
    {
        $getKanca = KancaJamnation::whereNull('kup')->get();
        // return $getKanca;
        $getToken = $this->getToken();
        $token = $getToken["access_token"];
        $nama = [];
        foreach ($getKanca as $kanca) {
            $url = 'http://10.220.70.26/api/external/kanca/' . $kanca->kode_uker;

            // Inisialisasi cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ]);
            // Mengatur batas waktu koneksi (dalam detik)
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

            // Eksekusi cURL
            $response = curl_exec($ch);

            // Memeriksa error pada cURL
            if (curl_errno($ch)) {
                return false;
            }

            curl_close($ch);

            // Mengubah JSON menjadi array PHPdd9
            $data = json_decode($response, true);
            // return $data['data']->alamat;



            if ($data) {


                foreach ($data["data"] as $key => $value) {

                    $dataKanca = [
                        'alamat_cabang' => $value["alamat"],
                        'telp_cabang' => $value["no_telp"],
                        'fax' => $value["fax"],
                        'email' => $value["email"],

                    ];
                    KancaJamnation::where('id_kanca', $value['id_mst_kanca'])->update($dataKanca);
                }
            }
        }
        $getKup = KancaJamnation::whereNotNull('kup')->get();
        // return $getKup;
        $getToken = $this->getToken();
        $no =1;
        foreach ($getKup as $kup) {
            $url = 'http://10.220.70.26/api/external/kup/' . $kup->kode_uker;

            // Inisialisasi cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json'
            ]);
            // Mengatur batas waktu koneksi (dalam detik)
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

            // Eksekusi cURL
            $response = curl_exec($ch);

            // Memeriksa error pada cURL
            if (curl_errno($ch)) {
                return false;
            }

            curl_close($ch);

            // Mengubah JSON menjadi array PHPdd9
            $data = json_decode($response, true);
            // return $data['data']->alamat
            if ($data) {
                
                foreach ($data["data"] as $key => $value) {
                    
                    $datakup = [
                        'alamat_cabang' => $value["alamat"],
                        'telp_cabang' => $value["no_telp"],
                        'fax' => $value["fax"],
                        'email' => $value["email"],

                    ];
                    $k = KancaJamnation::where('id_kup', $value['id_mst_kup'])->update($datakup);
                    // return $k;
                    // return [$datakup,$data];
                }
            }else {
                $nama[]= [$data, $kup->kode_uker, $no++];
            }
        }
        return $nama;
    }

    public function kck()
    {
        $getToken = $this->getToken();
        $token = $getToken["access_token"];
        $url = 'http://10.220.70.26/api/external/master/kck/';

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        // Mengatur batas waktu koneksi (dalam detik)
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

        // Mengatur batas waktu eksekusi total (dalam detik)
        curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response, true);

        foreach ($data["data"] as $key => $value) {
            $cekKck = KckJamnation::where('id_Kck', $value['id'])->first();

            if ($cekKck) {
                $dataKck = [
                    'id_kanca' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nama_uker' => $value["namaUker"],
                    'kelas_uker' => $value["kelasUker"],
                    'latitude' => $value["latitude"],
                    'longitude' => $value["longitude"],
                    'wilker' => $value["wilker"],
                    'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KckJamnation::where('id_kck', $value['id'])->update($dataKck);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil diupdate'], 200);
            } else {
                $dataKck = [
                    'id_kanca' => $value["id"],
                    'kode_uker' => $value["kodeUker"],
                    'nama_uker' => $value["namaUker"],
                    'kelas_uker' => $value["kelasUker"],
                    'latitude' => $value["latitude"],
                    'longitude' => $value["longitude"],
                    'wilker' => $value["wilker"],
                    'created_date' => date('Y-m-d H:i:s'),
                    'is_deleted' => 'N'
                ];
                KckJamnation::create($dataKck);
                // return response()->json_encode(['status' => 'success', 'msg' => 'Data berhasil disimpan'], 200);
            }
        }
    }

    public function getToken()
    {
        $url = "http://10.220.70.26/api/login";

        $data = [
            'username' => '00880',
            'password' => 'Jamkrindo123',
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

        $response = curl_exec($ch);

        // Periksa apakah ada error
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        return $responseData = json_decode($response, true);
    }
}
