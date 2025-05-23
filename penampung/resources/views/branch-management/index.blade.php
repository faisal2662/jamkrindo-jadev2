@extends('layouts.main')
@section('main')
<div class="pagetitle">
    <h1>Branch</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Branch</li>
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
                                <!--<button type="button" class="btn btn-primary btn-sm float-end" onclick="branchAdd()">-->
                                <!--    Tambah Data-->
                                <!--</button>-->
                                  <!-- <a href="{{ route('branch-manager.tambah') }}" class="btn btn-primary btn-sm float-end">
                                        Tambah Data
                                    </a> -->
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="alert" class="alert text-center alert-success alert-dismissible fade  "
                         role="alert">
                        <span class="pesan text-center text-capitalize"></span>
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
                    <table class="table datatable  table-hover table-striped" id="branchs-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Cabang</th>
                                <th>Kode Cabang</th>
                                <th>Wilayah</th>
                                <!--<th>Location String</th> -->
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
<div class="modal fade" id="branchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="branchForm">
                    @csrf
                    <input type="hidden" name="id_cabang" id="id_cabang">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Cabang</th>
                            <td><input type="text" name="nama_cabang" id="nama_cabang" class="form-control" required></td>
                        </tr>
                        <tr>
                            <th>Kode Cabang</th>
                            <td><input type="text" name="kode_cabang" id="kode_cabang" class="form-control" ></td>
                        </tr>
                        <tr>
                            <th>Wilayah</th>
                            <td>
                                <select name="wilayah" id="wilayah" class="form-control">
                                    <option value="" disabled selected>Piih Wilayah</option>
                                    @foreach ($regional as $item)
                                    <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}</option>
                                    @endforeach
                                </select>

                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi Cabang</th>
                            <td>
                                <textarea name="" id="deskripsi"></textarea>
                                
                            </td>
                        </tr>
                        <tr>
                            <th>Latitude</th>
                            <td><input type="text" name="latitude" id="latitude" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Longitude</th>
                            <td><input type="text" name="longitude" id="longitude" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Url Lokasi</th>
                            <td><input type="text" name="url_location" id="url_location" class="form-control"></td>
                        </tr>
 <tr>
                                <th>Provinsi</th>
                                <td><select name="provinsi" id="provinsi" class="form-control">
                                        <option value="" disabled selected>Pilih Provinsi</option>
                                        @foreach ($provinsi as $item)
                                            <option value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Kota</th>
                                <td><select name="kota" id="kota" class="form-control">
                                        <option value="" disabled selected>Pilih Kota</option>

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
    let branch = "add";
    $(document).ready(function() {
          var baseUrl = window.location.origin;
            console.log(baseUrl);
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
        var table = new DataTable('#branchs-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "{{ route('branch-manager.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'nm_cabang'
                },
                {
                    data: 'kode_uker'
                },
                {
                    data: 'nm_kanwil'
                },

                {
                    data: 'action'
                }
            ]
        });
    }

    //initial form
    function initialForm() {
        $('#id_cabang').val("");
        $('#nama_cabang').val("");
        $('#kode_cabang').val("");
        $('#wilayah').find('option:selected').removeAttr('selected');
        $('select[name="wilayah"] option[value="0"]').attr('selected', true);
        $('#latitude').val("");
        $('#longitude').val("");
        $('#url_location').val("");
                  $('#provinsi').val("");
            $('#kota').val("");
        tinymce.get('deskripsi').setContent("");

    }


    function branchAdd() {
        branch = "add";
        initialForm();
        $('#wilayah').find('option:selected').removeAttr('selected');
        $('select[name="wilayah"] option[value="0"]').attr('selected', true);
        // $('#wilayah').val();
        $('.modal-title').text("Tambah Cabang");
        $('#branchModal').modal('show');
    }

    function branchDelete(id) {
        if (confirm("Kamu yakin ingin menghapus user ini?")) {
            // console.log('{{ csrf_field() }}')
            $.ajax({
                url: "{{ route('branch-manager.index') }}/delete/" + id,
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

            });
            });

    function branchEdit(id) {
        branch = "edit";
        $('select#wilayah').find('option:selected').removeAttr('selected');
        $.ajax({
            url: " {{ route('branch-manager.index') }}/edit/" + id,
            method: 'GET',
            success: function(res) {
                // console.log(res)

                $('#id_cabang').val(res.id_cabang);
                $('#kode_cabang').val(res.kd_cabang);
                $('#nama_cabang').val(res.nm_cabang);
                if (res.desc_cabang) {
                    tinymce.get('deskripsi').setContent(res.desc_cabang);
                } else {
                    tinymce.get('deskripsi').setContent("");
                }

                $('#latitude').val(res.latitude_cabang);
                $('#longitude').val(res.longitude_cabang);
                $('#url_location').val(res.url_location);
      $('select[id="wilayah"] option[value="' + res.kd_wilayah + '"]').attr('selected',
                      'selected');
                    $('select[name="provinsi"] option[value="' + res.kd_provinsi + '"]').attr('selected',
                        'selected');
                    $('#kota').empty();

                    $('#kota').append(
                        `<option value="${res.kota.kd_kota}">${res.kota.nm_kota}</option>`);


                $('.modal-title').text("Edit Cabang");
                $('#branchModal').modal('show');
            }
        });
    }


    $('#branchForm').on('submit', function(e) {
        e.preventDefault();
        var formData = $(this).serializeArray();
        var content = tinymce.get('deskripsi').getContent();
        
        formData.push({
            name: 'deskripsi',
            value: content
        });
        // console.log(formData)
        if (branch == "add") {
            $.ajax({
                url: "{{ route('branch-manager.save') }}",
                type: "POST",
                data: $.param(formData),
                beforeSend: function() {
                    $('.btn-save').html("Loading...");
                    $('.btn-save').attr("disabled", "");
                },
                error: function(res) {
                    $('#branchModal').modal('hide');

                    $('.pesan').text(res.status);
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
                    alert("Error");
                },
                success: function(res) {
                    $('#branchModal').modal('hide');
                    $('.pesan').text("Data berhasil disimpan");
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
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
                url: "{{ route('branch-manager.index') }}/update/" + $('#id_cabang').val(),
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
                    $('#branchModal').modal('hide');
                    $('.pesan').text("Data berhasil diubah");
                    $('#alert').addClass('show').fadeIn();
                    setTimeout(
                        function() {
                            $('#alert').removeClass('show').fadeOut()
                        }, 7000);
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