<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    public function getNews(Request $request)
    {
        $newsQuery = News::query();

        if ($request->filled('limit')) {
            $newsQuery->limit($request->get('limit'));
        }

        $news = $newsQuery->where('is_delete', 'N')
            ->get()
            ->map(function ($item) {
                if (!preg_match('/https?:\/\//', $item->foto_berita)) {
                    $item->news_img = 'https://www.jamkrindo.co.id/'.$item->news_img;
                }
                return $item;
            });

        return response()->json([
            'data' => $news
        ]);
    }

    public function getNewsDetail($id)
    {
        $news = News::findOrFail($id);
        if (!preg_match('/https?:\/\//', $news->foto_berita)) {
           $news->news_img = 'https://www.jamkrindo.co.id/'.$news->news_img;
        }
        // $news->isi_berita = str_replace('../../assets', url('').'/assets', $news->isi_berita);

        return response()->json([
            'data' => $news
        ]);
    }

    /* old */
    // public function getNews(Request $request)
    // {
    //     $newsQuery = News::query();

    //     if ($request->filled('limit')) {
    //         $newsQuery->limit($request->get('limit'));
    //     }

    //     $news = $newsQuery->where('is_delete', 'N')
    //         ->get()
    //         ->map(function ($item) {
    //             if (!preg_match('/https?:\/\//', $item->foto_berita)) {
    //                 $item->foto_berita = url('assets/img/news/'.$item->foto_berita);
    //             }
    //             return $item;
    //         });

    //     return response()->json([
    //         'data' => $news
    //     ]);
    // }

    // public function getNewsDetail($id)
    // {
    //     $news = News::findOrFail($id);
    //     if (!preg_match('/https?:\/\//', $news->foto_berita)) {
    //         $news->foto_berita = url('assets/img/news/'.$news->foto_berita);
    //     }
    //     $news->isi_berita = str_replace('../../assets', url('').'/assets', $news->isi_berita);

    //     return response()->json([
    //         'data' => $news
    //     ]);
    // }
}
