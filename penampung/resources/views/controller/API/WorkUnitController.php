<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\API\KantorPusat;
use App\Models\API\KantorCabang;
use App\Models\API\KantorWilayah;

class WorkUnitController extends Controller
{
    public function getWorkUnits()
    {
        $headOffices = KantorPusat::where('delete_kantor_pusat', 'N')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'head_office',
                    'id' => $item->id_kantor_pusat,
                    'name' => $item->nama_kantor_pusat
                ];
            })
            ->toArray();

        $branchOffices = KantorCabang::where('delete_kantor_cabang', 'N')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'branch_office',
                    'id' => $item->id_kantor_cabang,
                    'name' => $item->nama_kantor_cabang
                ];
            })
            ->toArray();

        $regionalOffices = KantorWilayah::where('delete_kantor_wilayah', 'N')
            ->get()
            ->map(function ($item) {
                return [
                    'type' => 'regional_office',
                    'id' => $item->id_kantor_wilayah,
                    'name' => $item->nama_kantor_wilayah
                ];
            })
            ->toArray();

        return array_merge($headOffices, $branchOffices, $regionalOffices);
    }
}
