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
        return view('news-management.index', compact('role'));
    }


    public function getData()
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
    public function show($id)
    {
        //
        $news = News::where('id_berita', $id)->first();
        $formattedDate = Carbon::parse($news->tgl_berita)->locale('id')->translatedFormat('l, d F Y H:i') . ' WIB';
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
        $filename = '';
        try {
            //code...

            $news =  News::where('id_berita', $id)->first();
            $dataLama = $news;
            $dataRequest =  $request->except(['_token']);
            if ($request['foto_berita']) {
                $rand = random_int(1000, 9999);
                $filename = 'banner-' . uniqid() . '-' . $request->title_berita . '.' . $request['banner_berita']->getClientOriginalExtension();
                $file  = $request->file('banner_berita');
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
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->route('news-manager.index')->with('success', 'Gagal :' . $th->getMessage());
        }
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
        try {
            //code...

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
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['status' => 'gagal:' . $th->getMessage()], 401);
        }
    }
}
