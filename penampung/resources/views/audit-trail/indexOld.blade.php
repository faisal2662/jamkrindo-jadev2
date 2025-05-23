@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Audit Trails</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Audit Trails</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    </head>

    <!-- <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col align-self-end">

                                <div class="mb-3 float-end mt-4">


                                </div>
                            </div>
                        </div>
                        <div id="alert" class="alert text-center alert-success alert-dismissible fade  " role="alert">
                            <span class="pesan  text-capitalize"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        Table with stripped rows
                        <table class="table datatable table-hover table-striped" id="audit-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Aksi</th>
                                    <th>Master</th>
                                    <th>Nama User</th>
                                    <th>Npp User</th>
                                    <th>Tanggal</th>
                                    <th>Peramban</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        End Table with stripped rows

                    </div>
                </div>

            </div>
        </div>
    </section> -->
        <section class="profile">
            <div class="row bg-white p-4">
                <h5 class="card-title">Log Perubahan</h5>
                <div class="table-responsive">
                    <table class="table" id="table-log" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis</th>
                                <th>Status</th>
                                <th>Dibuat Oleh</th>
                                <th>Dibuat Tanggal</th>
                                <th>Disetujui Oleh</th>
                                <th>DiSetujui Tanggal</th>
                                <th>Ditolak Oleh</th>
                                <th>Ditolak Tanggal</th>
                                <th>Action</th>
    
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </section>
        <br>
        <section class="profile">
            <div class="row bg-white p-4">
                <h5 class="card-title">Log Login</h5>
                <div class="table-responsive">
                    <table class="table" id="table-log-login-customer" style="width: 100%;">
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


    <!-- Modal -->
    <div class="modal fade" id="detailAuditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="ubahModalLabel">Detail</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body" id="dis-edit">
                    <h5 id="aksiModal" class="text-center fw-bold"></h5>
                    <div class="row">
                        <div class="col">
                            <h5>Before</h5>
                            <ul class="list-group" id="list_before">

                            </ul>
                        </div>
                        <div class="col">
                            <h5>After</h5>
                            <ul class="list-group" id="list_after">

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>



    <!-- Modal -->
    <div class="modal fade" id="hapus" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Kamu yakin ingin menghapus data ini?
                    </h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- <div class="modal-body">
                </div> --}}
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger">ya, hapus</button>
                </div>
            </div>
        </div>
    </div>

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
                    url: "{{ route('customer-manager.get_log') }}",
                    type: 'POST',
                    data: function(d) {
                        d._token = '{{ csrf_token() }}'
                    } 
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'maker'
                    },
                    {
                        data: 'maker_date'
                    },
                    {
                        data: 'approve'
                    },
                    {
                        data: 'approve_date'
                    },
                    {
                        data: 'reject'
                    },
                    {
                        data: 'reject_date'
                    },
                    {
                        data: 'act'
                    }
                ]
            });
        }
        

        function reloadDataLogin() {
            var table = new DataTable('#table-log-login-customer', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customer-manager.get_log_customer') }}",
                    type: 'GET',
                    data: {
                        id_customer: '{{ $customer->kd_customer }}'
                    },
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'nama_customer'
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

        function detail(id) {
            $.ajax({
                url: "{{ route('audit-trail.show', '') }}/" + id,
                type: 'GET',
                success: function(data) {
                    console.log(data.data)
                    // $('#ubahModalLabel').text(data.data.id_audit_trails)
                    let data_before = JSON.parse(data.data.before); // Mengonversi string JSON menjadi objek
                    let data_after = JSON.parse(data.data.after); // Mengonversi string JSON menjadi objek
                    $('#aksiModal').text('')
                    $('#aksiModal').text(data.data.action.toUpperCase());
                    // Kosongkan list sebelum menambahkan elemen baru
                    $('#list_before').empty();
                    $('#list_after').empty();

                    const mapping = {
                        email: "Email",
                        kd_cabang: "Kode Cabang",
                        kd_wilayah: "Wilayah",
                        nm_cabang: "Nama Cabang",
                        nm_provinsi: "Nama Provinsi",
                        kd_kategori_produk: "Kategori Produk",
                        nm_kategori_produk: "Nama Kategori Produk",
                        nm_category: "Nama Kategori Produk",
                        title_produk: "Title Produk",
                        email_smtp: "Email SMTP",
                        host_smtp: "Host SMTP",
                        port_smtp: "Post SMTP",
                        username_smtp: "Username SMTP",
                        password_smtp: "Password SMTP",
                        enkripsi_smtp: "Enkripsi SMTP",
                        alamat_email_smtp: "Alamat Email SMTP",
                        nama_email_smtp: "Nama Email SMTP",
                        status_produk: "Status Produk",
                        description_produk: "Deskripsi Produk",
                        images_produk: "Gambar Produk",
                        tgl_produk: "Tanggal Produk",
                        nm_wilayah: "Nama Wilayah",
                        icon_kategori: "Url Kategori",
                        desc_cabang: "Deskripsi Cabang",
                        desc_wilayah: "Deskripsi Wilayah",
                        latitude_cabang: "Latitude Cabang",
                        longitude_cabang: "Longitude Cabang",
                        kd_provinsi: "Provinsi",
                        kd_kota: "Kota",
                        alamat_cabang: "Alamat Cabang",
                        telp_cabang: "Telepon Cabang",
                        kelas_uker: "Kelas Uker",
                        fax: "Fax",
                        nm_kota: "Nama Kota",
                        postal_code: "Kode Pos",
                        tipe: "Tipe",
                        isi_berita: "Isi Berita",
                        foto_berita: "Banner Berita",
                        tgl_berita: "Tanggal Posting",
                        judul_berita: "Judul Berita",
                        status_berita: "Status Berita",
                        created_by: "Created By",
                        created_date: "Created Date",
                        updated_date: "Updated Date",
                        updated_by: "Updated By",
                        deleted_by: "Deleted By",
                        deleted_date: "Deleted Date",
                    }
                    if (data.data.before == 'null') {
                        // Tampilkan data before
                        Object.entries(data_after).forEach(([key, value]) => {
                            if (key == 'created_date' || key == 'updated_date' || key == 'tgl_berita' || key == 'tgl_produk') {

                                $('#list_after').append(`<li class="list-group-item list-group-item-primary" > <strong> ${mapping[key]  ?? key} </strong> : ${formatTanggal(value) ?? '-'}</li>
                                `);
                            }
                           
                            else {

                                $('#list_after').append(`<li class="list-group-item list-group-item-primary" > <strong> ${mapping[key]  ?? key} </strong> : ${value ?? '-'}</li>
                                `);
                            }
                        });
                    } else if (data.data.after == 'null') {

                        // Tampilkan data before
                        Object.entries(data_before).forEach(([key, value]) => {
                            if (key == 'created_date' || key == 'updated_date' || key == 'tgl_berita' || key == 'tgl_produk') {

                                $('#list_before').append(`<li class="list-group-item list-group-item-warning" > <strong> ${mapping[key]  ?? key} </strong> : ${formatTanggal(value) ?? '-'}</li>
                                `);
                            } else {

                                $('#list_before').append(`<li class="list-group-item list-group-item-warning" > <strong> ${mapping[key]  ?? key} </strong> : ${value ?? '-'}</li>
                                `);
                            }
                        });
                    } else {
                        Object.entries(data_before).forEach(([key, value]) => {
                            if (key in data_after) {
                                // Highlight perbedaan dengan gaya tambahan
                                const isChanged = data_after[key] !== value;
                                if(key == 'tgl_berita' || key == 'tgl_produk'){

                                    $('#list_before', ).append(
                                        `<li class="list-group-item${isChanged ? ' list-group-item-warning' : ''}">
                                        <strong>${mapping[key]}</strong> : ${formatTanggal(value) ?? '-'}
                                    </li>`);
                                }else {

                                    $('#list_before', ).append(
                                        `<li class="list-group-item${isChanged ? ' list-group-item-warning' : ''}">
                                        <strong>${mapping[key]}</strong> : ${value ?? '-'}
                                    </li>`);
                                }
                            }
                        });

                        // Tampilkan data `after` hanya jika kunci juga ada di `before`
                        Object.entries(data_after).forEach(([key, value]) => {
                            if (key in data_before) {
                                // Highlight perbedaan dengan gaya tambahan

                                const isChanged = data_before[key] !== value;
                                if(key == 'tgl_berita' || key == 'tgl_produk'){

                                    $('#list_after').append(
                                        `<li class="list-group-item${isChanged ? ' list-group-item-primary' : ''}">
                                                <strong>${mapping[key]}</strong> : ${formatTanggal(value) ?? '-'}
                                                </li>`);
                                 }else {
                                    $('#list_after').append(
                                        `<li class="list-group-item${isChanged ? ' list-group-item-primary' : ''}">
                                                <strong>${mapping[key]}</strong> : ${value ?? '-'}
                                                </li>`);
                                    
                                }
                            }
                        });

                    }

                    function formatTanggal(isoDate) {
                        // Konversi string ISO menjadi objek Date
                        let date = new Date(isoDate);

                        // Array nama bulan
                        let months = [
                            "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                            "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                        ];

                        // Ambil tanggal, bulan, dan tahun
                        let day = date.getDate(); // Tanggal
                        let month = months[date.getMonth()]; // Nama bulan (dari array)
                        let year = date.getFullYear(); // Tahun

                        // Format hasil menjadi "15 Januari 2025"
                        return `${day} ${month} ${year}`;
                    }

                    // for (let data_before in before) {
                    //     if (data_before in after) {
                    //         if (data_before in mapping) {
                    //             // Gunakan nama alias dari objek mapping
                    //             $('#list_before').append(
                    //                 `<li class="list-group-item"><strong>${mapping[data_before]}</strong> : ${before[data_before]}</li>`
                    //             );
                    //         }
                    //     }
                    // }
                    // Tampilkan data `after` jika ada
                    // if (after) {
                    //     Object.entries(after).forEach(([key, value]) => {
                    //         if (key in before) {
                    //             // Gunakan nama alias jika tersedia
                    //             const aliasKey = mapping[key] ?? key;
                    //             $('#list_after').append(
                    //                 `<li class="list-group-item"><strong>${aliasKey}</strong> : ${value ?? 'N/A'}</li>`
                    //             );
                    //         }
                    //     });
                    // }


                    // for (let data_after in after) {
                    //     if (data_after in before) {
                    //         if (data_after in mapping) {

                    //             $('#list_after').append(
                    //                 `<li class="list-group-item"><strong>${mapping[data_after]}</strong> : ${after[data_after]}</li>`);
                    //             // Gunakan nama alias dari objek mapping
                    //         }
                    //     }
                    // }
                    // for (let data_before in before) {
                    //     if (data_before in after) {
                    //         if (data_before in mapping) {
                    //             // Gunakan nama alias dari objek mapping
                    //             $('#list_before').append(
                    //                 `<li class="list-group-item"><strong>${mapping[data_before]}</strong> : ${before[data_before]}</li>`
                    //             );
                    //         }
                    //     }
                    // }
                    $('#detailAuditModal').modal('show')
                }
            })
        }
    </script>
@stop

@endsection
