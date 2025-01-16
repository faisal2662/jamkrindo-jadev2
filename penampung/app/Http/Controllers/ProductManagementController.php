<?php

namespace App\Http\Controllers;

use DataTables;
use Carbon\Carbon;
use App\Models\Role;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\CategoryProduct;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProductManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 5)->first();
        $products = Product::where('is_delete', 'N')->get();
        $categories = CategoryProduct::where('is_delete', 'N')->get();
        return view('product-management.index', compact('categories', 'products', 'role'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getData()
    {
        $role = Role::where('id_account', Auth::user()->kd_user)->where('id_menu', 5)->first();
        $products = Product::with('CategoryProduct')->where('is_delete', 'N')->orderBy('created_date', 'desc')->get();

        // return response()->json($products);
        // dd($products);

        $no = 1;


        foreach ($products as $act) {
            $btn = 'text-bg-success';

            if ($act->status_produk != 'Active') {
                $btn = 'text-bg-danger';
            }

            // $act->action = "";
            $act->status_produk = "<td ><span class='badge " . $btn . "'> " . $act->status_produk . "</span></td>";
            $act->id =  $no++;
            if ($role->can_update == 'Y' && $role->can_delete == 'Y') {
                $act->action =   " <td> <a href='products-management/lihat/" . $act->kd_produk . "' class='btn'><i class='bi bi-search'></i></a><a href='products-management/edit/" . $act->kd_produk . "' class='btn'> <i  class='bi bi-pencil-square'></i></a> <button class='btn btn-sm fw-bold' onclick='formDelete(" . $act->kd_produk . ")'><i class='bi bi-trash' ></i></button></td> ";
            } else if ($role->can_update == 'Y') {
                $act->action =   " <td> <a href='products-management/lihat/" . $act->kd_produk . "' class='btn'><i class='bi bi-search'></i></a><a href='products-management/edit/" . $act->kd_produk . "' class='btn'> <i  class='bi bi-pencil-square'></i></a> </td> ";
            } else if ($role->can_delete == 'Y') {
                $act->action =   " <td> <a href='products-management/lihat/" . $act->kd_produk . "' class='btn'><i class='bi bi-search'></i></a> <button class='btn btn-sm fw-bold' onclick='formDelete(" . $act->kd_produk . ")'><i class='bi bi-trash' ></i></button></td> ";
            } else {
                $act->action = " <td> <a href='products-management/lihat/" . $act->kd_produk . "' class='btn'><i class='bi bi-search'></i></a></td> ";
            }
        }
        return datatables::of($products)->escapecolumns([])->make(true);
    }


    public function create()
    {
        //
        $kategori = CategoryProduct::where('is_delete', 'N')->get();
        return view('product-management.create', compact('kategori'));
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
        if ($request['images_produk']) {
            $rand = random_int(1000, 9999);
            $filename = $request->title_produk . '-' . uniqid() . '.' . $request['images_produk']->getClientOriginalExtension();
            $file  = $request->file('images_produk');
            $file->move(base_path('../assets/img/product'),  $filename);
        }
        try {
            $product = new Product;
            $product->title_produk = $request->title_produk;
            $product->kd_kategori_produk = $request->kategori_produk;
            $product->status_produk = $request->status_produk;
            $product->description_produk = $request->deskripsi_produk;
            $product->images_produk = $filename;
            $product->tgl_produk = $request->tgl_produk;
            $product->created_by = Auth::user()->nm_user;
            $product->save();


            if (isset($product['kd_kategori_produk'])) {
                $product['kd_kategori_produk'] = DB::table('m_kategori_produk')->where('kd_kategori_produk', $product['kd_kategori_produk'])->where('is_delete', 'N')->first()->nm_kategori_produk;
            }
            unset($product['kd_produk']);
            $this->logAuditTrail('create', $product, null, $product->toArray());

            return redirect()->route('product-manager.index')->with('success', 'Data  berhasil disimpan');

            // return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {
            return back()->with('error', 'Simpan data gagal :' . $e->getMessage());

            // return response()->json(['status' => $e->getMessage()], 500);
        }
    }

    public function uploadGambar(Request $request)
    {
        $baseDomain = url('/');
        if ($request->hasFile('file')) {
            $file = $request['file'];
            $filename = time() . '_' . $file->getClientOriginalName();
            // $file->move(public_path('uploads'), $filename);
            $file->move(base_path('../assets/img/product'),  $filename);
            // Mengirimkan kembali lokasi file yang telah diupload
            return response()->json([
                'location' =>  "/../assets/img/product/$filename",
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
        $product = Product::with('CategoryProduct')->where('kd_produk', $id)->first();
        return view('product-management.show', compact('product'));
        // return response()->json($product);
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
        $kategori = CategoryProduct::where('is_delete', 'N')->get();
        $product = Product::where('kd_produk', $id)->first();
        return view('product-management.edit', compact('product', 'kategori'));
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
        // $path = 'assets/img/product/';
        $filename = '';
        // dd($request);
        try {

            $product = Product::where('kd_produk', $id)->first();
            $dataLama = $product ? $product->toArray() : [];
            if ($request['images_produk']) {

                $filename = $request->title_produk . '-' . uniqid() . '.' . $request['images_produk']->getClientOriginalExtension();
                $file  = $request->file('images_produk');
                $file->move(base_path('../assets/img/product'),  $filename);
                $product->images_produk = $filename;
            }

            // Ambil data dari request kecuali _token
            $dataRequest = $request->except(['_token']);
            $dataRequest['images_produk'] = 'assets/img/product'. $filename;
            // Proses kategori produk pada data baru
            if (!empty($dataRequest['kd_kategori_produk'])) {
                $data = DB::table('m_kategori_produk')
                    ->where('kd_kategori_produk', $dataRequest['kd_kategori_produk'])
                    ->where('is_delete', 'N')
                    ->first();

                $dataRequest['kd_kategori_produk'] = $data->nm_kategori_produk ?? $dataRequest['kd_kategori_produk'];
            }

            // Proses kategori produk pada data lama
            if (!empty($dataLama['kd_kategori_produk'])) {
                $data2 = DB::table('m_kategori_produk')
                    ->where('kd_kategori_produk', $dataLama['kd_kategori_produk'])
                    ->where('is_delete', 'N')
                    ->first();

                $dataLama['kd_kategori_produk'] = $data2->nm_kategori_produk ?? $dataLama['kd_kategori_produk'];
            }

            // Bandingkan data lama dan baru
            // dd($dataRequest);
            $dataOld = json_decode(json_encode($dataLama), true);
            $dataNew = json_decode(json_encode($dataRequest), true);

            $baru = array_diff_assoc($dataNew, $dataOld); // Perubahan baru
            $lama = array_diff_assoc($dataOld, $dataNew); // Perubahan lama

            // // Debugging hasil
            // Log::info('Data Lama:', $lama);
            // Log::info('Data Baru:', $baru);

            $product->title_produk = $request->title_produk;
            $product->kd_kategori_produk = $request->kd_kategori_produk;
            $product->status_produk = $request->status_produk;

            $product->description_produk = $request->description_produk;
            $product->tgl_produk = $request->tgl_produk;
            $product->created_by = Auth::user()->nm_user;
            $product->update();

            $this->logAuditTrail('update', $product, $lama, $baru);


            return redirect()->route('product-manager.index')->with('success', 'Data  berhasil diubah');
        } catch (\Exception $e) {
            // dd($e->getMessage());
            return back()->with('error', 'Ubah data gagal :' . $e->getMessage());

            // return response()->json(['status' => $e->getMessage()], 500);
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

        $date = Carbon::now();
        try {
            $product = Product::where('kd_produk', $id)->first();
            $dataLama = $product;
            $product->deleted_date = $date;
            $product->deleted_by = Auth::user()->nm_user;
            $product->is_delete = 'Y';
            $product->update();

            unset($dataLama['is_delete']);

            if (isset($dataLama->kd_kategori_produk)) {
                $dataLama['kd_kategori_produk'] = DB::table('m_kategori_produk')->where('kd_kategori_produk', $dataLama['kd_kategori_produk'])->where('is_delete', 'N')->first()->nm_kategori_produk;
            }
            $this->logAuditTrail('delete', $product, $dataLama, null);

            return response()->json(['status' => 'success'], 200);
        } catch (\Exception $e) {

            return response()->json(['status' => $e->getMessage()], 500);
        }
    }
}
