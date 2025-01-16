@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Edit Admin Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Admin Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class=" mb-2">
        <a href="{{ route('user-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
        <div class="row bg-white p-4">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade text-center  show " role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (Session::has('error'))
                <div class="alert alert-danger alert-dismissible fade text-center  show " role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

            <div class="col tab-pane fade show active profile-overview">
                <h5 class="card-title">Edit Admin</h5>
                <form action="{{ route('user-manager.update', $user->kd_user) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">NPP <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="npp_user" id="npp_user"
                                value="{{ $user->npp_user }}" class="form-control" readonly></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Nama <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="nm_user" id="nm_user"
                                value="{{ $user->nm_user }}" class="form-control" readonly></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Email <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><input type="email" name="email" id="email"
                                class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Status Admin <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><select name="status_user" id="status_user"
                                class="form-control" required>
                                <option value="" disabled>Pilih Status</option>
                                <option @if ($user->status_user == 'Active') selected @endif value="Active">Active</option>
                                <option @if ($user->status_user == 'Inactive') selected @endif value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Alamat <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="primary_address" readonly id="primary_address" cols="" rows="3" class="form-control" required>{{ $user->primary_address }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">No .Telpon <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><input type="number" name="primary_phone" id="primary_phone"
                                class="form-control" value="{{ $user->primary_phone }}" readonly></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Tanggal Lahir <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><input type="date" name="birthday" id="birthday"
                                class="form-control" value="{{ $user->birthday }}" readonly></div>
                    </div>
                    @if (auth()->user()->id_role == 1)
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label">Role <span class="text-danger"> * </span></div>
                            <div class="col-lg-9 col-md-8"><select name="id_role" id="id_role" class="form-control" required>
                                    <option value="" >Pilih Role</option>
                                    <option value="" @if ($user->id_role != 1) selected
                                        @endif>Admin</option>
                                    <option value="1" @if ($user->id_role == 1) selected
                                    @endif >Super Admin</option>
                                </select>
                            </div>
                        </div>
                    @endif
{{--
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Provinsi <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><select name="provinsi" id="provinsi" class="form-control" >
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->kd_provinsi }}"
                                        @if ($item->kd_provinsi == $provinsiId->kd_provinsi) selected @endif>{{ $item->nm_provinsi }}</option>
                                @endforeach
                            </select></div>
                    </div> --}}
                    {{-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kota <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><select name="kota" id="kota" class="form-control" required>
                                <option value="{{ $user->kota->kd_kota }}">{{ $user->kota->nm_kota }}</option>
                            </select></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Wilayah <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><select name="wilayah" id="wilayah" class="form-control" required>
                            <option value="" disabled selected>Pilih Wilayah</option>
                            @foreach($wilayah as $item)
                                <option value="{{ $item->id_kanwil }}" @if($user->wilayah->id_kanwil == $item->id_kanwil) selected @endif >{{ $item->nm_wilayah }}</option>
                                @endforeach
                            </select></div>
                    </div> --}}
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Cabang <span class="text-danger"> * </span></div>
                        {{-- <div class="col-lg-9 col-md-8"><select id="cabang" name="cabang" required class="form-control">
                                <option value="{{ $user->cabang->id_cabang }}"  data-name="{{ $user->cabang->nm_cabang }}"
                                    data-kode="{{ $user->cabang->kd_cabang }}">{{ $user->cabang->nm_cabang }}</option>
                            </select></div> --}}

                            <div class="col-lg-9 col-md-8">
                                <input type="text"  name="branch_name"  id="branch_name"
                                class="form-control" readonly>
                            </div>
                    </div>
                    {{-- <input type="hidden" name="branch_name" id="branch_name" class="form-control"
                        value="{{ $user->branch_name }}"> --}}
                    {{-- <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Cabang</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" readonly name="branch_name"-->
                    <!--            id="branch_name" class="form-control" value="{{ $user->branch_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Cabang</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="branch_code" id="branch_code"-->
                    <!--            class="form-control" value="{{ $us  er->cabang->kd_cabang }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Perusahaan</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="company_code" id="company_code"-->
                    <!--            class="form-control" value="{{ $user->company_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="nm_perusahaan" id="nm_perusahaan"-->
                    <!--            class="form-control" value="{{ $user->company_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Manajemen</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="management_code" id="management_code"-->
                    <!--            class="form-control" value="{{ $user->management_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Manajemen</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="management_name" id="management_name"-->
                    <!--            class="form-control" value="{{ $user->management_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Divisi</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="division_code" id="division_code"-->
                    <!--            class="form-control" value="{{ $user->division_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Divisi</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="division_name" id="division_name"-->
                    <!--            class="form-control" value="{{ $user->division_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Departement</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="department_code" id="department_code"-->
                    <!--            class="form-control" value="{{ $user->department_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Departement</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="department_name" id="department_name"-->
                    <!--            class="form-control" value="{{ $user->department_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Sub Departement</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="sub_department_code"-->
                    <!--            id="sub_department_code" class="form-control" value="{{ $user->sub_department_code }}">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Sub Departement</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="sub_department_name"-->
                    <!--            id="sub_department_name" class="form-control" value="{{ $user->sub_department_name }}">-->
                    <!--    </div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Seksi</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="section_code" id="section_code"-->
                    <!--            class="form-control" value="{{ $user->section_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Seksi</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="section_name" id="section_name"-->
                    <!--            class="form-control" value="{{ $user->section_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Sub Kode Seksi</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="sub_section_code"-->
                    <!--            id="sub_section_code" class="form-control" value="{{ $user->sub_section_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Posisi </div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="position_code" id="position_code"-->
                    <!--            class="form-control" value="{{ $user->position_code }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Nama Posisi </div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="text" name="position_name" id="position_name"-->
                    <!--            class="form-control" value="{{ $user->position_name }}"></div>-->
                    <!--</div>-->
                    <!--<div class="row mb-2">-->
                    <!--    <div class="col-lg-3 col-md-4 label">Kode Grade</div>-->
                    <!--    <div class="col-lg-9 col-md-8"><input type="number" name="grade_code" id="grade_code"-->
                    <!--            class="form-control" value="{{ $user->grade_code }}"></div>-->
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
                    </div> --}}
                    {{-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Ubah Password </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="input-group has-validation">
                                <input type="password" name="password" class="form-control" id="password">
                                <span class="input-group-text "><i class="bi bi-eye-fill" id="show"
                                        style="cursor: pointer"></i></span>

                                <div class="invalid-feedback">Please enter your Password</div>
                                <div class=" invalid-feedback invalid-password text-danger mt-1" style="display: none;">
                                    Password minimal harus 8 karakter</div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Konfirmasi Password </div>
                        <div class="col-lg-9 col-md-8">
                            <div class="input-group has-validation">
                                <input type="password" name="password_confirmation" class="form-control"
                                    id="password_confirmation">
                                <span class="input-group-text "><i class="bi bi-eye-fill" id="show1"
                                        style="cursor: pointer"></i></span>

                                <div class="invalid-feedback">Please enter your Password</div>
                                <div class=" invalid-feedback invalid-password text-danger mt-1" style="display: none;">
                                    Password minimal harus 8 karakter</div>
                            </div>
                        </div>
                    </div> --}}


                    <div class="row mb-2 justify-content-center">
                        <div class="col col-lg-7"><button type="submit" class="btn btn-primary w-75">Update</button>
                        </div>
                    </div>

                </form>
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

