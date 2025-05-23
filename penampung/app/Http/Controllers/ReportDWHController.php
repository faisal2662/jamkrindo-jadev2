<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Dwh;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ReportDWHController extends Controller
{
    public function getDwhOld(){
        $batchSize = 20; // Simpan ke database per 100 data
        $customers = Customer::where('is_delete', 'N')->pluck('company_name')->get();
        // return count($customers);
        
        $batchData = []; // Menyimpan batch sebelum disimpan ke database
        $offset = 0; // Mulai dari index ke-0
        $limit = 10; // Ambil 10 data dari API setiap kali request
        $url = "http://172.27.1.47:4747/dwh_api/spd001";
    
        while ($offset < count($customers)) {
            // Ambil 10 customer dalam setiap request API
            $nasabahChunk = array_slice($customers, $offset, $limit);
            $offset += $limit; // Update offset
    
            $nasabahChunk = array_map(function ($customer){
                return addslashes($customer);
            }, $nasabahChunk);
            // Kirim request ke API
            $data = [
                'periode_awal' => "2024-01-01",
                'periode_akhir' => "2024-12-31",
                'perubahan_data' => "2024-12",
                'id_kanwil' => [],
                'id_uker' => [],
                'penerima_jaminan' => [],
                'lob' => [],
                'produk' => [],
                'ktp' => [],
                'npwp' => [],
                'nasabah' => $nasabahChunk
            ];
    
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_POST => true,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    'Content-Type: application/json',
                    'Accept: application/json'
                ],
                CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
                CURLOPT_TIMEOUT => 120
            ]);
    
            $response = curl_exec($ch);
            curl_close($ch);
            $responseData = json_decode($response, true);
            return $responseData;
    
            if (!isset($responseData['data_total']) || !is_array($responseData['data_total'])) {
                continue; // Lewati jika respons tidak sesuai
            }
    
            foreach ($responseData['data_total'] as $rd) {
                $tglAkad = date('Y-m-d H:i:s', strtotime($rd['tgl_akad']));
                $tglSp = date('Y-m-d H:i:s', strtotime($rd['tgl_sp']));
    
                $batchData[] = [
                    'id_transaksi' => $rd['id_transaksi'],
                    'kantor_wilayah' => $rd['kantor_wilayah'],
                    'wilayah_kerja' => $rd['wilayah_kerja'],
                    'no_surat' => $rd['no_surat'],
                    'tgl_akad' => $tglAkad,
                    'nama_proyek' => $rd['nama_proyek'],
                    'id_dc_peruntukan_kredit' => $rd['id_dc_peruntukan_kredit'],
                    'penerima_jaminan' => $rd['penerima_jaminan'],
                    'lob' => $rd['lob'],
                    'produk' => $rd['produk'],
                    'ktp' => $rd['ktp'],
                    'npwp' => $rd['npwp'],
                    'nasabah' => $rd['nasabah'],
                    'nomor_sp' => $rd['nomor_sp'],
                    'tgl_sp' => $tglSp,
                    'pokok_kredit' => $rd['pokok_kredit'],
                    'nilai_penjaminan' => $rd['nilai_penjaminan'],
                    'ijp' => $rd['ijp'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];
    
                // Jika batch sudah mencapai 100, simpan ke database
                if (count($batchData) >= $batchSize) {
                    Dwh::insert($batchData);
                    $batchData = []; // Kosongkan batch setelah insert
                }
            }
        }
    
        // Simpan sisa data yang belum masuk batch
        if (!empty($batchData)) {
            Dwh::insert($batchData);
        }
    
        return response()->json(["message" => "Data berhasil disimpan"], 200);
    }

    public function getDwh(){
        $batchSize = 500;
        $customers = Customer::where('is_delete', 'N')->whereNotNull('company_name')->pluck('company_name')->toArray();
        $chunk = array_chunk($customers, $batchSize);
        
        $dataTotal = [];
        $dataCs = [];
        foreach($chunk as $csChunk){
            $response = $this->sendDwhRequest($csChunk);

            if($response['success']){
                return response()->json(["error" => $response['error']], 500);
            }

            $responseData = $response['data'];
            if(!empty($responseData['data_total'])){
                $datatotal = array_merge($dataTotal, $responseData['data_total']);
            }

            usleep(200000);
        }

        if(!empty($dataTotal)){
            $dataToInsert = array_map(function ($rd){
                return [
                    'id_transaksi' => $rd['id_transaksi'],
                    'kantor_wilayah' => $rd['kantor_wilayah'],
                    'wilayah_kerja' => $rd['wilayah_kerja'],
                    'no_surat' => $rd['no_surat'],
                    'tgl_akad' => date('Y-m-d H:i:s', strtotime($rd['tgl_akad'])),
                    'nama_proyek' => $rd['nama_proyek'],
                    'id_dc_peruntukan_kredit' => $rd['id_dc_peruntukan_kredit'],
                    'penerima_jaminan' => $rd['penerima_jaminan'],
                    'lob' => $rd['lob'],
                    'produk' => $rd['produk'],
                    'ktp' => $rd['ktp'],
                    'npwp' => $rd['npwp'],
                    'nasabah' => $rd['nasabah'],
                    'nomor_sp' => $rd['nomor_sp'],
                    'tgl_sp' => date('Y-m-d H:i:s', strtotime($rd['tgl_sp'])),
                    'pokok_kredit' => $rd['pokok_kredit'],
                    'nilai_penjaminan' => $rd['nilai_penjaminan'],
                    'ijp' => $rd['ijp']
                ];
            }, $dataTotal);
        }
    
        // Gunakan upsert untuk mempercepat penyimpanan data
        Dwh::upsert($dataToInsert, ['id_transaksi'], ['kantor_wilayah', 'wilayah_kerja', 'no_surat', 'tgl_akad', 'nama_proyek', 'id_dc_peruntukan_kredit', 'penerima_jaminan', 'lob', 'produk', 'ktp', 'npwp', 'nasabah', 'nomor_sp', 'tgl_sp', 'pokok_kredit', 'nilai_penjaminan', 'ijp']);

        
        if(isset($user)){
            $log = DB::table('dwh_audit_trails')->insert([
                // 'kd_user' => $user->kd_user,
                'action' => 'Generate Manual',
                'created_by' => $user->kd_user,
                'created_date' => date('Y-m-d H:i:s'),
                // 'browser_version'   => $agent->version($agent->browser()),
                // 'browser'           => $agent->browser(),
                'ip_address'        => request()->ip(),
                // 'platform'          => $agent->platform(),
                // 'platform_version'  => $agent->version($agent->platform()),
                // 'device'            => $agent->device()
            ]);
        }else{
            $log = DB::table('dwh_audit_trails')->insert([
                // 'kd_user' => $user->kd_user,
                'action' => 'Generate Automatic',
                'created_by' => 'automatic',
                'created_date' => date('Y-m-d H:i:s'),
                // 'browser_version'   => $agent->version($agent->browser()),
                // 'browser'           => $agent->browser(),
                'ip_address'        => request()->ip(),
                // 'platform'          => $agent->platform(),
                // 'platform_version'  => $agent->version($agent->platform()),
                // 'device'            => $agent->device()
            ]);
        }
        // $log = DB::table('t_log_user')->insert([
        //         'kd_user' => $user->kd_user,
        //         'keterangan' => 'Login',
        //         'created_by' => 'automatic',
        //         'created_date' => date('Y-m-d H:i:s'),
        //         'browser_version'   => $agent->version($agent->browser()),
        //         'browser'           => $agent->browser(),
        //         'ip_address'        => request()->ip(),
        //         'platform'          => $agent->platform(),
        //         'platform_version'  => $agent->version($agent->platform()),
        //         'device'            => $agent->device()
        //     ]);
    
        return response()->json(['message' => 'Data berhasil diperbarui', 'total' => count($dataToInsert)], 200);
    }

    private function sendDwhRequest(array $customers)
    {
        $url = "http://172.27.1.47:4747/dwh_api/spd001";
        $data = [
            'periode_awal' => "2024-01-01",
            'periode_akhir' => "2024-12-31",
            'perubahan_data' => "2024-12",
            'id_kanwil' => [],
            'id_uker' => [],
            'penerima_jaminan' => [],
            'lob' => ["KBG dan Suretyship"],
            'produk' => ["Kredit Kontra Bank Garansi", "Surety Bond", "Payment Bond", "Custom Bond"],
            'ktp' => [],
            'npwp' => [],
            'nasabah' => $customers
        ];

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json', // Menentukan format JSON
                'Accept: application/json' // Menerima respons dalam format JSON
            ],
            CURLOPT_POSTFIELDS => json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        ]);
        
        $response = curl_exec($ch);
        if(curl_errno($ch)){
            curl_close($ch);
            return response()->json(["error" => curl_error($ch)], 500);
        }
                
        curl_close($ch);
        return ['success' => true, 'data' => json_decode($response, true)];
    }
    
    public function dwh()
    {
        return view('report.dwh.dwh');

        // return view('report.dwh.volume-penjaminan.volume-penjaminan', compact('wilayah', 'lob'));
    }

    public function dwhDataTables(Request $request)
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 3)->first();

        $startDate = $request->startDate;
        $endDate = $request->endDate;

        if ($startDate && $endDate) {
            $dwh = Dwh::whereBetween('tgl_sp', [$startDate, $endDate])->get();
        } else {
            $dwh = Dwh::all();
        }

        $no = 1;

        foreach ($dwh as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;
            $nasabah = $this->decryptssl($act->nasabah, 'jP.J#8A6VDy[QH$d');
            $npwp = $this->decryptssl($act->npwp, 'jP.J#8A6VDy[QH$d');

            $act->no = $no++;
            $act->nasabah = $nasabah;
            $act->npwp = $npwp;
            $act->date = date('d-m-Y', strtotime($act->tgl_sp));
        }

        return datatables::of($dwh)->escapecolumns([])->make(true);
    }

    public function dwhPreview(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        // $dwh = Dwh::get()->groupBy(['kantor_wilayah', 'wilayah_kerja']);
        $dwh = Dwh::selectRaw('kantor_wilayah, wilayah_kerja,
        SUM(CASE WHEN produk = "Kredit Kontra Bank Garansi" THEN 1 ELSE 0 END) as total_kbg,
        SUM(CASE WHEN produk = "Surety Bond" THEN 1 ELSE 0 END) as total_suretyship')
        ->groupBy('kantor_wilayah', 'wilayah_kerja')
        ->get()
        ->groupBy('kantor_wilayah');
        // return $dwh;

        return view('report.dwh.dwhPreview', compact('dwh', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'messages', 'start', 'end'));
    }

    public function dwhRawPdf(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;

        if ($start && $end) {
            $dwh = Dwh::whereBetween('tgl_sp', [$start, $end])->get();
        } else {
            $dwh = Dwh::all();
        }
        // return $dwh;

        foreach ($dwh as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;
            $nasabah = $this->decryptssl($act->nasabah, 'jP.J#8A6VDy[QH$d');
            $npwp = $this->decryptssl($act->npwp, 'jP.J#8A6VDy[QH$d');
            
            $act->nasabah = $nasabah;
            $act->npwp = $npwp;
            $act->date = date('d-m-Y', strtotime($act->tgl_sp));
        }

        return view('report.dwh.dwhRawPdf', compact('dwh', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'messages', 'start', 'end'));
    }

    public function dwhRawExcel(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;

        if ($start && $end) {
            $dwh = Dwh::whereBetween('tgl_sp', [$start, $end])->get();
        } else {
            $dwh = Dwh::all();
        }
        // return $dwh;

        foreach ($dwh as $act) {
            // $act->wilayah = $act->wilayah->nm_wilayah;
            $nasabah = $this->decryptssl($act->nasabah, 'jP.J#8A6VDy[QH$d');
            $npwp = $this->decryptssl($act->npwp, 'jP.J#8A6VDy[QH$d');
            
            $act->nasabah = $nasabah;
            $act->npwp = $npwp;
            $act->date = date('d-m-Y', strtotime($act->tgl_sp));
        }

        return view('report.dwh.dwhRawExcel', compact('dwh', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'messages', 'start', 'end'));
    }

    public function dwhPdf(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        // $dwh = Dwh::get()->groupBy(['kantor_wilayah', 'wilayah_kerja']);
        $dwh = Dwh::selectRaw('kantor_wilayah, wilayah_kerja,
        SUM(CASE WHEN produk = "Kredit Kontra Bank Garansi" THEN 1 ELSE 0 END) as total_kbg,
        SUM(CASE WHEN produk = "Surety Bond" THEN 1 ELSE 0 END) as total_suretyship')
        ->groupBy('kantor_wilayah', 'wilayah_kerja')
        ->get()
        ->groupBy('kantor_wilayah');
        // return $dwh;

        return view('report.dwh.dwhPdf', compact('dwh', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'messages', 'start', 'end'));
    }
    public function dwhExcel(Request $request)
    {
        $start = $request->startDate;
        $end = $request->endDate;
        // $dwh = Dwh::get()->groupBy(['kantor_wilayah', 'wilayah_kerja']);
        $dwh = Dwh::selectRaw('kantor_wilayah, wilayah_kerja,
        SUM(CASE WHEN produk = "Kredit Kontra Bank Garansi" THEN 1 ELSE 0 END) as total_kbg,
        SUM(CASE WHEN produk = "Surety Bond" THEN 1 ELSE 0 END) as total_suretyship')
        ->groupBy('kantor_wilayah', 'wilayah_kerja')
        ->get()
        ->groupBy('kantor_wilayah');
        // return $dwh;

        return view('report.dwh.dwhExcel', compact('dwh', 'start', 'end'));
        // return view('report.customerPreview', compact('customer', 'messages', 'start', 'end'));
    }

    private function decryptssl($str, $key)
    {
        $str = base64_decode($str);
        // $key = base64_decode($key);
        $decrypted = openssl_decrypt($str, 'AES-128-ECB', $key,  OPENSSL_RAW_DATA);
        return $decrypted;
    }

    public function serviceIJP()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];

        $unitkerja = $this->getKanwil();
        $wilayah = $this->getWilker();
        // $lob = $this->getLob();
        // $lob = $lob['data_lob'];
        $getJnsPenerimaJaminan = $this->getJnsPenerimaJaminan();
        $getPenerimaJaminan = $this->getPenerimaJaminan();
        $getProduk = $this->getProduk();
        $polaPenjaminan = $this->polaPenjaminan();
        $jenisKur = $this->jenisKur();
        $jenisPenjaminan = $this->jenisPenjaminan();
        return view('report.dwh.service-ijp.service-ijp', compact('wilayah', 'lob', 'unitkerja', 'getJnsPenerimaJaminan', 'getPenerimaJaminan', 'getProduk', 'polaPenjaminan', 'jenisKur', 'jenisPenjaminan'));
    }

    public function getServiceIJP(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $dataIjp = json_decode($response,true);
        $data = $dataIjp['data_total'];
        // return $data;

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    public function getServiceIJPPdf(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);
        $dataPdf = $data['data_total'];

        return view('report.dwh.service-ijp.service-ijp-pdf', compact('dataPdf'));
    }

    public function getServiceIJPExcel(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);
        $dataPdf = $data['data_total'];

        return view('report.dwh.service-ijp.service-ijp-excel', compact('dataPdf'));
    }

    public function servicePDR008()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];

        $unitkerja = $this->getKanwil();
        $wilayah = $this->getWilker();
        // $lob = $this->getLob();
        // $lob = $lob['data_lob'];
        $getJnsPenerimaJaminan = $this->getJnsPenerimaJaminan();
        $getPenerimaJaminan = $this->getPenerimaJaminan();
        $getProduk = $this->getProduk();
        $polaPenjaminan = $this->polaPenjaminan();
        $jenisKur = $this->jenisKur();
        $jenisPenjaminan = $this->jenisPenjaminan();
        return view('report.dwh.service-ijp.service-ijp', compact('wilayah', 'lob', 'unitkerja', 'getJnsPenerimaJaminan', 'getPenerimaJaminan', 'getProduk', 'polaPenjaminan', 'jenisKur', 'jenisPenjaminan'));
    }

    public function getServicePDR008(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    public function servicePR001()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];

        $unitkerja = $this->getKanwil();
        $wilayah = $this->getWilker();
        // $lob = $this->getLob();
        // $lob = $lob['data_lob'];
        $getJnsPenerimaJaminan = $this->getJnsPenerimaJaminan();
        $getPenerimaJaminan = $this->getPenerimaJaminan();
        $getProduk = $this->getProduk();
        $polaPenjaminan = $this->polaPenjaminan();
        $jenisKur = $this->jenisKur();
        $jenisPenjaminan = $this->jenisPenjaminan();
        return view('report.dwh.service-ijp.service-ijp', compact('wilayah', 'lob', 'unitkerja', 'getJnsPenerimaJaminan', 'getPenerimaJaminan', 'getProduk', 'polaPenjaminan', 'jenisKur', 'jenisPenjaminan'));
    }

    public function getServicePR001(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    public function serviceSBR002()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];

        $unitkerja = $this->getKanwil();
        $wilayah = $this->getWilker();
        // $lob = $this->getLob();
        // $lob = $lob['data_lob'];
        $getJnsPenerimaJaminan = $this->getJnsPenerimaJaminan();
        $getPenerimaJaminan = $this->getPenerimaJaminan();
        $getProduk = $this->getProduk();
        $polaPenjaminan = $this->polaPenjaminan();
        $jenisKur = $this->jenisKur();
        $jenisPenjaminan = $this->jenisPenjaminan();
        return view('report.dwh.service-ijp.service-ijp', compact('wilayah', 'lob', 'unitkerja', 'getJnsPenerimaJaminan', 'getPenerimaJaminan', 'getProduk', 'polaPenjaminan', 'jenisKur', 'jenisPenjaminan'));
    }

    public function getServiceSBR002(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    public function servicePR004()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];

        $unitkerja = $this->getKanwil();
        $wilayah = $this->getWilker();
        // $lob = $this->getLob();
        // $lob = $lob['data_lob'];
        $getJnsPenerimaJaminan = $this->getJnsPenerimaJaminan();
        $getPenerimaJaminan = $this->getPenerimaJaminan();
        $getProduk = $this->getProduk();
        $polaPenjaminan = $this->polaPenjaminan();
        $jenisKur = $this->jenisKur();
        $jenisPenjaminan = $this->jenisPenjaminan();
        return view('report.dwh.service-ijp.service-ijp', compact('wilayah', 'lob', 'unitkerja', 'getJnsPenerimaJaminan', 'getPenerimaJaminan', 'getProduk', 'polaPenjaminan', 'jenisKur', 'jenisPenjaminan'));
    }

    public function getServicePR004(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/ijp003';
        $data = [
            'id_kanwil' => $request->wilayah,
            'id_uker' => $request->unit_kerja,
            'jenis_penerima_jaminan' => $request->jenis_penerima_jaminan,
            'penerima_jaminan' => $request->penerima_jaminan,
            'produk' => $request->id_produk,
            'pola_penjaminan' => $request->id_pola_penjaminan,
            'jenis_kur' => $request->id_jenis_kur,
            'jenis_penjaminan' => $request->id_jenis_penjaminan,
            'periode_awal' => $request->periodeawal,
            'periode_akhir' => $request->periodeakhir,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    public function serviceKLD()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];

        $unitkerja = $this->getKanwil();
        $wilayah = $this->getWilker();
        // $lob = $this->getLob();
        // $lob = $lob['data_lob'];
        $getJnsPenerimaJaminan = $this->getJnsPenerimaJaminan();
        $getPenerimaJaminan = $this->getPenerimaJaminan();
        $getProduk = $this->getProduk();
        $polaPenjaminan = $this->polaPenjaminan();
        $jenisKur = $this->jenisKur();
        $jenisPenjaminan = $this->jenisPenjaminan();
        return view('report.dwh.service-ijp.service-ijp', compact('wilayah', 'lob', 'unitkerja', 'getJnsPenerimaJaminan', 'getPenerimaJaminan', 'getProduk', 'polaPenjaminan', 'jenisKur', 'jenisPenjaminan'));
    }

    public function getServiceKLD(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh_service/kld001';
        $data = [
            'id_wilayah' => $request->wilayah,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'periode' => $request->periode,
            'id_lob' => $request->lob,
        ];

        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer ' . $token,
            'Content-Type: application/json'
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            // Mengatur batas waktu koneksi (dalam detik)
            // curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 120); // Batas waktu untuk koneksi (10 detik)

            // Mengatur batas waktu eksekusi total (dalam detik)
            // curl_setopt($ch, CURLOPT_TIMEOUT, 130); // Batas waktu total untuk permintaan (30 detik)

        // Eksekusi cURL
        $response = curl_exec($ch);

        // Memeriksa error pada cURL
        if (curl_errno($ch)) {
            return false;
        }

        curl_close($ch);

        // Mengubah JSON menjadi array PHPdd9
        $data = json_decode($response,true);

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    private function getToken(){
        
        $url = "http://172.27.1.52:5252/hris/api/auth/signin";

        // Data yang akan dikirimkan
        $data = [
            'username' => "01342",
            'password' => "Jamkrindo123",
        ];
        
        // Inisialisasi cURL
        $ch = curl_init($url);
        
        // Set opsi cURL untuk permintaan POST
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set header Content-Type ke application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Accept: application/json',
        ]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data)); // Encode data menjadi URL-encoded format
        
        // Eksekusi permintaan dan ambil respons 
        $response = curl_exec($ch);
        
        // Periksa apakah ada error
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }

        // Mendapatkan status kode HTTP
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        // Tutup cURL
        curl_close($ch);
        
        // Decode respons JSON
        return $responseData = json_decode($response, true);
    }

    private function getWilker(){
        $url = "http://172.27.1.52:5252/dwh_api/master/wilker";
        
        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $responseData = json_decode($response, true);
        $wilayah = $responseData['data_wilker'];
        return $wilayah;
    }
    
    private function getKanwil()
    {    
        $url = "http://172.27.1.52:5252/dwh_api/master/kanwil";
        
        // Inisialisasi cURL
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        $responseData = json_decode($response, true);
        $wilayah = $responseData['data_kanwil'];
        return $wilayah;
    }

    private function getLob()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/lob";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_lob'];
        return $dataLob;
    }

    private function getJnsPenerimaJaminan()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/jenispenerimajaminan";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        $lob = $dataLob['data_jenis_penerima_jaminan'];
        return $lob;
    }

    private function getPenerimaJaminan()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/penerimajaminan";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        return $dataLob['data_penerima_jaminan'];
    }

    private function getProduk()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/produk";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        return $dataLob['data_produk'];
    }

    private function polaPenjaminan()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/polapenjaminan";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        return $dataLob['data_pola_penjaminan'];
    }

    private function jenisKur()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/jeniskur";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        return $dataLob['data_jenis_kur'];
    }

    private function jenisPenjaminan()
    {
        $urllob = "http://172.27.1.52:5252/dwh_api/master/jenispenjaminan";
        // Inisialisasi cURL
        $chLob = curl_init($urllob);
        curl_setopt($chLob, CURLOPT_RETURNTRANSFER, true);
        $responseLob = curl_exec($chLob);
        if (curl_errno($chLob)) {
            echo 'Error:' . curl_error($chLob);
        }
        $httpCodeLob = curl_getinfo($chLob, CURLINFO_HTTP_CODE);
        curl_close($chLob);
        $dataLob = json_decode($responseLob, true);
        return $dataLob['data_jenis_penjaminan'];
    }
}


?>