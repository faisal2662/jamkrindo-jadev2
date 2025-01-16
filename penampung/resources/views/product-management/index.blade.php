@extends('layouts.main')
@section('main')
<div class="pagetitle">
    <h1>Product Management</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Product Management</li>
        </ol>
    </nav>
</div><!-- End Page Title -->
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
                                <!--<button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"-->
                                <!--    data-bs-target="#tambah">-->
                                <!--    Tambah Data-->
                                <!--</button>-->
                                 <a href="{{ route('product-manager.create') }}" class="btn btn-sm btn-primary">Tambah
                                        Data</a>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div id="alert" class="alert text-center alert-success alert-dismissible fade "
                       role="alert">
                        <span class="pesan  text-capitalize">{{ session('success') }}</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                    <!-- Table with stripped rows -->
                    <table class="table table-sm" style="font-size: 12px;" id="products-table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Produk</th>
                                <th>Kategori </th>
                                <th>Status</th>
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
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Tambah Data</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('product-manager.save') }}" enctype="multipart/form-data"
                    id="productForm">
                    @csrf
                    <input type="hidden" name="kd_produk" id="kd_produk">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Produk</th>
                            <td><input type="text" name="nama_produk" id="nama_produk" class="form-control"></td>
                        </tr>
                        <tr>
                            <th>Kategori Produk</th>
                            <td>
                                <select name="kategori_produk" id="kategori_produk" class="form-control">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach ($categories as $item)
                                    <option value="{{ $item->kd_kategori_produk }}">{{ $item->nm_kategori_produk }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Pilih Status</th>
                            <td>
                                <select name="status_produk" id="status_produk" class="form-control">
                                    <option value="" selected disabled>Pilih status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi Produk</th>
                            <td>
                                <textarea name="description_product" id="description_produk" rows="6" class="form-control"></textarea>
                            </td>
                        </tr>
                        <tr>
                            <th>Foto</th>
                            <td><input type="file" name="image_produk" id="images_produk" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Produk</th>
                            <td><input type="date" name="tgl_produk" id="tgl_produk" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-primary h-25 w-75 btn-save">Tambah</button>
                            </td>
                        </tr>
                    </table>

                </form>
            </div>
        </div>
    </div>

</div>

@foreach ($products as $item)
<div class="modal fade" id="edit{{ $item->kd_produk }}" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Ubah Produk</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('product-manager.index') }}/update/{{ $item->id }}"
                    enctype="multipart/form-data" id="productForm">
                    @csrf
                    <input type="hidden" name="kd_produk" id="kd_produk">
                    <table class="table table-borderless">
                        <tr>
                            <th>Nama Produk</th>
                            <td><input type="text" value="{{ $item->title_produk }}" name="nama_produk"
                                    id="nama_produk" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Kategori Produk</th>
                            <td>
                                <select name="kategori_produk" id="kategori_produk" class="form-control">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach ($categories as $category)
                                    <option @if ($item->kd_kategori_produk == $category->kd_kategori_produk) selected @endif
                                        value="{{ $category->kd_kategori_produk }}">
                                        {{ $category->nm_kategori_produk }}
                                    </option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Pilih Status</th>
                            <td>
                                <select name="status_produk" id="status_produk" class="form-control">
                                    <option value="" selected disabled>Pilih status</option>
                                    <option value="Active" @if ($item->status_produk == 'Active') selected @endif>Active
                                    </option>
                                    <option value="Inactive" @if ($item->status_produk == 'Inactive') selected @endif>
                                        Inactive</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Deskripsi Produk</th>
                            <td>
                                <textarea name="description_product" id="description_produk_ubah" rows="6" class="form-control">{{ $item->description_produk }}</textarea>
                            </td>
                        </tr>
                        <tr>
                            <th rowspan="2">Foto</th>
                            <td><img src="{{ asset('assets/img/product/' . $item->images_produk) }}"
                                    width="350px" alt="">
                            </td>
                        </tr>
                        <tr>

                            <td><input type="file" name="image_produk" id="images_produk"
                                    class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <th>Tanggal Produk</th>
                            <td><input type="date" name="tgl_produk" id="tgl_produk" class="form-control"
                                    value="{{ $item->tgl_produk }}">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-center">
                                <button type="submit" class="btn btn-warning h-25 w-75 btn-save">Update</button>
                            </td>
                        </tr>
                    </table>

                </form>
            </div>
        </div>
    </div>

</div>
@endforeach



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

@if (session('success'))
<script>
    $(document).ready(function() {
        $('#alert').addClass('show').fadeIn();
        setTimeout(
            function() {
                $('#alert').removeClass('show').fadeOut()
            }, 7000);
    });
