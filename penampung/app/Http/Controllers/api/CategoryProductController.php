<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;

class CategoryProductController extends Controller
{
    public function getCategories()
    {
        $categories = CategoryProduct::where('is_delete', 'N')
            ->get()
            ->map(function ($item) {
                if (!preg_match('/https?:\/\//', $item->icon_kategori) && !is_null($item->icon_kategori)) {
                    $item->icon_kategori = url('assets/img/icon-category/'.$item->icon_kategori);
                }
                return $item;
            });

        return response()->json([
            'data' => $categories
        ]);
    }

    public function getCategory($id)
    {
        $category = CategoryProduct::with([
                'products' => function ($query) {
                    return $query->where('is_delete', 'N');
                }
            ])
            ->findOrFail($id);

        return response()->json([
            'data' => $category
        ]);
    }
}