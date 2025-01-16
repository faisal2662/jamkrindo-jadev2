@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Category Product</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active">Category Product</li>
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
                                        <button type="button" class="btn btn-primary btn-sm float-end"
                                            onclick="categoryProductAdd()">
                                            Tambah Data
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>
                        <div id="alert" class="alert text-center alert-success alert-dismissible fade  " role="alert">
                            <span class="pesan  text-capitalize"></span>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>

                        <!-- Table with stripped rows -->
                        <table class="table datatable table-hover table-striped" id="categories-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kategori</th>
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
    <div class="modal fade" id="categoryProductModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5 text-center" id="exampleModalLabel">Ubah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" id="categoryProductForm" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-borderless">
                            <input type="hidden" name="kd_kategori_produk" id="kd_kategori_produk">
                            <tr>
                                <th>Nama Kategori <span class="text-danger">*</span></th>
                                <td><input type="text" name="nm_kategori_produk" id="nm_category" class="form-control" required>
                                </td>
                            </tr>
                            <tr>
                                <th>Deskripsi Kategori <span class="text-danger">*</span></th>
                                <td>
                                    <textarea name="description_product" id="description" class="form-control" required rows="5"></textarea>
                                    {{-- <textarea name="keterangan" id="ckeditor" class="form-control" required="" placeholder="Harap di isi ..."></textarea> --}}

                                </td>
                            </tr>
                            <tr>
                                <th>Ikon Kategori
                                    <span id="loading-icon" style="display:none;">
                                        <div class="spinner-border spinner-border-sm" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                    </span>
                                </th>
                                <td>
                                    <select name="icon" id="select-icon" style="width:100%;">
                                        <option value="">Pilih Ikon</option>

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
    {{-- <script src="//cdn.ckeditor.com/4.16.0/full/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('ckeditor');
</script> --}}

@section('script')

    <script>
        let category = "add";
        $(document).ready(function() {
            reloadData();
            //     tinymce.init({
            //         selector: '#description'
            //     });
            $('#select-icon').select2({
            dropdownParent: $('#categoryProductModal'),
            theme: 'bootstrap-5', // Ini opsional, agar sesuai dengan gaya Bootstr
            templateResult: formatIconOption,
            templateSelection: formatIconSelection,
            placeholder: 'Pilih Ikon',
            allowClear: true,
             });
        loadIcons();
        });


        function reloadData() {
            var table = new DataTable('#categories-table', {
                destroy: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('category-manager.getData') }}",
                    type: 'GET'
                },
                columns: [{
                        data: 'no'
                    },
                    {
                        data: 'nm_kategori_produk'
                    },

                    {
                        data: 'action'
                    }
                ]
            });
        }

        //initial form
        function initialForm() {
            $('#kd_kategori_produk').val("");
            $('#nm_category').val("");
            $('#description').val("");
            $('#image').val("");
        }


        function categoryProductAdd() {
            category = "add";
            initialForm();

            $('.modal-title').text("Tambah Kategori");
            $('#categoryProductModal').modal('show');
        }

        function categoryProductDelete(id) {
            if (confirm("Kamu yakin ingin menghapus user ini?")) {
                // console.log('{{ csrf_field() }}')
                $.ajax({
                    url: "{{ route('category-manager.index') }}/delete/" + id,
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

        function categoryProductEdit(id) {
            category = "edit";
            $.ajax({
                url: " {{ route('category-manager.index') }}/edit/" + id,
                method: 'GET',
                success: function(res) {
                    console.log(res)
                    $('#kd_kategori_produk').val(res.kd_kategori_produk);
                    $('#nm_category').val(res.nm_kategori_produk);
                    $('#select-icon').val(null).trigger('change'); // Reset select2 sebelumnya

                    $('#description').val(res.description_produk);
                    // Set nilai select2
                  $('#select-icon').val(res.iconEks).trigger('change'); // Pilih opsi berdasarkan nilai ID/icon


                    $('.modal-title').text("Edit kategori");
                    $('#categoryProductModal').modal('show');
                }
            });
        }

        function loadIcons() {
            $.ajax({
                url: "{{ route('category-manager.icons') }}",
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',

                },
                beforeSend: function() {
                    $('#loading-icon').css('display', 'inline-block');
                    $('.btn-save').attr('disabled', '');
                },
                success: function(data) {
                    console.log(data)
                    if (data.length > 0) {
                        data.forEach(icons => {
                            icons.forEach(icon => {
                                $('#select-icon').append(`
                                <option value="${icon.nameEks}"  data-icon-url="${icon.url}"> ${icon.name}</option>
                                `);
                                console.log(icon.url)
                            });
                        });


                    } else {
                        $('.btn-save').attr('disabled', '');

                        $('#loading-icon').css('display', 'none');
                    }
                },
                complete: function() {
                    $('.btn-save').removeAttr('disabled', '');
                    $('#loading-icon').css('display', 'none');
                }
            });
        }

        // Template untuk opsi dengan ikon
        function formatIconOption(option) {
            if (!option.id) {
                return option.text;
            }
            const iconUrl = $(option.element).data('icon-url');
            return $(
                `<span><img src="${iconUrl}" alt="" style="width:20px; height:20px; margin-right:8px;">${option.text}</span>`
            );
        }

        // Template untuk ikon yang terpilih
        function formatIconSelection(option) {
            if (!option.id) {
                return option.text;
            }
            const iconUrl = $(option.element).data('icon-url');
            return $(
                `<span><img src="${iconUrl}" alt="" style="width:20px; height:20px; margin-right:8px;">${option.text}</span>`
            );
        }



        // Panggil loadIcons pertama kali

        $('#categoryProductForm').on('submit', function(e) {
            e.preventDefault();
            // var formData = $(this).serializeArray();
            // var content = tinymce.get('description').getContent();
            console.log($('#description').val());
            var token = $('#categoryProductForm').find('input[name="_token"]').val();
            var formData = new FormData();
            formData.append('_token', token);
            formData.append('nm_kategori_produk', $('#nm_category').val());
            formData.append('description_produk', $('#description').val());
            formData.append('icon_kategori', $('#select-icon').val());
            // formData.push({
            //     name: 'description',
            //     value: content
            // });

            console.log(formData);
            if (category == "add") {
                $.ajax({
                    url: "{{ route('category-manager.save') }}",
                    type: "POST",
                    // data: $.param(formData),
                    data: formData,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
                    beforeSend: function() {
                        $('.btn-save').html("Loading...");
                        $('.btn-save').attr("disabled", "");
                    },
                    error: function(res) {
                        console.log(res)
                        $('#categoryProductModal').modal('hide');
                        $('#select-icon').val(null).trigger('change'); // Reset select2 sebelumnya
                        $('.pesan').text(res.status);
                        $('#alert').addClass('show').fadeIn();
                        setTimeout(
                            function() {
                                $('#alert').removeClass('show').fadeOut()
                            }, 7000);
                        alert("Error");
                    },
                    success: function(res) {
                        $('#categoryProductModal').modal('hide');
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
                    url: "{{ route('category-manager.index') }}/update/" + $('#kd_kategori_produk').val(),
                    type: "POST",
                    data: formData,
                    contentType: false,
                    enctype: 'multipart/form-data',
                    processData: false,
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
                        $('#categoryProductModal').modal('hide');
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
