<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\carbon;
use App\Models\News;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NewManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 16)->first();
        if($role->can_access == 'N'){
            return redirect()->route('dashboard');
         }
        return view('news-management.index', compact('role'));
    }
    public function indexOld()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 16)->first();
        return view('news-management.index', compact('role'));
    }


    public function getDataOld()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 16)->first();
        $news = News::where('is_delete', 'N')->orderBy('created_date', 'desc')->get();

        $no = 1;

        foreach ($news as $item) {

            $item->no = $no++;
            $formattedDate = Carbon::parse($item->tgl_berita)->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB';

            $item->tgl_upload = $formattedDate;

            if ($item->status_berita == "Publish") {
                $item->status_berita =  " <span class='badge bg-success'> " . $item->status_berita . "</span> ";
            } else {
                $item->status_berita =  " <span class='badge bg-warning'> " . $item->status_berita . "</span> ";
            }

            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $item->action = "<a href='news-management/lihat/" . $item->id_berita . "' class='btn'><i
                                                    class='bi bi-search'></i></a> 
                                                    <a href='news-management/edit/" . $item->id_berita . "' class='btn'><i
                                                    class='bi bi-pencil-square'></i></a>
                                                    
                                                     <button class='btn btn-sm fw-bold' onclick='newsDelete(\"" . $item->id_berita . "\" )'><i
                                                    class='bi bi-trash' ></i></button>";
            } else if ($role->can_update == 'Y') {
                $item->action = "<a href='news-management/lihat/" . $item->id_berita . "' class='btn'><i
                                                    class='bi bi-search'></i></a> 
                                                    <a href='news-management/edit/" . $item->id_berita . "' class='btn'><i
                                                    class='bi bi-pencil-square'></i></a>";
            } else if ($role->can_delete == 'Y') {
                $item->action = "<a href='news-management/lihat/" . $item->id_berita . "' class='btn'><i
                                                    class='bi bi-search'></i></a> 
                                                    
                                                     <button class='btn btn-sm fw-bold' onclick='newsDelete(\"" . $item->id_berita . "\" )'><i
                                                    class='bi bi-trash' ></i></button>";
            } else {
                $item->action = "<a href='news-management/lihat/" . $item->id_berita . "' class='btn'><i
                                                    class='bi bi-search'></i></a>";
            }
        }

        return datatables::of($news)->escapeColumns([])->make(true);
    }



    public function getData()
    {
        $category = DB::connection('mysql_second')->table('category')->get();
        $news = DB::connection('mysql_second')->table('news')->leftJoin('category', 'category.id', 'news.news_category')->where('news_status', 1)->orderBy('news.created_at', 'desc')->select('news.*', 'category.category_name as category')->get();
        // return $news;

        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 16)->first();
        // $news = DB::table('m_berita_new')->where('m_berita_new.is_delete', 'N')->orderBy('m_berita_new.created_date', 'desc')->leftJoin('m_category_news', 'm_berita_new.news_category', 'm_category_news.id_category_news_server')
        //     ->select('m_berita_new.*', 'm_category_news.category_name as category')->get();
        $no = 1;
        foreach ($news as $data) {
            $data->no = $no++;
            $data->action = "<a href='news-management/lihat/" . $data->id . "' class='btn'><i
                                                    class='bi bi-search'></i></a>";
            if ($data->news_status == 1) {
                $data->status  = '<span class="badge bg-success">Aktif</span>';
            } else {
                $data->status  = '<span class="badge bg-warning">Tidak Aktif</span>';
            }
        }
        return datatables::of($news)->escapeColumns([])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        return view('news-management.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        // dd($request);
        if ($request['banner_berita']) {
            $rand = random_int(1000, 9999);
            $filename = 'banner-' . uniqid() . '-' . $request->title_berita . '.' . $request['banner_berita']->getClientOriginalExtension();
            $file  = $request->file('banner_berita');
            $file->move(base_path('../assets/img/news'),  $filename);
        }
        $news = new News();
        $news->judul_berita = $request->title_berita;
        $news->tgl_berita = $request->tgl_upload;
        $news->status_berita = $request->status_berita;
        $news->isi_berita = $request->deskripsi_berita;
        $news->foto_berita = $filename;
        $news->created_by = Auth::user()->nm_user;
        $news->is_delete = "N";
        $news->save();
        unset($news['id_berita']);
        unset($news['is_delete']);
        // unset($branch['url_location']);
        $this->logAuditTrail('create', $news, null, $news->toArray());
        return redirect()->route('news-manager.index')->with('success', 'Data Berhasil Disimpan');
    }

    public function uploadGambar(Request $request)
    {
        $baseDomain = url('/');
        if ($request->hasFile('file')) {
            $file = $request['file'];
            $filename = time() . '_' . $file->getClientOriginalName();
            // $file->move(public_path('uploads'), $filename);
            $file->move(base_path('../assets/img/news'),  $filename);
            // Mengirimkan kembali lokasi file yang telah diupload
            return response()->json([
                'location' =>  "/../assets/img/news/$filename",
                'filename' => $filename
            ]);
        }

        return response()->json(['error' => 'Upload gagal'], 400);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showOld($id)
    {
        //
        $news = News::where('id_berita', $id)->first();
        $formattedDate = Carbon::parse($news->tgl_berita)->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB';
        return view('news-management.show', compact('news', 'formattedDate'));
    }

    public function show($id)
    {
        //

        // $news = DB::table('m_berita_new')->where('id_news', $id)->leftJoin('m_category_news', 'm_berita_new.news_category', 'm_category_news.id_category_news_server')->select('m_berita_new.*', 'm_category_news.category_name')->first();
        // $formattedDate = Carbon::parse($news->created_date)->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB';
        $news = DB::connection('mysql_second')->table('news')->where('news.id', $id)->leftJoin('category', 'news.news_category', 'category.id')->select('news.*', 'category.category_name')->first();
        // return $news;
        $formattedDate = Carbon::parse($news->created_at)->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB';
        return view('news-management.show', compact('news', 'formattedDate'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $news = News::where('id_berita', $id)->first();
        return view('news-management.edit', compact('news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        // dd($request);
        $news =  News::where('id_berita', $id)->first();
        $dataLama = $news;
        $dataRequest =  $request->except(['_token']);
        if ($request['foto_berita']) {
            $rand = random_int(1000, 9999);
            $filename = 'banner-' . uniqid() . '-' . $request->judul_berita . '.' . $request['foto_berita']->getClientOriginalExtension();
            $file  = $request->file('foto_berita');
            $file->move(base_path('../assets/img/news'),  $filename);
            $news->foto_berita = $filename;
        }
        $dataRequest['foto_berita'] =  $filename;
        $dataOld = json_decode(json_encode($dataLama), true);
        $dataNew = json_decode(json_encode($dataRequest), true);
        $baru =  array_diff_assoc($dataNew, $dataOld); // Nilai di $dataNew yang tidak ada di $dataOld
        $lama =  array_diff_assoc($dataOld, $dataNew); // Nilai di $dataOld yang tidak ada di $dataNew


        $news->judul_berita = $request->judul_berita;
        $news->tgl_berita = $request->tgl_berita;
        $news->status_berita = $request->status_berita;
        $news->isi_berita = $request->isi_berita;

        $news->updated_by = Auth::user()->nm_user;
        $news->update();
        $this->logAuditTrail('update', $news, $lama, $baru);

        return redirect()->route('news-manager.index')->with('success', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $date = Carbon::now();
        $news = News::where('id_berita', $id)->first();
        $dataLama = $news;
        $news->is_delete = "Y";
        $news->deleted_date = $date;
        $news->deleted_by = Auth::user()->nm_user;
        $news->update();

        unset($dataLama['id_berita']);
        unset($dataLama['is_delete']);

        $this->logAuditTrail('delete', $news, $dataLama, null);
        // return redirect()->route('news-manager.index')->with('success', 'Berhasil Dihapus');
        return response()->json(['status' => 'success'], 200);
    }

    public function movingData()
    {
        $content_old = DB::connection('mysql_second')->table('news')->get()->toArray();
        $category_content_old = DB::connection('mysql_second')->table('category')->get();
        foreach($category_content_old as $ctgry){
          
            $cekCategory = DB::table('m_category_news')->where('id_category_news_server', $ctgry->id)->first();
            if(is_null($cekCategory)){ 
                $d = [
                    'id_category_news_server' => $ctgry->id,
                    'category_name' => $ctgry->category_name,
                    'category_menu' => $ctgry->category_menu,
                    'category_url' => $ctgry->category_url,
                    'category_name_eng' => $ctgry->category_name_eng,
                    'created_date' => $ctgry->created_at,
                    'created_by' => 'auto',
                ];

                try {
                    //code...
                    $category = DB::table('m_category_news')->insert($d);
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json(['error' => $th->getMessage()],402);
                }
            }else {
                $d = [
                    'id_category_news_server' => $ctgry->id,
                    'category_name' => $ctgry->category_name,
                    'category_menu' => $ctgry->category_menu,
                    'category_url' => $ctgry->category_url,
                    'category_name_eng' => $ctgry->category_name_eng,
                    'updated_date' =>$ctgry->updated_at, 
                    'updated_by' => 'auto',
                ];
                try {
                    //code... 
                    $category = DB::table('m_category_news')->where('id_category_news_server', $ctgry->id)->update($d);
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json(['error' => $th->getMessage()], 402);
                } 

            }
        }
       
        foreach ($content_old as $data) {
        
            $cekContent = DB::table('m_berita_new')->where('id_news_server', $data->id)->first();
     
            if (is_null($cekContent)) {
                try {
                  
                    $d = [
                    'id_news_server' => $data->id,
                    'news_category' => $data->news_category,
                    'news_title' => $data->news_title,
                    'news_content' => $data->news_content,
                    'news_treaser' => $data->news_teaser,
                    'news_img' => $data->news_img,
                    'news_video' => $data->news_video,
                    'news_tag' => $data->news_tag,
                    'news_status' => $data->news_status,
                    'news_pageview' =>$data->news_pageview,
                    'news_title_eng' => $data->news_title_eng,
                    'news_content_eng' => $data->news_content_eng,
                    'news_treaser_eng' => $data->news_teaser_eng,
                    'news_url' => $data->news_url,
                    'meta_description' => $data->meta_description,
                    'meta_description_eng' => $data->meta_description_eng,
                    'last_sync' => Carbon::now(),
                    'created_date' => $data->created_at,
                    'created_by' => 'auto'
                    ];
                  
                    $content  =   DB::table('m_berita_new')->insert($d);
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json($th->getMessage());
                }
            }else {
                
                    $d = [
                        'id_news_server' => $data->id,
                        'news_category' => $data->news_category,
                        'news_title' => $data->news_title,
                        'news_content' => $data->news_content,
                        'news_treaser' => $data->news_teaser,
                        'news_img' => $data->news_img,
                        'news_video' => $data->news_video,
                        'news_tag' => $data->news_tag,
                        'news_status' => $data->news_status,
                        'news_pageview' =>$data->news_pageview,
                        'news_title_eng' => $data->news_title_eng,
                        'news_content_eng' => $data->news_content_eng,
                        'news_treaser_eng' => $data->news_teaser_eng,
                        'news_url' => $data->news_url,
                        'meta_description' => $data->meta_description,
                        'meta_description_eng' => $data->meta_description_eng,
                        'last_sync' => Carbon::now(),
                        'created_date' => $data->created_at,
                        'created_by' => 'auto'
                        ];
                        try {
                    $content  =   DB::table('m_berita_new')->where('id_news_server', $data->id)->update($d);
                } catch (\Throwable $th) {
                    //throw $th;
                    return response()->json($th->getMessage(), 402);
                }

            }

        } 
        return reponse()->json(['status' => 'success', 'message' => 'Sync Berhasil'], 200);
    }
}
