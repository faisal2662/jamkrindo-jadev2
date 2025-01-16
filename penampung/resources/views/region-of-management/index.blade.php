@extends('layouts.main')
@section('main')
<div class="pagetitle">
    <h1>Region</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Region</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
</head>

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col align-self-end">

                            <div class="mb-3 float-end mt-4">
                                <!-- Button trigger modal -->
                                @if ($role->can_create == 'Y')
                                <!--<button type="button" class="btn btn-primary btn-sm float-end" onclick="regionAdd()">-->
                                <!--    Tambah Data-->
                                <!--</button>-->
                                  <a href="{{ route('region-manager.create') }}" class="btn btn-primary btn-sm float-end">
                                        Tambah Data
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="alert" class="alert text-center alert-success alert-dismissible fade  "
                         role="alert">
                        <span class="pesan text-capitalize"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                      @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center show"
                                id="success-notification" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                    <!-- Table with stripped rows -->
                    <table class="table datatable table-hover table-striped" id="regions-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Wilayah</th>
                                <th>Kode Wilayah</th>
                                <th>Kota </th>
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
    </div>
</section>


<!-- Modal -->
<div class="modal fade" id="regionModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Ubah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="regionForm">
                    @csrf
                    <table class="table table-borderless">
                        <input type="hidden" name="id_wilayah" id="id_wilayah">
                        <tr>
                            <th>Nama Wilayah</th>
                            <td><input type="text" name="nama_wilayah" id="nama_wilayah" class="form-control"
                                    required></td>
                        </tr>
                        <tr>
                            <th>Kode Wilayah</th>
                            <td><input type="text" name="kode_wilayah" id="kode_wilayah" class="form-control"
                                    required></td>
                        </tr>

                        <tr>
                            <th>Deskripsi Wilayah</th>
                            <td>
                                <textarea type="text" name="description" cols="10" id="deskripsi" class="form-control"></textarea>
                            </td>
                        </tr>

                        <tr>
                            <th>Provinsi</th>
                            <td><select name="provinsi" id="provinsi" class="form-control" required>
                                    <option value="" selected>Pilih Provinsi</option>
                                    @foreach ($provinces as $item)
                                    <option value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                                    @endforeach
                                </select></td>
                        </tr>
                        <tr>
                            <th>Kota/Kab</th>
                            <td><select name="kota" id="kota" class="form-control" required>
                                    <option value="" disabled selected>Pilih Kota</option>

                                </select></td>
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
    let region = "add";
    $(document).ready(function() {
        reloadData();
        tinymce.init({
            selector: '#deskripsi'
        });
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

    function reloadData() {

        var table = $('#regions-table').DataTable({
            destroy: true,
            ajax: {
                url: "{{ route('region-manager.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'nm_wilayah'
                },
                {
                    data: 'kd_wilayah'
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
        $('#loading').removeClass('show').fadeOut()

    }

    //initial form
    function initialForm() {
        $('#id_wilayah').val("");
        $('#kode_wilayah').val("");
        $('#nama_wilayah').val("");
        $('#provinsi').find('option:selected').removeAttr('selected');
        $('#deskripsi').val("");
        $('#kota').empty();
        tinymce.get('deskripsi').setContent("");

    }


    function regionAdd() {
        region = "add";
        initialForm();

        $('.modal-title').text("Tambah Wilayah");
        $('#regionModal').modal('show');
    }

    function regionDelete(id) {
        if (confirm("Kamu yakin ingin menghapus user ini?")) {
            // console.log('{{ csrf_field() }}')
            $.ajax({
                url: "{{ route('region-manager.index') }}/delete/" + id,
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

    $('#provinsi').on('change', function() {
        // console.log($(this).val());
        $.ajax({
            url: "{{ route('region-manager.index') }}/get-data-kota/" + $(this).val(),
            type: "GET",
            success: function(res) {
                $('#kota').empty();
                // console.log(res)
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

    function regionEdit(id) {
        region = "edit";
        $.ajax({
            url: " {{ route('region-manager.index') }}/edit/" + id,
            method: 'GET',
            success: function(res) {
                // console.log(res)
                $('#id_wilayah').val(res.id_kanwil);
                $('#kode_wilayah').val(res.kd_wilayah);
                $('#nama_wilayah').val(res.nm_wilayah);
                if (res.desc_wilayah) {
                    tinymce.get('deskripsi').setContent(res.desc_wilayah);
                } else {
                    tinymce.get('deskripsi').setContent("");
                }
                $('select[name="provinsi"] option[value="' + res.kd_provinsi + '"]').attr('selected',
                    'selected');
                $('#kota').empty();

                $('#kota').append(
                    `<option value="${res.kd_kota}">${res.kota.nm_kota}</option>`);

                $('.modal-title').text("Edit User");
                $('#regionModal').modal('show');
            }
        });
    }


    $('#regionForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        var content = tinymce.get('deskripsi').getContent();
        formData.push({
            name: 'deskripsi',
            value: content
        });
        // console.log(formData)
        if (region == "add") {
            $.ajax({
                url: "{{ route('region-manager.save') }}",
                type: "POST",
                data: $.param(formData),
                beforeSend: function() {
                    $('.btn-save').html("Loading...");
                    $('.btn-save').attr("disabled", "");
                },
                error: function(res) {
                    $('#regionModal').modal('hide');

                    $('.pesan').text(res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 3000);
                    alert("Error");
                },
                success: function(res) {
                    $('#regionModal').modal('hide');
                    $('.pesan').text("Data berhasil disimpan" );
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


            $.ajax({
                url: "{{ route('region-manager.index') }}/update/" + $('#id_wilayah').val(),
                type: "POST",
                data: $.param(formData),
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
                        }, 7000);
                    alert("Error");
                },
                success: function(res) {
                    // console.log(res)
                    $('#regionModal').modal('hide');
                    $('.pesan').text("Data berhasil diubah" );
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
        }

    });
</script>
@stop

@endsection