@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Edit News Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit News Management</li>
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

            <form action="{{ route('news-manager.update',  $news->id_berita) }}" id="formNews" method="post"
                enctype="multipart/form-data">
                @csrf


                <div class="col tab-pane fade show active profile-overview">
                    <h5 class="card-title">Edit Berita</h5>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Judul</div>
                        <div class="col-lg-9 col-md-8"><input type="text"
                                name="judul_berita"value="{{ $news->judul_berita }}" id="title_berita" class="form-control"
                                required></div>

                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Tanggal / Waktu Upload</div>
                        <div class="col-lg-9 col-md-8"> <input type="datetime-local" value="{{ $news->tgl_berita }}"
                                name="tgl_berita" id="tgl_upload" required class="form-control"></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Status Berita</div>
                        <div class="col-lg-9 col-md-8"><select name="status_berita" id="status_berita" class="form-control"
                                required>
                                <option value="" disabled>Pilih Status</option>
                                <option @if ($news->status_berita == 'Publish') selected @endif value="Publish">Publish</option>
                                <option @if ($news->status_berita == 'Pending') selected @endif value="Pending">Pending</option>
                            </select></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Deskripsi Berita</div>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="isi_berita" id="deskripsi_berita" cols="10">{{ $news->isi_berita }}</textarea>
                               <div class="invalid-feedback deskripsi_invalid" style="display: none;">
                            Deskripsi wajib diisi
                          </div>
                        </div>
                    </div>
                    @if ($news->foto_berita)
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label">Banner</div>
                            <div class="col-lg-9 col-md-8">
                                <img src="{{ asset('assets/img/news/' . $news->foto_berita) }}" width="300px"
                                    alt="">
                            </div>
                        </div>
                    @endif
                    <div class="row mb-4">
                        <div class="col-lg-3 col-md-4 label">Banner Berita</div>
                        <div class="col-lg-9 col-md-8"><input type="file" name="foto_berita" id="banner_berita"
                                class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col-lg-5 col-md-8 align-self-center mx-auto"><button type="submit"
                                class="btn btn-primary w-100 text-center">Update</button>
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
                selector: 'textarea#deskripsi_berita',
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
                                // // console.log(file.src)
                                cb(newSrc, {
                                    title: file.name
                                });
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
            if (content.trim() === '') {
                // console.log('kosong')
                     e.preventDefault(); // Cegah form disubmit
                deskripsi.show('delay');

            }

        })
    </script>
@stop
@endsection
