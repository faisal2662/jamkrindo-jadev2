<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryComplaintController extends Controller
{
    public function getCategories()
    {
        return [
            [
                'id' => 1,
                'name' => 'Bisnis'
            ],
            [
                'id' => 2,
                'name' => 'Klaim'
            ],
            [
                'id' => 3,
                'name' => 'Peraturan'
            ],
            [
                'id' => 4,
                'name' => 'Dan Lainnya'
            ]
        ];
    }
}
