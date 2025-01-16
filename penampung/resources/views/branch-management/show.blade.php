@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail branch Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail Branch Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <a href="{{ route('branch-manager.index') }}" class="btn btn-secondary btn-sm mb-3  "><i
            class="bi bi-arrow-left-short"></i>
        Kembali</a>
    <section class="profile">
        <div class="row bg-white p-4">
            <div class="mb-2">
            </div>

            <div class="tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>


                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Cabang</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->nm_cabang }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Cabang</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kd_cabang }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Uker</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kode_uker }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kelas </div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kelas_uker }}</div>
                </div>
                    <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Email Cabang</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Wilayah</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->Wilayah->nm_wilayah }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">{!! $branch->desc_cabang !!}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Latitude</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->latitude_cabang }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Longitude</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->longitude_cabang }}</div>
                </div>

                <!--<div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Url Lokasi</div>
                    <div class="col-lg-9 col-md-8"><a href="{{ $branch->url_location }}" target="_blank">Link Maps</a></div>
                </div> -->
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->alamat }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->telp_cabang }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Fax</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->fax }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kota</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kd_kota }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Provinsi</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kd_provinsi }}</div>
                </div>
                <hr style="border : 1px dashed;">
                <div class="row mb-2">
                    <div class="row">
                        <div class="col"><span class="label">Created By : </span> {{$branch->created_by}} </div>
                        <div class="col"><span class="label">Updated By : </span> {{$branch->updated_by}} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{$branch->deleted_by}} </div>
                    </div>
                    <div class="row">
                        <div class="col"><span class="label">Created Date : </span> {{ Carbon\Carbon::parse($branch->created_date)->translatedFormat('l, d F Y') }} </div>
                        <div class="col"><span class="label">Updated By : </span> {{ Carbon\Carbon::parse($branch->updated_date)->translatedFormat('l, d F Y') }} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{ Carbon\Carbon::parse($branch->deleted_date)->translatedFormat('l, d F Y') }} </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