</script>
@endif
<script>
    let product = "add";
    $(document).ready(function() {
        reloadData();
          tinymce.init({
            selector: '#description_produk'
        });
    });


    function reloadData() {

        var table = new DataTable('#products-table', {
            destroy: true,
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('product-manager.getData') }}",
                type: 'GET'
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'title_produk'
                },
                {
                    data: 'category_product.nm_kategori_produk'
                },
                {
                    data: 'status_produk'
                },

                {
                    data: 'action'
                }
            ]
        });

    }

    //initial form
    function initialForm() {
        $('#kd_produk').val("");
        $('#nama_produk').val("");
        $('#kategori_produk').val("");
        $('#status_produk').val("");
        $('#description-produk').val("");
        $('#images-produk').val("");
        $('#tgl-produk').val("");

    }

    function productAdd() {
        user = "add";
        initialForm();

        $('.modal-title').text("Tambah Produk");
        $('#productModal').modal('show');
    }

    function formDelete(id) {
        if (confirm("Kamu yakin ingin menghapus produk ini?")) {
            // console.log('{{ csrf_field() }}')
            $.ajax({
                url: "{{ route('product-manager.index') }}/delete/" + id,
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

    // function productEdit(id) {
    //     user = "edit";
    //     $.ajax({
    //         url: " {{ route('product-manager.index') }}/edit/" + id,
    //         method: 'GET',
    //         success: function(res) {
    //             console.log(res)
    //             $('#kd_produk').val(res.id);
    //             $('#nama_produk').val(res.title_produk);
    //             $('input[name="kategori_produk"][value="' + res.kd_kategori_produk + '"]').prop('checked',
    //                 true);
    //             $('input[name="status_produk"][value="' + res.status_produk + '"]').prop('checked',
    //                 true);
    //             $('#description-produk').val(res.description_produk);
    //             $('#images-produk').val(res.images_produk);
    //             $('#tgl-produk').val(res.tgl_produk);
    //             $('.modal-title').text("Edit User");
    //             $('#productModal').modal('show');
    //         }
    //     });
    // }

    // $('#productForm').on('submit', function(e) {
    //     e.preventDefault();
    //     console.log($('#productForm').serialize());
    //     if (product == "add") {
    //         $.ajax({
    //             url: "{{ route('product-manager.save') }}",
    //             type: "POST",
    //             data: $('#productForm').serialize(),
    //             beforeSend: function() {
    //                 $('.btn-save').html("Loading...");
    //                 $('.btn-save').attr("disabled", "");
    //             },
    //             error: function(res) {
    //                 console.log(res.status)
    //                 $('.pesan').text(res.status);
    //                 $('#alert').addClass('show').fadeIn();
    //                 setTimeout(
    //                     function() {
    //                         $('#alert').removeClass('show').fadeOut()
    //                     }, 3000);
    //                 alert("Error");
    //             },
    //             success: function(res) {
    //                 $('#productModal').modal('hide');
    //                 $('.pesan').text("Simpan " + res.status);
    //                 $('#alert').addClass('show').fadeIn();
    //                 setTimeout(
    //                     function() {
    //                         $('#alert').removeClass('show').fadeOut()
    //                     }, 3000);
    //                 // alert(res.status);
    //                 reloadData();
    //             },
    //             complete: function() {
    //                 $('.btn-save').html("Save");
    //                 $('.btn-save').removeAttr("disabled");
    //                 initialForm();
    //             }
    //         });
    //     } else {
    //         $.ajax({
    //             url: "{{ route('product-manager.index') }}/edit/" + $('#idUser').val(),
    //             type: "POST",
    //             data: $('#userForm').serialize(),
    //             beforeSend: function() {
    //                 $('.btn-save').html("Loading...");
    //                 $('.btn-save').attr("disabled", "");
    //             },
    //             error: function(res) {

    //                 $('.pesan').text(res.status);
    //                 $('#alert').addClass('show').fadeIn();
    //                 setTimeout(
    //                     function() {
    //                         $('#alert').removeClass('show').fadeOut()
    //                     }, 3000);
    //                 alert("Error");
    //             },
    //             success: function(res) {
    //                 console.log(res)
    //                 $('#userModal').modal('hide');
    //                 $('.pesan').text("Simpan " + res.status);
    //                 $('#alert').addClass('show').fadeIn();
    //                 setTimeout(
    //                     function() {
    //                         $('#alert').removeClass('show').fadeOut()
    //                     }, 3000);
    //                 // alert(res.status);
    //                 reloadData();
    //             },
    //             complete: function() {
    //                 $('.btn-save').html("Save");
    //                 $('.btn-save').removeAttr("disabled");
    //                 initialForm();
    //             }
    //         });
    //     }

    // });
</script>
@stop
@endsection
