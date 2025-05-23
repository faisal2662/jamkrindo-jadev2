@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Create News Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Create News Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class=" mb-2">
        <a href="{{ route('news-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
        <div class="row bg-white p-4">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade text-center  show mb-4" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('news-manager.store') }}" method="post" id="formNews"  enctype="multipart/form-data">
                @csrf


                <div class="col tab-pane fade show active profile-overview">
                    <h5 class="card-title">Tambah Berita</h5>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label" >Judul <span class="text-danger" >*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="title_berita" id="title_berita"
                                class="form-control" required></div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Tanggal / Waktu Upload  <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"> <input type="datetime-local" name="tgl_upload" id="tgl_upload"
                                required class="form-control" required></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Status Berita  <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><select name="status_berita" id="status_berita" class="form-control"
                                required>
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Publish">Publish</option>
                                <option value="Pending">Pending</option>
                            </select></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Deskripsi Berita  <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8">
                            <div name="deskripsi"  id="deskripsi_berita" ></div>
                          <div class="invalid-feedback deskripsi_invalid" style="display: none;">
                                Deskripsi wajib diisi
                              </div>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-4 label">Banner Berita  <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="file" name="banner_berita" id="banner_berita"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col-lg-5 col-md-8 align-self-center mx-auto"><button type="submit"
                                class="btn btn-primary w-100 text-center">simpan</button>
                        </div>
                    </div>
                </div>
            </form>


        </div>
    </section>

@section('script')
   <script>
        $(document).ready(function() {
            var baseUrl = window.location.origin;
            // baseUrl += '/master+chat'
            // console.log(baseUrl);
            tinymce.init({
                selector: '#deskripsi_berita',
                toolbar_mode: 'sliding',
                plugins: 'code table lists | image | code | imagetools',
                toolbar1: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent bullist | numlist | code | table | image',
                file_picker_types: 'image',
                automatic_uploads: true,
                images_upload_url: "{{ route('news-manager.uploadImage') }}",
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

                        fetch("{{ route('news-manager.uploadImage') }}", {
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
      $('#formNews').on('submit', function(e){
            let deskripsi = $('.deskripsi_invalid');
           var content = tinymce.get('deskripsi_berita').getContent();
            // if (content.trim() === '') {
            //     console.log('kosong')
            //          e.preventDefault(); // Cegah form disubmit
            //     deskripsi.show('delay');
               
            // }
            
        })
    </script>
@stop
@endsection
