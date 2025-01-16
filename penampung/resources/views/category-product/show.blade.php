@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail Category Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail Category Product</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

<div class="mb-2">
                <a href="{{ route('category-manager.index') }}" class="btn btn-secondary btn-sm"><i
                        class="bi bi-arrow-left-short"></i> Kembali</a>
            </div>
    <section class="profile">
        <div class="row bg-white p-4">


            <div class="tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Kategori </div>
                    <div class="col-lg-9 col-md-8">{{ $category->nm_kategori_produk }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">{!! $category->description_produk !!}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Ikon Kategori</div>
                    <div class="col-lg-9 col-md-8"><img src="{{$category->icon_kategori}}" alt="" class="img-thumb"></div>
                </div>
                <hr style="border : 1px dashed;">
                <div class="row mb-2">
                    <div class="row">
                        <div class="col"><span class="label">Created By : </span> {{$category->created_by ?? '-'}} </div>
                        <div class="col"><span class="label">Updated By : </span> {{$category->updated_by ?? '-'}} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{$category->deleted_by ?? '-' }} </div>
                    </div>
                    <div class="row">
                        <div class="col"><span class="label">Created Date : </span> {{ $category->created_date ? Carbon\Carbon::parse($category->created_date)->translatedFormat('l, d F Y') : '-' }} </div>
                        <div class="col"><span class="label">Updated By : </span> {{ Carbon\Carbon::parse($category->updated_date)->translatedFormat('l, d F Y') ?? '-' }} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{ Carbon\Carbon::parse($category->deleted_date)->translatedFormat('l, d F Y') ?? '-' }} </div>

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
