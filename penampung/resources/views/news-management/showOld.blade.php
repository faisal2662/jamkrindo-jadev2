@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Detail News Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Detail News Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class=" mb-2">
        <a href="{{ route('news-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
        <div class="row bg-white p-4">

            <div class="col tab-pane fade show active profile-overview">
                <h5 class="card-title">Detail Informasi</h5>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Judul</div>
                    <div class="col-lg-9 col-md-8">{{ $news->judul_berita }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Tanggal Upload</div>
                    <div class="col-lg-9 col-md-8">{{ $formattedDate }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Status</div>
                    <div class="col-lg-9 col-md-8">
                        @if ($news->status_berita == 'Publish')
                            <span class="badge bg-success ">{{ $news->status_berita }}</span>
                        @else
                            <span class="badge bg-warning ">{{ $news->status_berita }}</span>
                        @endif
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Gambar</div>
                    <div class="col-lg-9 col-md-8"><img src="{{ asset('assets/img/news/' . $news->foto_berita) }}"
                            width="300px" class="img-thumbnail" alt=""></div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-3 col-md-4 label">Deskripsi Berita</div>
                    <div class="col-lg-9 col-md-8">
                        {!! $news->isi_berita !!}
                    </div>
                </div>


            </div>
        </div>
    </section>
@endsection
