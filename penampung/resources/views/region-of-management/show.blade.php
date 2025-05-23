@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail Region Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail Region Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="mb-2">
        <a href="{{ route('region-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="profile">
        <div class="row bg-white p-4">

            <div class="tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Wilayah </div>
                    <div class="col-lg-9 col-md-8">{{ $region->nm_wilayah }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Wilayah</div>
                    <div class="col-lg-9 col-md-8">{{ $region->kd_wilayah }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Uker</div>
                    <div class="col-lg-9 col-md-8">{{ $region->kode_uker }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">
                        {!! $region->desc_wilayah !!}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Latitude</div>
                    <div class="col-lg-9 col-md-8">{{ $region->latitude }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Longitude</div>
                    <div class="col-lg-9 col-md-8">{{ $region->longitude }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Alamat </div>
                    <div class="col-lg-9 col-md-8">
                        {{ $region->alamat }}
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                    <div class="col-lg-9 col-md-8">{{ $region->telp }}
                    </div>
                </div>


                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Fax</div>
                    <div class="col-lg-9 col-md-8">{{ $region->fax }}
                    </div>
                </div>



                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Provinsi </div>
                    <div class="col-lg-9 col-md-8">{{ $region->provinsi->nm_provinsi }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kota </div>
                    <div class="col-lg-9 col-md-8">{{ $region->kota->nm_kota }}</div>
                </div>
            </div>
        </div>
    </section>
@endsection
