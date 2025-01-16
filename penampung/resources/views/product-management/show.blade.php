@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail Product Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail Product Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class=" mb-2">
        <a href="{{ route('product-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
        <div class="row bg-white p-4">

            <div class="col tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Produk</div>
                    <div class="col-lg-9 col-md-8">{{ $product->title_produk }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kategori Produk</div>
                    <div class="col-lg-9 col-md-8">{{ $product->CategoryProduct->nm_kategori_produk }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8">
                        @if ($product->status_produk == 'Active')
                            <span class="badge text-bg-success  ">{{ $product->status_produk }}</span>
                        @else
                            <span class="badge text-bg-danger">{{ $product->status_produk }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">
                        <p class="text-break">{!! $product->description_produk !!}
                        </p>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Foto</div>
                    <div class="col-lg-9 col-md-8">
                        <img src="{{ asset('assets/img/product/' . $product->images_produk) }}" width="450px"
                            alt="">
                    </div>
                </div>

                <hr style="border : 1px dashed;">
                <div class="row mb-2">
                    <div class="row">
                        <div class="col"><span class="label">Created By : </span> {{$product->created_by}} </div>
                        <div class="col"><span class="label">Updated By : </span> {{$product->updated_by}} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{$product->deleted_by}} </div>
                    </div>
                    <div class="row">
                        <div class="col"><span class="label">Created Date : </span> {{ Carbon\Carbon::parse($product->created_date)->translatedFormat('l, d F Y') }} </div>
                        <div class="col"><span class="label">Updated By : </span> {{ Carbon\Carbon::parse($product->updated_date)->translatedFormat('l, d F Y') }} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{ Carbon\Carbon::parse($product->deleted_date)->translatedFormat('l, d F Y') }} </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
