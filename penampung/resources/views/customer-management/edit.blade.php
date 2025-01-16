@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Edit Customer Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Customer Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <div class="mb-2">
        <a href="{{ route('customer-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="profile">
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
            <div id="alert-placeholder"></div>


            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="tab-pane fade show active profile-overview">
                <div class="float-end"><span class="badge bg-warning" onclick="resetPassword({{$customer->kd_customer}})" style="cursor: pointer;"><i class="bi bi-arrow-counterclockwise"></i> Reset Password</span></div>

                <h5 class="card-title">Edit Customer</h5>
                <form method="POST" id="cust-edit" action="{{ route('customer-manager.submit') }}"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="kd_customer" value="{{ $customer->kd_customer }}">
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Nama Customer <span class="text-danger me-3">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" value="{{ $customer->nama_customer }}"
                                name="nama_customer" class="form-control" id="nama_customer" required>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                        <div class="col-lg-9 col-md-8"><input type="number" value="{{ $customer->hp_customer }}"
                                name="hp_customer" id="hp_customer" required class="form-control"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Username <span class="text-danger me-3">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" value="{{ $customer->userid_customer }}"
                                name="userid_customer" id="userid_customer" required class="form-control"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Email <span class="text-danger me-3">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="email" value="{{ $customer->email_customer }}"
                                name="email_customer" id="email_customer" required class="form-control"></div>
                    </div>
                    @if ($customer->foto_customer)
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label">Foto Customer</div>
                            <div class="col-lg-9 col-md-8">
                                <img src="{{ asset('assets/img/customer/' . $customer->foto_customer) }}" width="250px"
                                    alt="">
                            </div>
                        </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Update Foto Customer</div>
                        <div class="col-lg-9 col-md-8"><input type="file" class="form-control" name="foto_customer"
                                id="foto_customer">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kode Referrel Customer</div>
                        <div class="col-lg-9 col-md-8"><input type="text" class="form-control"
                                name="kd_referral_customer" placeholder="Opsional"
                                value="{{ $customer->kd_referral_customer }}" id="kd_referral_customer"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Status Customer</div>
                        <div class="col-lg-9 col-md-8">
                            <select name="status_customer" id="status_customer" class="form-control">
                                <option value="" disabled selected>Pilih Status</option>
                                <option @if ($customer->status_customer == 'Active') selected @endif value="Active">Active</option>
                                <option @if ($customer->status_customer == 'Inactive') selected @endif value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    {{-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Provinsi</div>
                        <div class="col-lg-9 col-md-8"><select name="provinsi" id="provinsi" class="form-control">
                                <option value="" disabled selected>Pilih Provinsi</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kota</div>
                        <div class="col-lg-9 col-md-8"><select name="kota" id="kota" class="form-control">
                                <option value=""></option>
                            </select></div>
                    </div> --}}
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Wilayah</div>
                        @if ($wilayahId)

                            <div class="col-lg-9 col-md-8"><select name="wilayah" id="wilayah" class="form-control">
                                    <option value="" disabled selected> Piih Wilayah</option>
                                    @foreach ($wilayah as $item)
                                        <option value="{{ $item->id_kanwil }}"
                                            @if ($wilayahId->id_kanwil == $item->id_kanwil) selected @endif>{{ $item->nm_wilayah }}
                                        </option>
                                    @endforeach
                                </select></div>
                        @else
                            <div class="col-lg-9 col-md-8"><select name="wilayah" id="wilayah" class="form-control">
                                    <option value="" disabled selected> Piih Wilayah</option>
                                    @foreach ($wilayah as $item)
                                        <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}</option>
                                    @endforeach
                                </select></div>
                        @endif
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Pilih Cabang </div>
                        <div class="col-lg-9 col-md-8"><select name="cabang" id="cabang" class="form-control">
                                @if ($customer->branch)
                                    <option value="{{ $customer->branch->id_cabang }}">
                                        {{ $customer->branch->nm_cabang }}</option>
                                @else
                                    <option value=""></option>
                                @endif
                            </select></div>
                    </div>


                    {{-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Password Baru<span class="text-danger me-3">*</span></div>
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
                    </div> --}}
                    {{-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Konfirmasi Password Baru<span
                                class="text-danger me-3">*</span>
                        </div>
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
                    <hr>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>
                        <div class="col-lg-9 col-md-8"><input type="text" value="{{ $customer->company_name }}"
                                name="company_name" class="form-control" id="company_name">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Provinsi </div>
                        <div class="col-lg-9 col-md-8">
                            <select name="company_province" id="company_province" class="form-control">
                                <option value="" disabled selected> Pilih Provinsi</option>
                                @foreach ($provinsi as $item)
                                    <option @if ($item->nm_provinsi == $customer->company_province) selected @endif
                                        value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kota </div>
                        <div class="col-lg-9 col-md-8">
                            <select name="company_city" id="company_city" class="form-control">
                                @if ($customer->city)
                                    <option value="{{ $customer->city->kd_kota }}"> {{ $customer->city->nm_kota }}
                                    </option>
                                @else
                                    <option value=""></option>
                                @endif

                            </select>
                        </div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col col-lg-7"><button type="submit" class="btn btn-primary w-75">Ajukan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
    <div class="modal fade" id="confirm" tabindex="-1" data-bs-backdrop="false">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah Kamu Yakin ingin mengajukan ini ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tdak</button>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-confirm">Ya</button>

                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->
    <div class="modal fade" id="confirm-reset" tabindex="-1" data-bs-backdrop="false">

        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Apakah Kamu Yakin ingin reset ini ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Tdak</button>
                    <button type="button" class="btn btn-sm btn-primary" id="btn-confirm-reset">Ya</button>

                </div>
            </div>
        </div>
    </div><!-- End Large Modal-->
    {{-- <section class="mt-3 profile">
        <div class="row">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Informasi Usaha</h5>

                    <div class="row">
                        <div class="col align-self-end">


                            <div class="mb-3 float-end mt-4">
                                <button type="button" class="btn btn-primary btn-sm float-end" onclick="businessAdd()">
                                    Tambah Data
                                </button>
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
    <!-- Table with stripped rows -->
    {{-- <div id="alert" class="alert alert-success alert-dismissible fade position-absolute "
        style="margin-left: 400px ; margin-top: -20px;" role="alert">
        <span class="pesan text-capitalize"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <table class="table datatable table-hover table-striped " id="business-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Usaha</th>
                <th>NPWP</th>
                <th>Kota</th>
                <th>Provinsi</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
    <!-- End Table with stripped rows -->

    </div>
    </div>

    </div>
    </section>  --}}


    {{-- modal edit --}}
    {{-- <div class="modal fade" id="businessModal">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Edit Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="businessForm">
                        @csrf
                        <table class="table table-borderless">
                            <input type="hidden" name="kd_customer" id="kd_customer" value="{{ $customer->kd_customer }}">
                            <input type="hidden" name="kd_usaha" id="kd_usaha">
                            <tr>
                                <th>Nama Usaha<span class="text-danger">*</span></th>
                                <td><input type="text" name="nama_usaha" id="nama_usaha" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th>NPWP Usaha <span class="text-danger">*</span></th>
                                <td><input type="text" name="npwp_usaha" id="npwp_usaha" class="form-control" required>
                                </td>
                            </tr>
                            {{-- <tr>
                                <th>Kota Usaha <span class="text-danger">*</span></th>
                                <td><input type="text" name="kota_usaha" id="kota_usaha" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Provinsi Usaha <span class="text-danger">*</span></th>
                                <td><input type="text" name="provinsi_usaha" id="provinsi_usaha" class="form-control"
                                        required>
                                </td>
                            </tr> --}}
    {{-- <tr>
        <th>Provinsi</th>
        <td><select name="provinsi_usaha" id="provinsi_usaha" class="form-control" required>
                <option value="" disabled>Pilih Provinsi</option>
                @foreach ($provinsi as $item)
                    <option value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                @endforeach
            </select></td>
    </tr>
    <tr>
        <th>Kota/Kab</th>
        <td><select name="kota_usaha" id="kota_usaha" class="form-control" required>
                <option value="" disabled>Pilih Kota</option>
                @foreach ($kota as $item)
                    <option value="{{ $item->kd_kota }}">{{ $item->nm_kota }}</option>
                @endforeach
            </select>
        </td>
    </tr>
    <tr>
        <td colspan="2">

            <div class="text-center">
                <button type="submit" class="btn btn-primary w-75 btn-save">Simpan</button>
            </div>
        </td>
    </tr>

    </table>

    </form>
    </div>

    </div>

    </div>
    </div>  --}}


@section('script')
    <script>
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
        $('#cust-edit').off('click').on('submit', function(e) {
            e.preventDefault();
            var form = this;
            $('#confirm').modal('show');
            // Pastikan tombol konfirmasi memicu pengiriman
            $('#btn-confirm').off('click').on('click', function() {
                $('#confirm').modal('hide'); // Tutup modal
                form.submit(); // Kirim formulir secara manual
            });
        })

        $('#company_province').on('change', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataKota', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#company_city').empty();
                    res.forEach(function(city) {

                        $('#company_city').append(
                            `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        })
        $('#company_province').select2({
            theme: 'bootstrap-5',
        });
        $('#wilayah').select2({
            theme: 'bootstrap-5',
        });


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
                            `<option value="${cabang.id_cabang}" data-kode="${cabang.kd_cabang}">${cabang.nm_cabang}</option>`
                        );
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil cabang");
                }

            })
        })

    function resetPassword(id){
        $('#confirm-reset').modal('show');
        $('#btn-confirm-reset').on('click', function(){

            $.ajax({
                url: "{{route('customer-manager.reset-password')}}",
                type: "POST",
                data:{
                    _token: "{{csrf_token()}}",
                    kd_customer: id,
                },
                success: function(res){
                    console.log(res)
                    showAlert('Reset Berhasil', 'primary')
                    $('#confirm-reset').modal('hide');
                },
                error: function(res)
                {
                    alert('terjadi error : ' + res);
                    $('#confirm-reset').modal('hide');
            }
        })
    })

    }

    function showAlert(message, type = 'danger') {
    // Template alert
    let alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade text-center show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;

    // Tambahkan ke placeholder
    $('#alert-placeholder').html(alertHTML);

    // Opsional: Hapus alert setelah beberapa detik
    setTimeout(() => {
        $('.alert').fadeOut('slow', function() {
            $(this).remove();
        });
    }, 5000); // Hapus setelah 5 detik
}
    </script>
    {{-- <script>
        let bussiness = "add";
        $(document).ready(function() {
            reloadData();
        });

        function reloadData() {
            var baseUrl = "{{ route('customer-manager.business-manager.getDataUsaha', ['id' => ' ']) }}";
            let id = $('#kd_customer').val();
            var url = baseUrl.replace('/get-data-usaha/', '/get-data-usaha/' + id);

            var table = new DataTable('#business-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
                    type: 'GET'
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'nama_usaha'
                    },
                    {
                        data: 'npwp_usaha'
                    },
                    {
                        data: 'kota.nm_kota'
                    },
                    {
                        data: 'provinsi.nm_provinsi'
                    },
                    {
                        data: 'action'
                    }
                ]
            });
        }

        //initial form
        function initialForm() {
            $('#kd_usaha').val("");
            $('#nama_usaha').val("");
            $('#npwp_usaha').val("");
            $('#kota_usaha').val("");
            $('#provinsi_usaha').val("");
        }

        function businessAdd() {
            business = "add";
            initialForm();
            $('.modal-title').text("Tambah Usaha");
            $('#businessModal').modal('show');
        }


        function reloadKota() {
            $.ajax({
                url: "{{ route('getDataKotaAll') }}",
                type: "GET",
                success: function(res) {
                    $('#kota_usaha').empty();
                    res.forEach(function(city) {
                        $('#kota_usaha').append(
                            `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        }


        $('#provinsi_usaha').on('click', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('customer-manager.index') }}/get-data-kota/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#kota_usaha').empty();
                    res.forEach(function(city) {
                        $('#kota_usaha').append(
                            `<option value="${city.kd_kota}">${city.nm_kota}</option>`);
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        })

        function businessDelete(id) {
            if (confirm("Kamu yakin ingin menghapus user ini?")) {
                var baseUrl = "{{ route('customer-manager.business-manager.delete', ['id' => ' ']) }}";
                var url = baseUrl.replace('/delete/', '/delete/' + id);
                $.ajax({
                    url: url,
                    type: 'GET', // Ensure you're using the correct HTTP method
                    success: function(res) {
                        alert("Success Delete Data");
                        reloadData();
                    },
                    error: function(err) {
                        alert("Error deleting data");
                    }
                });
            }
        }

        function businessEdit(id) {
            business = "edit";
            var baseUrl = "{{ route('customer-manager.business-manager.edit', ['id' => ' ']) }}";
            var url = baseUrl.replace('/edit/', '/edit/' + id);
            var selectProvinsi = $('#provinsi_usaha');
            var selectKota = $('#kota_usaha');
            $('#provinsi_usaha').val("").attr('selected', true);
            // $('#kota_usaha').val("").attr('selected', true);
            let no = 1;
            $.ajax({
                url: url,
                method: 'GET',
                success: function(res) {
                    console.log(res)

                    $('#kd_usaha').val(res.kd_usaha);
                    $('#nama_usaha').val(res.nama_usaha);
                    $('#npwp_usaha').val(res.npwp_usaha);
                    $('#provinsi_usaha').val(res.provinsi_usaha).attr(
                        'selected',
                        true);
                    // $('#kota_usaha').val(res.kota_usaha).attr(
                    //     'selected',
                    //     'selected');
                    // $('select[name="kota_usaha"] option[value="' + res.kota_usaha + '"]').attr(
                    //     'selected',
                    //     true);
                    $('select[name="kota_usaha"]').find('option[value="' + res.kota_usaha + '"]').prop(
                        'selected', true);
                    $('.modal-title').text("Edit Usaha");
                    $('#businessModal').modal('show');
                }
            });
        }


        $('#businessForm').on('submit', function(e) {
            e.preventDefault();
            if (business == "add") {
                $.ajax({
                    url: "{{ route('customer-manager.business-manager.saveUsaha') }}",
                    type: "POST",
                    data: $('#businessForm').serialize(),
                    beforeSend: function() {
                        $('.btn-save').html("Loading...");
                        $('.btn-save').attr("disabled", "");
                    },
                    error: function(res) {

                        $('.pesan').text(res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        alert("Error");
                    },
                    success: function(res) {
                        $('#businessModal').modal('hide');
                        $('.pesan').text("Simpan " + res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        // alert(res.status);
                        reloadData();
                    },
                    complete: function() {
                        $('.btn-save').html("Save");
                        $('.btn-save').removeAttr("disabled");
                        initialForm();
                    }
                });
            } else {
                var baseUrl = "{{ route('customer-manager.business-manager.update', ['id' => ' ']) }}";
                let id = $('#kd_usaha').val();
                var url = baseUrl.replace('/update/', '/update/' + id);
                $.ajax({
                    url: url,
                    type: "POST",
                    data: $('#businessForm').serialize(),
                    beforeSend: function() {
                        $('.btn-save').html("Loading...");
                        $('.btn-save').attr("disabled", "");
                    },
                    error: function(res) {

                        $('.pesan').text(res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        alert("Error");
                    },
                    success: function(res) {
                        // console.log(res)
                        $('#businessModal').modal('hide');
                        $('.pesan').text("Simpan " + res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 3000);
                        // alert(res.status);
                        reloadData();
                        $('#provinsi_usaha').val("").attr('selected', true);
                        // $('#kota_usaha').val("")..attr('selected', true);
                        reloadKota();
                    },
                    complete: function() {
                        $('.btn-save').html("Save");
                        $('.btn-save').removeAttr("disabled");
                        initialForm();
                    }
                });
            }

        });
    </script> --}}
@stop


@endsection
