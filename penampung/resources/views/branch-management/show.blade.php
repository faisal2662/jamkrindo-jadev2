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
                    <div class="col-lg-3 col-md-4 label">Nama </div>
                    <div class="col-lg-9 col-md-8">{{ $branch->nm_cabang }}</div>
                </div>
                {{-- <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Cabang</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kd_cabang }}</div>
                </div> --}}
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Uker</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kode_uker }}</div>
                </div>
                @if ($branch->kup)
                {{-- <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kelas </div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kelas_uker }}</div>
                </div> --}}
                @else
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kelas </div>
                    <div class="col-lg-9 col-md-8">{{ $branch->kelas_uker }}</div>
                </div>
                @endif
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Email </div>
                    <div class="col-lg-9 col-md-8">{{ $branch->email }}</div>
                </div>
                @if ($branch->kup)
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Cabang</div>
                        <div class="col-lg-9 col-md-8">{{ $branch->nm_kanwil }}</div>
                    </div>
                @else
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Wilayah</div>
                        <div class="col-lg-9 col-md-8">{{ $branch->nm_kanwil }}</div>
                    </div>
                @endif

                {{-- <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                    <div class="col-lg-9 col-md-8">{!! $branch->desc_cabang !!}</div>
                </div> --}}

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
                    <div class="col-lg-9 col-md-8">{{ $branch->alamat_cabang }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->telp_cabang }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Fax</div>
                    <div class="col-lg-9 col-md-8">{{ $branch->fax }}</div>
                </div>


            </div>
        </div>
    </section>
@endsection
