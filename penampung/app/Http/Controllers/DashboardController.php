<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Regional;
use App\Models\Customer;
use App\Models\Percakapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    //
    public function index(Request $request)
    {

        $products = Product::where('is_delete', 'N')->get();
        $branchs = Branch::where('is_delete', 'N')->get();
        $regions = Regional::where('is_delete', 'N')->get();
        if(Auth::user()->id_role == 1){

            $customers = Customer::where('is_delete', 'N')->get();
        }else {
            $customers = Customer::where('kd_cabang', Auth::user()->branch_code)->where('is_delete', 'N')->get();
        }
        $percakapan = Percakapan::where('kd_customer', Auth::user()->kd_customer)->first();
// Mengelompokkan data berdasarkan bulan
// $monthlyData = [];

// foreach ($customers as $data) {
//     // Mengambil tanggal dan mengonversinya ke objek DateTime
//     $date = date('F Y',strtotime($data['created_date']));


//     // Mengambil bulan dan tahun dalam format "NamaBulan Tahun"
//     $monthYear = $date; // Contoh: "December 2024"

//     // Pastikan count adalah angka
//     // $count = (int)$data['count']; // Mengonversi count menjadi integer

//     // Mengelompokkan data
//     if (!isset($monthlyData[$monthYear])) {
//         $monthlyData[$monthYear] = 0;
//     }
//     $monthlyData[$monthYear] += 1; // Menambahkan jumlah pelanggan
// }

// // Memeriksa data yang dikelompokkan
// print_r($monthlyData); // Menampilkan hasil pengelompokan

// // Mengubah objek menjadi array untuk grafik
// $categories = array_keys($monthlyData);
// $seriesData = array_values($monthlyData);

// // Menampilkan kategori dan data untuk grafik
// echo "Categories: " . implode(", ", $categories) . "\n";
// echo "Series Data: " . implode(", ", $seriesData) . "\n";die;
        return view('index', compact(['customers', 'branchs', 'regions', 'products', 'percakapan']));
    }
}
