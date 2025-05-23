@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Create Product Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Create Product Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class=" mb-2">
        <a href="{{ route('product-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
        <div class="row bg-white p-4">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade text-center  show mb-3" role="alert">
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
                <h5 class="card-title">Edit Produk</h5>
                <form action="{{ route('product-manager.update', $product->kd_produk) }}" id="formProduct" method="post"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Nama Produk</div>
                        <div class="col-lg-9 col-md-8"><input type="text" value="{{ $product->title_produk }}"
                                name="title_produk" id="title_produk" class="form-control"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kategori Produk</div>
                        <div class="col-lg-9 col-md-8">
                            <select name="kd_kategori_produk" id="kategori_produk" class="form-control">
                                <option value="" disabled selected>Pilih Kategori</option>
                                @foreach ($kategori as $item)
                                    <option @if ($item->kd_kategori_produk == $product->kd_kategori_produk) selected @endif
                                        value="{{ $item->kd_kategori_produk }}">{{ $item->nm_kategori_produk }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Tanggal Produk</div>
                        <div class="col-lg-9 col-md-8"><input value="{{ $product->tgl_produk }}" type="date"
                                name="tgl_produk" id="tgl_produk" class="form-control"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Status</div>
                        <div class="col-lg-9 col-md-8">
                            <select name="status_produk" id="status_produk" class="form-control">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Active" @if ($product->status_produk == 'Active') selected @endif>Active</option>
                                <option @if ($product->status_produk == 'Inactive') selected @endif value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="description_produk" id="deskripsi_produk">{{ $product->description_produk }}</textarea>
                              <div class="invalid-feedback deskripsi_invalid" style="display: none;">
                                Deskripsi wajib diisi
                              </div>
                        </div>
                    </div>
                    @if ($product->images_produk)
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label">Foto</div>
                            <div class="col-lg-9 col-md-8">
                                <img src="{{ asset('assets/img/product/' . $product->images_produk) }}"
                                    class="img-thumbnail" width="300px" alt="">
                            </div>
                        </div>
                    @endif
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Upload Foto</div>
                        <div class="col-lg-9 col-md-8">
                            <input type="file" name="images_produk" id="images_produk" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col-lg-5 col-md-8 align-self-center mx-auto"><button type="submit"
                                class="btn btn-primary w-100 text-center">Update</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@section('script')
    <script>
        $(document).ready(function() {
            var baseUrl = window.location.origin;
            // baseUrl += '/master+chat'
            // console.log(baseUrl);
            tinymce.init({
                selector: '#deskripsi_produk',
                toolbar_mode: 'sliding',
                plugins: 'code table lists | image | code | imagetools',
                toolbar1: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent bullist | numlist | code | table | image',
                file_picker_types: 'image',
                automatic_uploads: true,
                images_upload_url: "{{ route('product-manager.uploadImage') }}",
                image_title: true,
                images_file_types: 'jpg,svg,webp,png,PNG,jpeg',
                file_picker_callback: function(cb, value, meta) {
                    var input = document.createElement('input');
                    input.setAttribute('type', 'file');
                    input.setAttribute('accept', 'image/*');

                    input.onchange = function() {
                        var file = this.files[0];
                        var formData = new FormData();
                        formData.append('file', file);

                        fetch("{{ route('product-manager.uploadImage') }}", {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').getAttribute('content')
                                }
                            })
                            .then(response => response.json())
                            .then(data => {
                                let newSrc = baseUrl + data.location;
                                cb(newSrc, {
                                    title: file.name
                                });
                                console.log(data)

                            })
                            .catch(error => {
                                console.error('Error:', error);
                            });
                    };

                    input.click();
                }
            });

        });
        
        $('#formProduct').on('submit', function(e){
            let deskripsi = $('.deskripsi_invalid');
           var content = tinymce.get('deskripsi_produk').getContent();
            // if (content.trim() === '') {
            //          e.preventDefault(); // Cegah form disubmit
            //     deskripsi.show('delay');
               
            // }
            
        })
    </script>
@stop
@endsection
