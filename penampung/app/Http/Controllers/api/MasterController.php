<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Mail;
use App\Models\Branch;
use App\Models\Business;
use App\Models\Customer;
use App\Models\Regional;
use App\Mail\ResetPasswordOTPSending;

class MasterController extends Controller
{
    public function branch()
    {
        $data = Branch::with('wilayah')->where('is_delete', 'N')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function region()
    {
        $data = Regional::with(['Provinsi', 'Kota'])->where('is_delete', 'N')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }

    public function customer()
    {
        $data = Customer::where('is_delete', 'N')->get();
        return response()->json(['status' => 'success', 'data' => $data]);
    }
}
