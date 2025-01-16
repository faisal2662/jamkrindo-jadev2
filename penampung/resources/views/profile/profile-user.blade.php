@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">User </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ asset('assets/img/person.png') }}" alt="Profile" class="rounded-circle">
                        <h2>{{ auth()->user()->nm_user }}</h2>
                        <h3>{{ $user->branch_name }}</h3>
                        {{-- <div class="social-links mt-2">
                            <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                        </div> --}}
                    </div>
                </div>

            </div>

            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center    show " role="alert"
                                id="success-notification">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            {{-- <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change Password</button>
                            </li> --}}

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                @if (Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible fade text-center  show "
                                        role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <h5 class="card-title">Profile Details</h5>

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
                                    <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                                    @if ($user->birthday)
                                        <div class="col-lg-9 col-md-8">
                                            {{ Carbon\Carbon::parse($user->birthday)->translatedFormat('d-m-Y') }}
                                        </div>
                                    @endif
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Status User</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if ($user->employee_status == 'Active')
                                            <span class="badge bg-success">{{ $user->employee_status }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $user->employee_status }}</span>
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
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Kota</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->kota->nm_kota }}</div>
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
                                    <div class="col-lg-3 col-md-4 label">Kode Cabang </div>
                                    <div class="col-lg-9 col-md-8">{{ $user->cabang->kd_cabang }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Nama Cabang </div>
                                    <div class="col-lg-9 col-md-8">{{ $user->branch_name }}</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Wilayah Perusahaan</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->wilayah->nm_wilayah }}</div>
                                </div>
                                <hr>
                                <label for="" class="label">Log</label>
                                <table class="table" id="table-log">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama </th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>

                            {{--   <div class="tab-pane fade profile-edit pt-3" id="profile-edit">

                                <form action="{{ route('profile-update', $user->kd_user) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">NPP <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><input type="text" name="npp_user"
                                                id="npp_user" value="{{ $user->npp_user }}" class="form-control"
                                                required></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Nama <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><input type="text" name="nm_user"
                                                id="nm_user" value="{{ $user->nm_user }}" class="form-control"
                                                required></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Email <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><input type="email" name="email"
                                                id="email" class="form-control" value="{{ $user->email }}"
                                                required>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Status User <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><select name="employee_status"
                                                id="employee_status" class="form-control" required>
                                                <option value="" disabled>Pilih Status</option>
                                                <option @if ($user->employee_status == 'Active') selected @endif value="Active">
                                                    Active</option>
                                                <option @if ($user->employee_status == 'Inactive') selected @endif value="Inactive">
                                                    Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Alamat</div>
                                        <div class="col-lg-9 col-md-8">
                                            <textarea name="primary_address" id="primary_address" cols="" rows="3" class="form-control">{{ $user->primary_address }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">No .Telpon <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><input type="number" name="primary_phone"
                                                id="primary_phone" class="form-control"
                                                value="{{ $user->primary_phone }}" required></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Tanggal Lahir <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><input type="date" name="birthday"
                                                id="birthday" class="form-control" value="{{ $user->birthday }}" required></div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Provinsi <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><select name="provinsi" id="provinsi"
                                                class="form-control" required>
                                                <option value="" disabled selected>Pilih Provinsi</option>
                                                @foreach ($provinsi as $item)
                                                    <option value="{{ $item->kd_provinsi }}"
                                                        @if ($item->kd_provinsi == $provinsiId->kd_provinsi) selected @endif>
                                                        {{ $item->nm_provinsi }}</option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Kota <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><select name="kota" id="kota"
                                                class="form-control" required>
                                                <option value="{{ $kota->kd_kota }}">{{ $kota->nm_kota }}</option>
                                            </select></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Wilayah <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><select name="wilayah" id="wilayah"
                                                class="form-control" required>
                                            @foreach ($wilayahAll as $item)
                                                <option value="{{ $item->id_kanwil }}" @if ($item->id_kanwil == $wilayah->id_kanwil) @endif>{{ $item->nm_wilayah }}
                                                </option>
                                            @endforeach
                                            </select></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Pilih Cabang  <span class="text-danger">*</span></div>
                                        <div class="col-lg-9 col-md-8"><select id="cabang" name="cabang"
                                                class="form-control" required >
                                                <option value="{{ $user->cabang->id_cabang }}"
                                                    data-name="{{ $user->cabang->nm_cabang }}"
                                                    data-kode="{{ $user->cabang->kd_cabang }}">
                                                    {{ $user->cabang->nm_cabang }}
                                                </option>
                                            </select>
                                            <input type="hidden" name="branch_name" required id="branch_name"
                                class="form-control">
                                            </div>
                                    </div>
                                    <input type="hidden" name="branch_name" id="branch_name" class="form-control"
                                         value="{{ $user->branch_name }}"> --}}
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Cabang</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" readonly name="branch_name"-->
                            <!--            id="branch_name" class="form-control" value="{{ $user->branch_name }}">-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Cabang <span class="text-danger">*</span></div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="branch_code"-->
                            <!--            id="branch_code" class="form-control"-->
                            <!--            value="{{ $user->cabang->kd_cabang }}" required>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Perusahaan</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="company_code"-->
                            <!--            id="company_code" class="form-control"-->
                            <!--            value="{{ $user->company_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="nm_perusahaan"-->
                            <!--            id="nm_perusahaan" class="form-control"-->
                            <!--            value="{{ $user->nm_perusahaan }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Manajemen</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="management_code"-->
                            <!--            id="management_code" class="form-control"-->
                            <!--            value="{{ $user->management_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Manajemen</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="management_name"-->
                            <!--            id="management_name" class="form-control"-->
                            <!--            value="{{ $user->management_name }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Divisi</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="division_code"-->
                            <!--            id="division_code" class="form-control"-->
                            <!--            value="{{ $user->division_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Divisi</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="division_name"-->
                            <!--            id="division_name" class="form-control"-->
                            <!--            value="{{ $user->division_name }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Departement</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="department_code"-->
                            <!--            id="department_code" class="form-control"-->
                            <!--            value="{{ $user->department_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Departement</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="department_name"-->
                            <!--            id="department_name" class="form-control"-->
                            <!--            value="{{ $user->department_name }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Sub Departement</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="sub_department_code"-->
                            <!--            id="sub_department_code" class="form-control"-->
                            <!--            value="{{ $user->sub_department_code }}">-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Sub Departement</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="sub_department_name"-->
                            <!--            id="sub_department_name" class="form-control"-->
                            <!--            value="{{ $user->sub_department_name }}">-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Seksi</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="section_code"-->
                            <!--            id="section_code" class="form-control"-->
                            <!--            value="{{ $user->section_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Seksi</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="section_name"-->
                            <!--            id="section_name" class="form-control"-->
                            <!--            value="{{ $user->section_name }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Sub Kode Seksi</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="sub_section_code"-->
                            <!--            id="sub_section_code" class="form-control"-->
                            <!--            value="{{ $user->sub_section_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Posisi </div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="position_code"-->
                            <!--            id="position_code" class="form-control"-->
                            <!--            value="{{ $user->position_code }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Nama Posisi </div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="text" name="position_name"-->
                            <!--            id="position_name" class="form-control"-->
                            <!--            value="{{ $user->position_name }}"></div>-->
                            <!--</div>-->
                            <!--<div class="row mb-2">-->
                            <!--    <div class="col-lg-3 col-md-4 label">Kode Grade</div>-->
                            <!--    <div class="col-lg-9 col-md-8"><input type="number" name="grade_code"-->
                            <!--            id="grade_code" class="form-control" value="{{ $user->grade_code }}">-->
                            <!--    </div>-->
                            <!--</div>-->
                            {{-- <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Kode Fungsi</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="functional_code" id="functional_code"
                                                        class="form-control" value="{{ $user->functional_code }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Nama Fungsi</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="functional_name" id="functional_name"
                                                        class="form-control" value="{{ $user->functional_name }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Kode Atasan Fungsi Satu</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="functional_code_atasan_satu"
                                                        id="functional_code_atasan_satu" class="form-control"
                                                        value="{{ old('functional_code_atasan_satu') }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Nama Atasan Fungsi Satu</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="functional_name_atasan_satu"
                                                        id="functional_name_atasan_satu" class="form-control"
                                                        value="{{ $user->functional_name_atasan_satu }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">NPP Atasan Satu</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="npp_atasan_satu" id="npp_atasan_satu"
                                                        class="form-control" value="{{ $user->npp_atasan_satu }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Name Atasan Satu</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="name_atasan_satu"
                                                        id="name_atasan_satu" class="form-control" value="{{ $user->name_atasan_satu }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Kode Atasan Fungsi Dua</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="functional_code_atasan_dua"
                                                        id="functional_code_atasan_dua" class="form-control"
                                                        value="{{ $user->functional_code_atasan_dua }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Nama Atasan Fungsi Dua</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="functional_name_atasan_dua"
                                                        id="functional_name_atasan_dua" class="form-control"
                                                        value="{{ $user->functional_name_atasan_dua }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">NPP Atasan Dua</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="npp_atasan_dua" id="npp_atasan_dua"
                                                        class="form-control" value="{{ $user->npp_atasan_dua }}"></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Name Atasan Dua</div>
                                                <div class="col-lg-9 col-md-8"><input type="text" name="name_atasan_dua" id="name_atasan_dua"
                                                        class="form-control" value="{{ $user->name_atasan_dua }}"></div>
                                            </div>


                                    <div class="row mb-2 justify-content-center">
                                        <div class="col col-lg-7"><button type="submit"
                                                class="btn btn-primary w-75">Update</button>
                                        </div>
                                    </div>

                                </form>

                            </div>


                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                <form action="{{ route('change-password', $user->kd_user) }}" method="POST">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="currentPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="currentPassword" type="password" class="form-control"
                                                id="currentPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="newPassword" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control"
                                                id="newPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="renewPassword" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_confirmation" type="password" class="form-control"
                                                id="renewPassword">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div> --}}

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>

@section('script')

    <script>
        $('#table-log').DataTable({
            ajax: {
                url: "{{ route('user-manager.getLog') }}",
                method: "GET"
            },
            columns: [
            {
                data: 'no'
            },
            {
                data: 'nama_user'
            },
            {
                data: 'tanggal'
            }
        ]
        })
    </script>
    <script>
        $(document).ready(function() {

            var $notification = $('#success-notification');
            if ($notification.length > 0) {
                // Tampilkan notifikasi
                $notification.fadeIn('slow');
                // Menghilangkan notifikasi dengan delay
                setTimeout(function() {
                    $notification.fadeOut('slow');
                }, 7000); // Delay sebelum notifikasi menghilang (dalam milidetik)
            }
        });
        $('#provinsi').on('change', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataKota', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#kota').empty();
                    res.forEach(function(city) {

                        $('#kota').append(
                            `<option value="${city.kd_kota}">${city.tipe} | ${city.nm_kota}</option>`
                        );
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        })
        // $('#kota').on('click', function() {
        //     // console.log('berubah')
        //     // console.log($(this).val());
        //     $.ajax({
        //         url: "{{ route('getDataWilayah', '') }}/" + $(this).val(),
        //         type: "GET",
        //         success: function(res) {
        //             $('#wilayah').empty();

        //             if (res.length == 0) {

        //                 $('#wilayah').append(
        //                     `<option value="">Belum tersedia</option>`
        //                 );
        //             }
        //             res.forEach(function(wilayah) {


        //                 $('#wilayah').append(
        //                     `<option value="${wilayah.id_kanwil}">${wilayah.nm_wilayah}</option>`
        //                 );


        //             })
        //         },
        //         error: function(err) {
        //             alert("Gagal mengambil wilayah");
        //         }

        //     })
        // })
        $('#wilayah').on('change', function() {
            // console.log('berubah')
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataCabang', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#cabang').empty();
                    // console.log(res)
                    if (res.length == 0) {

                        $('#cabang').append(
                            `<option value="">Belum tersedia</option>`
                        );
                    }
                    res.forEach(function(cabang) {
                        $('#cabang').append(
                            `<option value="${cabang.id_cabang}" data-name="${cabang.nm_cabang}" data-kode="${cabang.kd_cabang}">${cabang.nm_cabang}</option>`
                        );
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil cabang");
                }

            })
        })
        $('#cabang').on('click', function(e) {
            // console.log($(this).find(':selected').data('kode'))
            // $('#branch_code').val($(this).find(':selected').data('kode'))
            $('#branch_name').val($(this).find(':selected').data('name'))
        });
    </script>
@stop
@endsection
