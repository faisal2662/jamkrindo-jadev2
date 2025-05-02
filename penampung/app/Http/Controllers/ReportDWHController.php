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
        $getData = json_decode($response, true);
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
        $data = json_decode($response, true);
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
        $data = json_decode($response, true);
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
        $dataIjp = json_decode($response, true);
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
        $data = json_decode($response, true);
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
        $data = json_decode($response, true);
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
        $data = json_decode($response, true);

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
        $data = json_decode($response, true);

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
        $data = json_decode($response, true);

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
        $data = json_decode($response, true);

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
        $data = json_decode($response, true);

        return datatables::of($data['data_dwh'])->escapecolumns([])->make(true);
    }

    private function getToken()
    {

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

    private function getWilker()
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


    public function serviceSPD(Request $request)
    {
        $filter = $request->filter;

        if ($filter == 'true') {


            $data = [
                [
                    "kantor_wilayah" => "Makassar",
                    "wilayah_kerja" => "Kantor Cabang Manado",
                    "no_surat" => "SUR-1234/AB",
                    "tgl_akad" => "2023-08-15",
                    "nama_proyek" => "Proyek A",
                    "id_dc_peruntukan_kredit" => 101,
                    "penerima_jaminan" => "PT. PUTERA PETIR PERKASA",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Karyawan",
                    "ktp" => "3214567890123456",
                    "npwp" => "123456789012345",
                    "nasabah" => "KETUT SUARDIKA",
                    "nomor_sp" => "SP001/2023",
                    "tgl_sp" => "2023-08"
                ],
                [
                    "kantor_wilayah" => "Makassar",
                    "wilayah_kerja" => "Kantor Cabang Manado",
                    "no_surat" => "SUR-1234/AB",
                    "tgl_akad" => "2023-08-15",
                    "nama_proyek" => "Proyek A",
                    "id_dc_peruntukan_kredit" => 101,
                    "penerima_jaminan" => "CV. Giram Talang",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Karyawan",
                    "ktp" => "3214567890123456",
                    "npwp" => "123456789012345",
                    "nasabah" => "Ferdinand",
                    "nomor_sp" => "SP001/2023",
                    "tgl_sp" => "2023-08"
                ],
                [
                    "kantor_wilayah" => "Makassar",
                    "wilayah_kerja" => "Kantor Cabang Pare-Pare",
                    "no_surat" => "SUR-1234/AB",
                    "tgl_akad" => "2023-08-15",
                    "nama_proyek" => "Proyek A",
                    "id_dc_peruntukan_kredit" => 101,
                    "penerima_jaminan" => "CV. Tri Putra Sinambela",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Karyawan",
                    "ktp" => "3214567890123456",
                    "npwp" => "123456789012345",
                    "nasabah" => "Hotlan Sinambela",
                    "nomor_sp" => "SP001/2023",
                    "tgl_sp" => "2023-08"
                ],
                [
                    "kantor_wilayah" => "Banjarmasin",
                    "wilayah_kerja" => "Kantor Cabang Palangkaraya",
                    "no_surat" => "SUR-5678/CD",
                    "tgl_akad" => "2023-09-10",
                    "nama_proyek" => "Proyek B",
                    "id_dc_peruntukan_kredit" => 102,
                    "penerima_jaminan" => "PT. Jaminan XYZ",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Rumah",
                    "ktp" => "3214567890123467",
                    "npwp" => "123456789012346",
                    "nasabah" => "Alia Putri",
                    "nomor_sp" => "SP002/2023",
                    "tgl_sp" => "2023-09"
                ],
                [
                    "kantor_wilayah" => "Denpasar",
                    "wilayah_kerja" => "Kantor Cabang Sumbawa Besar",
                    "no_surat" => "SUR-9101/EF",
                    "tgl_akad" => "2023-07-20",
                    "nama_proyek" => "Proyek C",
                    "id_dc_peruntukan_kredit" => 103,
                    "penerima_jaminan" => "CV. ANTHO JAYA PERKASA",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Pendidikan",
                    "ktp" => "3214567890123478",
                    "npwp" => "123456789012347",
                    "nasabah" => "Rianto",
                    "nomor_sp" => "SP003/2023",
                    "tgl_sp" => "2023-07"
                ],
                [
                    "kantor_wilayah" => "Surabaya",
                    "wilayah_kerja" => "Kantor Cabang Malang",
                    "no_surat" => "SUR-1122/GH",
                    "tgl_akad" => "2023-08-05",
                    "nama_proyek" => "Proyek D",
                    "id_dc_peruntukan_kredit" => 104,
                    "penerima_jaminan" => "CV. FAUZAN PUTRA MABRUR",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Usaha",
                    "ktp" => "3214567890123489",
                    "npwp" => "123456789012348",
                    "nasabah" => "Kamal Akbar Latif",
                    "nomor_sp" => "SP004/2023",
                    "tgl_sp" => "2023-08"
                ],
                [
                    "kantor_wilayah" => "Semarang",
                    "wilayah_kerja" => "Kantor Cabang Semarang",
                    "no_surat" => "SUR-3344/IJ",
                    "tgl_akad" => "2023-06-15",
                    "nama_proyek" => "Proyek E",
                    "id_dc_peruntukan_kredit" => 105,
                    "penerima_jaminan" => "PT MITRA AGUNG INDONESIA",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Modal",
                    "ktp" => "3214567890123490",
                    "npwp" => "123456789012349",
                    "nasabah" => "PT MITRA AGUNG INDONESIA",
                    "nomor_sp" => "SP005/2023",
                    "tgl_sp" => "2023-06"
                ],
                // ======
                [
                    "kantor_wilayah" => "Makassar",
                    "wilayah_kerja" =>     "Kantor Cabang Palopo",
                    "no_surat" => "SUR-1234/AB",
                    "tgl_akad" => "2023-08-15",
                    "nama_proyek" => "Proyek A",
                    "id_dc_peruntukan_kredit" => 101,
                    "penerima_jaminan" => "CV. PARAHITA MULTIGUNA",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Karyawan",
                    "ktp" => "3214567890123456",
                    "npwp" => "123456789012345",
                    "nasabah" => "ISMAWATI SURIPTO",
                    "nomor_sp" => "SP001/2023",
                    "tgl_sp" => "2023-08"
                ],
                [
                    "kantor_wilayah" => "Banjarmasin",
                    "wilayah_kerja" => "Kantor Cabang Balikpapan",
                    "no_surat" => "SUR-5678/CD",
                    "tgl_akad" => "2023-09-10",
                    "nama_proyek" => "Proyek B",
                    "id_dc_peruntukan_kredit" => 102,
                    "penerima_jaminan" => "PT ARTHA LESTARI ENGINEERING",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Rumah",
                    "ktp" => "3214567890123467",
                    "npwp" => "123456789012346",
                    "nasabah" => "PT ARTHA LESTARI ENGINEERING",
                    "nomor_sp" => "SP002/2023",
                    "tgl_sp" => "2023-09"
                ],
                [
                    "kantor_wilayah" => "Denpasar",
                    "wilayah_kerja" => "Kantor Cabang Kupang",
                    "no_surat" => "SUR-9101/EF",
                    "tgl_akad" => "2023-07-20",
                    "nama_proyek" => "Proyek C",
                    "id_dc_peruntukan_kredit" => 103,
                    "penerima_jaminan" => "CV. ANTHO JAYA PERKASA",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Pendidikan",
                    "ktp" => "3214567890123478",
                    "npwp" => "123456789012347",
                    "nasabah" => "Rianto",
                    "nomor_sp" => "SP003/2023",
                    "tgl_sp" => "2023-07"
                ],
                [
                    "kantor_wilayah" => "Surabaya",
                    "wilayah_kerja" => "Kantor Cabang Madiun",
                    "no_surat" => "SUR-1122/GH",
                    "tgl_akad" => "2023-08-05",
                    "nama_proyek" => "Proyek D",
                    "id_dc_peruntukan_kredit" => 104,
                    "penerima_jaminan" => "CV. Zeus Perkasa",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Usaha",
                    "ktp" => "3214567890123489",
                    "npwp" => "123456789012348",
                    "nasabah" => "Deddy Winata",
                    "nomor_sp" => "SP004/2023",
                    "tgl_sp" => "2023-08"
                ],
                [
                    "kantor_wilayah" => "Semarang",
                    "wilayah_kerja" => "Kantor Cabang Yogyakarta",
                    "no_surat" => "SUR-3344/IJ",
                    "tgl_akad" => "2023-06-15",
                    "nama_proyek" => "Proyek E",
                    "id_dc_peruntukan_kredit" => 105,
                    "penerima_jaminan" => "CV. Inaka",
                    "lob" => "Kredit",
                    "produk" => "Pinjaman Modal",
                    "ktp" => "3214567890123490",
                    "npwp" => "123456789012349",
                    "nasabah" => "Harliem Tjandra Edyanto",
                    "nomor_sp" => "SP005/2023",
                    "tgl_sp" => "2023-06"
                ]
                // Tambahkan lebih banyak data sesuai kebutuhan
            ];
            foreach ($data as &$dt) {
                $dt['company_name'] = rtrim(strtolower(preg_replace("/[\s.]+/", "", $dt['penerima_jaminan'])));
            }
            unset($dt);

            $dataInternal = [];

            $customer = Customer::where('is_delete', 'N')->select('kd_customer', 'nama_customer', 'company_name', 'userid_customer')->get();

            $filteredCustomers = $customer->map(function ($item) {
                $item->company_name = $item->company_name ?? 'kosong';
                $item->penerima_jaminan = rtrim(strtolower(preg_replace("/[\s.]+/", "", $item->company_name)));
                return $item;
            });

            $result = $filteredCustomers->unique('penerima_jaminan');
            $dataInternal = $result;

            $resultData = [];

            foreach ($dataInternal as $item) {
                foreach ($data as $dt) {
                    if ($dt['company_name'] == $item->penerima_jaminan) {
                        $resultData[] = [
                            'nama_customer' => $dt['nasabah'],
                            'employee_name' => $item->company_name,
                            'nomor_sp' => $dt['nomor_sp'],
                            'wilayah_kerja' => $dt['wilayah_kerja'],
                            'kantor_wilayah' => $dt['kantor_wilayah']
                        ];
                        break;
                    }
                }
            }
            $wilayah  =  [];
            $arrWilayah  =  [];
            $cabang = [];
            $arrCabang = [];
            // return $resultData;
            $nasabahPerWilayah = [];

            foreach ($resultData as $dt) {
                $wilayah = $dt['kantor_wilayah'];
                $cabang = $dt['wilayah_kerja'];

                // Inisialisasi wilayah jika belum ada
                if (!isset($nasabahPerWilayah[$wilayah])) {
                    $nasabahPerWilayah[ $wilayah] = [];
                }

                // Hitung jumlah nasabah per cabang
                if (!isset($nasabahPerWilayah[$wilayah][$cabang])) {
                    $nasabahPerWilayah[$wilayah][$cabang] = 0;
                }

                $nasabahPerWilayah[$wilayah][$cabang]++;
            }

            // Format ulang hasil agar sesuai dengan yang diinginkan
            $formattedResult = [];
            foreach ($nasabahPerWilayah as $wilayah => $cabangData) {
                $formattedCabang = [];
                foreach ($cabangData as $cabang => $jumlah) {
                    $total = ($jumlah / 100) * 100;
                    $formattedCabang[] = [$cabang => $jumlah, 'total' => $total];
                }
                $formattedResult[$wilayah] = $formattedCabang;
            }

            $data = $formattedResult;
            // $data = json_encode($formattedResult, JSON_PRETTY_PRINT);
        }else{

            $data = [];
        }
        return view('report.dwh.service-spd.index', compact('data'));
    }
}
