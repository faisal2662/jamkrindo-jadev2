<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    public function getCategories()
    {
        return [
            [
                'id' => 1,
                'parent_name' => 'KUR',
                'name' => 'Produk KUR'
            ],
            [
                'id' => 2,
                'parent_name' => 'KBG & Suretyship',
                'name' => 'Custom Bond'
            ],
            [
                'id' => 3,
                'parent_name' => 'KBG & Suretyship',
                'name' => 'KBG'
            ],
            [
                'id' => 4,
                'parent_name' => 'KBG & Suretyship',
                'name' => 'Surety Bond'
            ],
            [
                'id' => 5,
                'parent_name' => 'KBG & Suretyship',
                'name' => 'Payment Bond'
            ],
            [
                'id' => 6,
                'parent_name' => 'Produktif',
                'name' => 'ATMR'
            ],
            [
                'id' => 7,
                'parent_name' => 'Produktif',
                'name' => 'Keagenan Kargo'
            ],
            [
                'id' => 8,
                'parent_name' => 'Produktif',
                'name' => 'KKPE'
            ],
            [
                'id' => 9,
                'parent_name' => 'Produktif',
                'name' => 'Kontruksi'
            ],
            [
                'id' => 10,
                'parent_name' => 'Produktif',
                'name' => 'Mikro'
            ],
            [
                'id' => 11,
                'parent_name' => 'Produktif',
                'name' => 'Distribusi Barang'
            ],
            [
                'id' => 12,
                'parent_name' => 'Produktif',
                'name' => 'Pembiayaan Invoice'
            ],
            [
                'id' => 13,
                'parent_name' => 'Produktif',
                'name' => 'Subsidi Resi Gudang'
            ],
            [
                'id' => 14,
                'parent_name' => 'Produktif',
                'name' => 'Super Mikro'
            ],
            [
                'id' => 15,
                'parent_name' => 'Produktif',
                'name' => 'Umum'
            ],
            [
                'id' => 16,
                'parent_name' => 'Produktif',
                'name' => 'FLPP'
            ],
            [
                'id' => 17,
                'parent_name' => 'Produktif',
                'name' => 'OTO'
            ],
            [
                'id' => 18,
                'parent_name' => 'Produktif',
                'name' => 'KPR'
            ],
            [
                'id' => 19,
                'parent_name' => 'Produktif',
                'name' => 'Multiguna'
            ],
            [
                'id' => 20,
                'parent_name' => 'Produktif',
                'name' => 'KSM'
            ],
            [
                'id' => 21,
                'parent_name' => 'Produktif',
                'name' => 'Mandiri'
            ],
            [
                'id' => 22,
                'parent_name' => 'Produktif',
                'name' => 'Briguna'
            ]
        ];
    }
}
