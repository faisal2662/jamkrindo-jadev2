<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use DataTables;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 6)->first();
        if($role->can_access == 'N'){
            return redirect()->route('dashboard');
         }
        return view('category-product.index', compact('role'));
    }

    public function getData()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 6)->first();
        $categories = CategoryProduct::where('is_delete', 'N')->orderBy('created_date','desc')->get();
        // return response()->json($category);
        $no = 1;
        foreach ($categories as $act) {

            $act->no = $no++;
            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $act->action =   " <a href='categories-product/lihat/" . $act->kd_kategori_produk . "' class='btn'><i
                                                    class='bi bi-search'></i></a>
                <button class='btn btn-sm fw-bold' onclick='categoryProductEdit(\"" . $act->kd_kategori_produk . "\")' > <i
                                                    class='bi bi-pencil-square'></i></button>
                                                     <button class='btn btn-sm fw-bold' onclick='categoryProductDelete(\"" . $act->kd_kategori_produk . "\" )'><i
                                                    class='bi bi-trash' ></i></button>
                                                    ";
            } else if ($role->can_update == 'Y') {
                $act->action =   " <a href='categories-product/lihat/" . $act->kd_kategori_produk . "' class='btn'><i
                                                    class='bi bi-search'></i></a>
                <button class='btn btn-sm fw-bold' onclick='categoryProductEdit(\"" . $act->kd_kategori_produk . "\")' > <i
                                                    class='bi bi-pencil-square'></i></button>
                                                    ";
            } else if ($role->can_delete == 'Y') {
                $act->action =   " <a href='categories-product/lihat/" . $act->kd_kategori_produk . "' class='btn'><i
                                                    class='bi bi-search'></i></a>
                                                     <button class='btn btn-sm fw-bold' onclick='categoryProductDelete(\"" . $act->kd_kategori_produk . "\" )'><i
                                                    class='bi bi-trash' ></i></button>
                                                    ";
            } else {
                $act->action =   " <a href='categories-product/lihat/" . $act->kd_kategori_produk . "' class='btn'><i class='bi bi-search'></i></a>";
            }
        }
        return datatables::of($categories)->escapecolumns([])->make(true);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        // $filename = null;
        // if ($request['image']) {
        //     $rand = random_int(1000, 9999);
        //     $filename = $request->nm_category . '-' . uniqid() . '.' . $request['image']->getClientOriginalExtension();
        //     $file  = $request->file('image');
        //     $file->move(base_path('../assets/img/product'),  $filename);
        // }

        $iconSearch = $request->icon_kategori; // Nama file yang dicari

        // Validasi apakah file ada di folder]
        $filename = '';
        if ($iconSearch) {
      
           $filename = url('/') . '/assets/icons/' . $iconSearch;
        }

        try {
            $category = new CategoryProduct;
            $category->nm_kategori_produk = $request->nm_category;

            $category->description_produk = $request->description;
            // $category->icon_kategori = url('assets/img/product/'.$filename);
            $category->icon_kategori = $filename;
            $category->created_by = Auth::user()->nm_user;
            $category->save();
            unset($category['id_kategori_produk']);
            $this->logAuditTrail('create', $category, null, $category->toArray());

            return response()->json(['status' => 'berhasil'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function showIconGallery(Request $request)
    {
        $iconFolder = public_path('../../assets/icons'); // Lokasi folder ikon
        $icons = [];
        foreach (scandir($iconFolder) as $file) {
            if (in_array(pathinfo($file, PATHINFO_EXTENSION), ['svg', 'png', 'jpg'])) {
                $icons[] = [
                    'name' => pathinfo($file, PATHINFO_FILENAME), // Nama file tanpa ekstensi
                    'nameEks' => $file, // nama file dengan ekstensi
                    'url' => asset('assets/icons/' . $file), // URL akses ikon
                ];
            }
        }
        return response()->json([$icons], 200);
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
        $category = CategoryProduct::where('kd_kategori_produk', $id)->first();
        return view('category-product.show', compact('category'));
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
        $category = CategoryProduct::where('kd_kategori_produk', $id)->first();
        $category->iconEks = str_replace(url('/'). '/assets/icons/' , '', $category->icon_kategori);
        $category->url = url('/'). '/assest/img/icon-category' ;
        return response()->json($category);
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
        // $filename = null;
        // if ($request['image']) {
        //     $rand = random_int(1000, 9999);
        //     $filename = $request->nm_category . '-' . uniqid() . '.' . $request['image']->getClientOriginalExtension();
        //     $file  = $request->file('image');
        //     $file->move(base_path('../assets/img/product'),  $filename);
        // }

        $iconSearch = $request->icon_kategori; // Nama file yang dicari

        // Validasi apakah file ada di folder]
        $filename = null;
        if ($iconSearch != '') {

           $filename = url('/') . '/assets/icons/' . $iconSearch;
        }
        try {
            $category = CategoryProduct::where('kd_kategori_produk', $id)->first();
            $dataLama = $category ? $category->toArray() : [];
            $dataRequest = $request->except(['_token']);

            if (!is_null($filename)) {
                $category->icon_kategori = $filename;
            }
            $dataRequest['icon_kategori'] = $filename;

            // Bandingkan data lama dan baru
            $baru = array_diff_assoc($dataRequest, $dataLama); // Nilai baru
            $lama = array_diff_assoc($dataLama, $dataRequest); // Nilai lama
            

            $category->nm_kategori_produk = $request->nm_kategori_produk;
            $category->description_produk = $request->description_produk;
            $category->updated_by = Auth::user()->nm_user;
            $category->update();
            $this->logAuditTrail('update', $category, $lama, $baru);

            return response()->json(['status' => 'berhasil'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
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

        $date = Carbon::now();
        try {
            $category = CategoryProduct::where('kd_kategori_produk', $id)->first();
            $dataLama = $category;

            $category->deleted_date = $date;
            $category->is_delete = 'Y';
            $category->deleted_by = Auth::user()->nm_user;
            $category->update(); 
            unset($category['is_delete']);
            $this->logAuditTrail('delete', $category, $dataLama, null);


            return response()->json(['status' => 'berhasil'], 200);
        } catch (\Exception $e) {
            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
