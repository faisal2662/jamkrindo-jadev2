<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class ReportDWHController extends Controller
{
    public function volumePenjaminan()
    {
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

        return view('report.dwh.volume-penjaminan.volume-penjaminan', compact('wilayah', 'lob'));
    }

    public function getVolumePenjaminan(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh/volume/0/0';
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
        $getData = json_decode($response,true);
        $data = $getData['data_dwh'];

        $no = 1;
        // foreach($data as $dw){
        //     $dw->no = $no++;
        // }

        return datatables::of($data)->escapecolumns([])->make(true);
    }

    public function getVolumePenjaminanPdf(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh/volume/0/0';
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
        $dataPdf = $data['data_dwh'];
        // return $data;

        return view('report.dwh.volume-penjaminan.volume-penjaminan-pdf', compact('dataPdf'));
    }

    public function getVolumePenjaminanExcel(Request $request)
    {
        $getToken = $this->getToken();
        $token = $getToken['token'];

        $url = 'http://172.27.1.52:5252/dwh/volume/0/0';
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
        $dataPdf = $data['data_dwh'];
        // return $data;

        return view('report.dwh.volume-penjaminan.volume-penjaminan-excel', compact('dataPdf'));
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