@section('script')
    <script>
            $('#provinsi').select2({
                theme: 'bootstrap-5',  // Ini opsional, agar sesuai dengan gaya Bootstrap 5
		placeholder: 'Pilih Provinsi',
            });
            $('#kota').select2({
                theme: 'bootstrap-5',  // Ini opsional, agar sesuai dengan gaya Bootstrap 5
		placeholder: 'Pilih Kota',
            });
            $('#wilayah').select2({
                theme: 'bootstrap-5',  // Ini opsional, agar sesuai dengan gaya Bootstrap 5
		placeholder: 'Pilih Wilayah',
            });
            $('#cabang').select2({
                theme: 'bootstrap-5',  // Ini opsional, agar sesuai dengan gaya Bootstrap 5
		placeholder: 'Pilih Cabang',
            });

        const password = document.getElementById('password');
        const password_confirm = document.getElementById('password_confirmation');
        const invalidPassword = document.getElementsByClassName('invalid-password')[0];
        const invalidPassword1 = document.getElementsByClassName('invalid-password')[1];
        const show = document.getElementById('show');
        const show1 = document.getElementById('show1');
        password.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value.length <= 8) {
                invalidPassword.style.display = 'block';
            } else {
                invalidPassword.style.display = 'none';

            }
        });
        password_confirm.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value.length <= 8) {
                invalidPassword1.style.display = 'block';
            } else {
                invalidPassword1.style.display = 'none';

            }
        });

        show.addEventListener('click', (e) => {
            // console.log(password.getAttribute('type'))
            if (password.getAttribute('type') == 'password') {
                password.setAttribute('type', 'text');
                show.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password.setAttribute('type', 'password');
            }
        })
        show1.addEventListener('click', (e) => {
            // console.log(password1.getAttribute('type'))
            if (password_confirm.getAttribute('type') == 'password') {
                password_confirm.setAttribute('type', 'text');
                show1.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show1.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password_confirm.setAttribute('type', 'password');
            }
        })
    </script>
    <script>
        $('#addUser').on('submit', function(e) {
            e.preventDefault();
            console.log($('#addUser').serialize())
            $.ajax({
                url: "{{ route('user-manager.save') }}",
                type: "POST",
                data: $('#addUser').serialize(),
                beforeSend: function() {
                    $('.btn-save').html("Loading...");
                    $('.btn-save').attr("disabled", "");
                },
                error: function(res) {
                    alert("Error");
                },
                success: function(res) {
                    $('.pesan').text(res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 3000);
                    // alert(res.status);
                    // table.ajax.reload();
                },
                complete: function() {
                    $('.btn-save').html("Save");
                    $('.btn-save').removeAttr("disabled");
                    initialForm();
                }
            });

        })
        $('#provinsi').on('click', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataKota', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#kota').empty();
                    res.forEach(function(city) {

                        $('#kota').append(
                            `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
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
                      $('#cabang').append(
                            `<option value="" disabled selected>Pilih Cabang</option>`
                        );
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
            // $('#branch_name').val($(this).find(':selected').data('name'))
             $('#branch_name').val($(this).find(':selected').data('name'))
        });
    </script>
@stop
@endsection
