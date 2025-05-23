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
                {{-- <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Status Admin</div>
                    <div class="col-lg-9 col-md-8">
                        @if ($user->status_user == 'Active')
                            <span class="badge bg-success">{{ $user->employee_status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $user->employee_status }}</span>
                        @endif
                    </div>
                </div> --}}
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                    <div class="col-lg-9 col-md-8">{{ $user->primary_address }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">No .Telpon</div>
                    <div class="col-lg-9 col-md-8">{{ $user->primary_phone }}</div>
                </div>
                {{-- <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kota / Kab.</div>
                    <div class="col-lg-9 col-md-8">{{ $user->kota->nm_kota }}</div>
                </div> --}}
                {{-- <!--<div class="row mb-2">-->
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
                <!--</div>--> --}}
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Kode Cabang </div>
                    <div class="col-lg-9 col-md-8">{{ $user->branch_code }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Nama Cabang </div>
                    <div class="col-lg-9 col-md-8">{{ $user->branch_name }}</div>
                </div>
                {{-- 
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Wilayah Perusahaan</div>
                    <div class="col-lg-9 col-md-8">{{ $user->wilayah->nm_wilayah }}</div>
                </div> --}}


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

    <br>
    @if (auth()->user()->id_role == 1)
    <section class="profile">
        <div class="row bg-white p-4">
            <h5 class="card-title">Log Login</h5>
            <div class="table-responsive">
                <table class="table" id="table-log" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>User</th>
                            <th>Created Date</th>
                            <th>Browser</th>
                            <th>Platform</th>
                            <th>Device</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </section>

    @section('script')
        <script>
            $(document).ready(function() {
                reloadData();
            });

            function reloadData() {
                var table = new DataTable('#table-log', {
                    destroy: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('user-manager.getLogUser') }}",
                        type: 'GET',
                        data: {
                            id_user: '{{ $user->kd_user }}'
                        },
                    },
                    columns: [{
                            data: 'no'
                        },
                        {
                            data: 'nama_user'
                        },
                        {
                            data: 'tanggal'
                        },
                        {
                            data: 'browser'
                        },
                        {
                            data: 'platform'
                        },
                        {
                            data: 'device'
                        },

                    ]
                });
            }
        </script>
    @stop
@endif
@endsection
