@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail Admin Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail Admin Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class=" mb-2">
        <a href="{{ route('user-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
        <div class="row bg-white p-4">

            <div class="col tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">NPP</div>
                    <div class="col-lg-9 col-md-8">{{ $user->npp_user }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama</div>
                    <div class="col-lg-9 col-md-8">{{ $user->nm_user }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Status Admin</div>
                    <div class="col-lg-9 col-md-8">
                        @if ($user->status_user == 'Active')
                            <span class="badge bg-success">{{ $user->status_user }}</span>
                        @else
                            <span class="badge bg-danger">{{ $user->status_user }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8">{{ $user->primary_address }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">No .Telpon</div>
                    <div class="col-lg-9 col-md-8">{{ $user->primary_phone }}</div>
                </div>

                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->nm_perusahaan }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Kode Perusahaan</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->company_code }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label"> Manajemen</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->company_code }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label"> Divisi</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->division_name }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Departement</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->department_code }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Departement</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->department_name }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Sub Departement</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->sub_department_code }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Seksi</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->section_name }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Posisi</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->position_name }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Kode Grade</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->grade_code }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Fungsi</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->functional_name }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Nama Atasan Fungsi</div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->functional_name_atasan_satu }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">NPP Atasan </div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->npp_atasan_dua }}</div>-->
                <!--</div>-->
                <!--<div class="row mb-2">-->
                <!--    <div class="col-lg-3 col-md-4 label">Nama Atasan </div>-->
                <!--    <div class="col-lg-9 col-md-8">{{ $user->name_atasan_dua }}</div>-->
                <!--</div>-->
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Cabang </div>
                    <div class="col-lg-9 col-md-8">{{ $user->branch_name }}</div>
                </div>


                <hr style="border : 1px dashed;">
                <div class="row mb-2">
                    <div class="row">
                        <div class="col"><span class="label">Created By : </span> {{$user->created_by}} </div>
                        <div class="col"><span class="label">Updated By : </span> {{$user->updated_by}} </div>
                        <div class="col"><span class="label">Deleted By : </span> {{$user->deleted_by}} </div>
                    </div>
                    <div class="row">
                        <div class="col"><span class="label">Created Date : </span> {{ Carbon\Carbon::parse($user->created_date)->translatedFormat('l, d F Y') ?? '-' }} </div>
                        <div class="col"><span class="label">Updated By : </span> {{ Carbon\Carbon::parse($user->updated_date)->translatedFormat('l, d F Y') ?? '-' }}  </div>
                        <div class="col"><span class="label">Deleted By : </span> {{ Carbon\Carbon::parse($user->deleted_date)->translatedFormat('l, d F Y') ?? '-' }} </div>

                    </div>
                </div>
            </div>
            {{-- <div class="col-2">
                <div class=" mb-2 ">
                    <a href="{{ route('user-manager.index') }}" class="btn btn-warning btn-sm"><i
                            class="bi bi-arrow-left-short"></i>
                        Edit</a>
                </div>
            </div> --}}
        </div>
    </section>
@endsection
