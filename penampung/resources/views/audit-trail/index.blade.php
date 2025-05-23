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

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row mt-4">
                            <h4>Log Aktivitas</h4>
                            <div class="col align-self-end">

                                <div class="mb-3 float-end ">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#cetakLogAktivitas1">
                                        Cetak
                                    </button>

                                </div>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable table-hover table-striped" id="audit-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Aplikasi</th>
                                    <th>Aksi</th>
                                    <th>Master</th>
                                    <th>Nama User</th>
                                    <th>Npp User</th>
                                    <th>Role</th>
                                    <th>Cabang</th>
                                    <th>Tanggal / Waktu</th>
                                    <th>Peramban</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
    <br>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">

                        <div class="row mt-4">
                            <h4>Log Login Admin</h4>
                            <div class="col align-self-end">

                                <div class="mb-3 float-end ">
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#cetakLogAdmin1">
                                        Cetak
                                    </button>

                                </div>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable table-hover table-striped" id="audit-table-login">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Aplikasi</th>
                                    <th>Admin</th>
                                    <th>Role</th>
                                    <th>NPP</th>
                                    <th>Cabang</th>
                                    <th>Tanggal / Waktu</th>
                                    <th>Ip Address</th>
                                    <th>Platform</th>
                                    <th>Browser</th>
                                    {{-- <th>#</th> --}}
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Modal -->
    <div class="modal fade" id="cetakLogAktivitas1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="cetakLogAktivitas1">Cetak Log Aktivitas</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>


                <div class="modal-body">
                    <form action="{{ route('audit-trail.export-log-aktivitas') }}" target="_blank" method="get">
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Awal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Akhir <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                        </div>
                        <button type="submit" name="export" value="pdf" class="btn btn-danger btn-sm"> <i
                                class="bi bi-file-earmark-pdf"></i>
                            Pdf</button>
                        <button type="submit" name="export" value="excel" class="btn btn-success btn-sm"><i
                                class="bi bi-filetype-xls"></i>
                            Excel</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="cetakLogAdmin1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-6 text-center" id="d">Cetak Log Login</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('audit-trail.export-log-login') }}" method="get" target="_blank">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Awal <span class="text-danger">*</span></label>
                            <input type="date" name="tanggal_awal" id="tanggal_awal" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Tanggal Akhir <span
                                    class="text-danger">*</span></label>
                            <input type="date" name="tanggal_akhir" id="tanggal_akhir" class="form-control">
                        </div>
                        <button type="submit" name="export" value="pdf" class="btn btn-danger btn-sm"> <i
                                class="bi bi-file-earmark-pdf"></i>
                            Pdf</button>
                        <button type="submit" name="export" value="excel" class="btn btn-success btn-sm"><i
                                class="bi bi-filetype-xls"></i>
                            Excel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="detailAuditModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
            reloadDataLogin();
        });


        function reloadData() {
            var table = new DataTable('#audit-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('audit-trail.datatable') }}",
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'aplikasi'
                    },
                    {
                        data: 'action'
                    },
                    {
                        data: 'master'
                    },

                    {
                        data: 'nama_user'
                    },
                    {
                        data: 'npp'
                    },
                    {
                        data: 'status'
                    },

                    {
                        data: 'branch_user'
                    },

                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'browser'
                    },
                    {
                        data: 'act'
                    }
                ]
            });
        };

        function reloadDataLogin() {
            var tableLogin = new DataTable('#audit-table-login', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('audit-trail.login') }}",
                    type: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}'
                    }
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'aplikasi'
                    },
                    {
                        data: 'nm_user'
                    },
                    {
                        data: 'status'
                    },
                    {
                        data: 'npp_user'
                    },
                    {
                        data: 'branch_name'
                    },
                    {
                        data: 'tanggal'
                    },
                    {
                        data: 'ip_address'
                    },
                    {
                        data: 'platform'
                    },
                    {
                        data: 'browser'
                    }
                ]
            });
        };

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
                    const data_before_1 = [{
                            "id_menu": "1",
                            "can_access": "Y",
                            "can_create": "Y",
                            "can_delete": "Y",
                            "can_update": "Y",
                            "id_account": "4",
                            "can_approve": "N"
                        },
                        // Tambah data lainnya...
                    ];

                    const data_after_1 = [{
                            "id_menu": "1",
                            "can_access": "Y",
                            "can_create": "N", // contoh perubahan
                            "can_delete": "Y",
                            "can_update": "Y",
                            "id_account": "4",
                            "can_approve": "N"
                        },
                        // Tambah data lainnya...
                    ];

                    const menu = {
                        1: "Dashboard",
                        2: "Admin Management",
                        3: "Customer Management",
                        4: "Chat Management",
                        5: "Product",
                        6: "Category Product",
                        7: "Branch Management",
                        8: "Region Management",
                        9: "City Management",
                        10: "Province Management",
                        11: "Master Akses",
                        12: "Master Data",
                        13: "General Options",
                        14: "Master Produk",
                        15: "Master Lokasi",
                        16: "News Management",
                        19: "Reporting",
                        20: "Report Customer",
                        21: "Report DWH",
                        30: "SMTP",
                        31: "Audit Trail"
                    };
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
                    if (data.data.action == 'update_roles') {
                        const userValueBefore = data_before[0]?.user;
                        const userValueAfter = data_after[0]?.user;
                       
                        $('#list_before').append(`
                    <li class="list-group-item list-group-item-warning">
                       User: ${userValueBefore}
                    </li>
                `);
                        $('#list_after').append(`
                    <li class="list-group-item list-group-item-primary">
                        User : ${userValueAfter}
                    </li>
                `);
                          // Ubah jadi map dengan key = id_menu
                          const map_before = Object.fromEntries(data_before.map(item => [item.id_menu.toString(),
                            item
                        ]));
                        const map_after = Object.fromEntries(data_after.map(item => [item.id_menu.toString(),
                            item
                        ]));
                      
                        // Gabungkan semua id_menu yang ada
                        const all_menu_ids = new Set([
                            ...Object.keys(map_before),
                            ...Object.keys(map_after)
                        ]);

                        // Loop setiap id_menu
                        all_menu_ids.forEach(id_menu => {
                            const before = map_before[id_menu] || {};
                            const after = map_after[id_menu] || {};

                            // Ambil semua key yang unik dari kedua objek
                            const keys = new Set([...Object.keys(before), ...Object.keys(after)]);

                            keys.forEach(key => {

                                // Abaikan perbandingan id_menu dan id_role (jika perlu)
                                if (key === 'id_menu' || key === 'id_role') return;

                                const valBefore = before[key] ?? '-';
                                const valAfter = after[key] ?? '-';

                                // Tampilkan hanya jika berbeda
                                if (valBefore !== valAfter && key != 'id_account' && key !=
                                    'id_account') {
                                    $('#list_before').append(`
                    <li class="list-group-item list-group-item-warning">
                        [Menu ${menu[id_menu]}] ${key}: ${valBefore}
                    </li>
                `);
                                    $('#list_after').append(`
                    <li class="list-group-item list-group-item-primary">
                        [Menu ${menu[id_menu]}] ${key}: ${valAfter}
                    </li>
                `);
                                }
                            });
                        });
    //                     data_before_1.forEach((beforeItem, index) => {
    //                         const afterItem = data_after_1[index];

    //                         if (!afterItem) return; // Lewati jika tidak ada data pembanding

    //                         Object.keys(beforeItem).forEach((key) => {
    //                             const beforeValue = beforeItem[key];
    //                             const afterValue = afterItem[key];
    //                             const isChanged = beforeValue !== afterValue;

    //                             if (key == 'id_menu') {
    //                                 $('#list_before').append(
    //                                     `<li class="list-group-item${isChanged ? ' list-group-item-warning' : ''}">
    //     [Menu ${beforeItem.id_menu}] Menu: ${menu[beforeValue] ?? '-'}
    // </li>`
    //                                 );


    //                                 $('#list_after').append(
    //                                     `<li class="list-group-item${isChanged ? ' list-group-item-primary' : ''}">
    //     [Menu ${afterItem.id_menu}] menu: ${menu[afterValue] ?? '-'}
    // </li>`
    //                                 );

    //                             } else {
    //                                 $('#list_before').append(
    //                                     `<li class="list-group-item${isChanged ? ' list-group-item-warning' : ''}">
    //     [Menu ${beforeItem.id_menu}] ${key}: ${beforeValue ?? '-'}
    // </li>`
    //                                 );
    //                                 $('#list_after').append(
    //                                     `<li class="list-group-item${isChanged ? ' list-group-item-primary' : ''}">
    //     [Menu ${afterItem.id_menu}] ${key}: ${afterValue ?? '-'}
    // </li>`
    //                                 );
    //                             }
    //                         });
    //                     });
                    } else if (data.data.after == 'null') {

                        // Tampilkan data before
                        Object.entries(data_before).forEach(([key, value]) => {
                            if (key == 'created_date' || key == 'updated_date') {

                                $('#list_before').append(`<li class="list-group-item list-group-item-warning" > ${formatTanggal(value) ?? '-'}</li>
                                `);
                            } else {

                                $('#list_before').append(`<li class="list-group-item list-group-item-warning" > ${value ?? '-'}</li>
                                `);
                            }
                        });
                    } else {
                        Object.entries(data_before).forEach(([key, value]) => {
                            if (key in data_after) {
                                // Highlight perbedaan dengan gaya tambahan
                                const isChanged = data_after[key] !== value;
                                $('#list_before', ).append(
                                    `<li class="list-group-item${isChanged ? ' list-group-item-warning' : ''}">
                                     ${value ?? '-'}
                                </li>`);
                            }
                        });

                        // Tampilkan data `after` hanya jika kunci juga ada di `before`
                        Object.entries(data_after).forEach(([key, value]) => {
                            if (key in data_before) {
                                // Highlight perbedaan dengan gaya tambahan

                                const isChanged = data_before[key] !== value;

                                $('#list_after').append(
                                    `<li class="list-group-item${isChanged ? ' list-group-item-primary' : ''}">
                                          ${value ?? '-'}
                                            </li>`);
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
