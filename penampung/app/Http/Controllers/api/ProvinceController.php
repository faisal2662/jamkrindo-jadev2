<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Province;
use App\Models\City;

class ProvinceController extends Controller
{
    public function getProvinces()
    {
        $provinces = Province::with([
                'City' => function ($query) {
                    $query->where('is_delete', 'N');
                }
            ])
            ->where('is_delete', 'N')
            ->get();

        return response()->json([
            'data' => $provinces
        ]);
    }
}