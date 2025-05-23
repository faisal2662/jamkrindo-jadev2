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
    public function index()
    {
        $products = Product::where('is_delete', 'N')->get();
        $branchs = Branch::where('is_delete', 'N')->get();
        $regions = Regional::where('is_delete', 'N')->get();
        if(Auth::user()->id_role == 1){
            $customers = Customer::where('is_delete', 'N')->get();
        }else {
            $customers = Customer::where('kd_cabang', Auth::user()->id_branch)->where('is_delete', 'N')->get();
        }
        
        $percakapan = Percakapan::where('kd_customer', Auth::user()->kd_customer)->first();
        // return $percakapan;

        return view('index', compact(['customers', 'branchs', 'regions', 'products', 'percakapan']));
    }
}