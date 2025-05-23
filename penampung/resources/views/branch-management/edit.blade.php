@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Edit branch Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Branch Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <a href="{{ route('branch-manager.index') }}" class="btn btn-secondary btn-sm mb-3  "><i
            class="bi bi-arrow-left-short"></i>
        Kembali</a>
    <section class="profile">
        <div class="row bg-white p-4">
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissible fade text-center  show " role="alert">
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


            <div class="tab-pane fade show active profile-overview">
                <h5 class="card-title">Edit Cabang</h5>
                <form action="{{ route('branch-manager.update', $cabang->id_cabang) }}" method="post">
                    @csrf

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Nama Cabang <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="nm_cabang" id="nm_cabang"
                                value="{{ $cabang->nm_cabang }}" required class="form-control"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kode Cabang </div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="kd_cabang"
                                value="{{ $cabang->kd_cabang }}" id="kd_cabang" class="form-control"></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Wilayah <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><select name="kd_wilayah" id="kd_wilayah" class="form-control" required>
                                <option value="" disabled>Pilih Wilayah</option>
                                @foreach ($wilayah as $item)
                                    <option value="{{ $item->id_kanwil }}"
                                        @if ($item->id_kanwil == $cabang->kd_wilayah) selected @endif>{{ $item->nm_wilayah }}</option>
                                @endforeach
                            </select></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Deskripsi</div>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="desc_cabang" id="deskripsi" class="form-control">{{ $cabang->desc_cabang }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Provinsi <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><select required name="kd_provinsi" id="provinsi"
                                class="form-control">
                                <option value="" disabled>Pilih provinsi</option>
                                @foreach ($provinsi as $item)
                                    <option value="{{ $item->kd_provinsi }}"
                                        @if ($item->kd_provinsi == $cabang->kd_provinsi) selected @endif>{{ $item->nm_provinsi }}</option>
                                @endforeach
                            </select></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Kota <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><select name="kd_kota" id="kota" class="form-control"
                                required>
                                <option value="" disabled>Pilih kota</option>
                                @if ($cabang->Kota)
                                    <option value="{{ $cabang->Kota->kd_kota }}">{{ $cabang->Kota->nm_kota }}</option>
                                @endif
                            </select></div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Latitude <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="latitude_cabang" id="latitude"
                                class="form-control" value="{{ $cabang->latitude_cabang }}" required></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Longitude <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="longitude_cabang" id="longtude"
                                class="form-control" value="{{ $cabang->longitude_cabang }}" required></div>
                    </div>

                    <!-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Url Lokasi</div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="url_location" id="url_location"
                                class="form-control" value="{{ $cabang->url_location }}"></div>
                    </div> -->
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Alamat <span class="text-danger">*</span></div>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="alamat_cabang" id="alamat" rows="3" class="form-control" required>{{ $cabang->alamat_cabang }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                        <div class="col-lg-9 col-md-8"><input type="number" name="telp_cabang"
                                value="{{ $cabang->telp_cabang }}" id="telp" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Email</div>
                        <div class="col-lg-9 col-md-8"><input type="email" name="email" id="email"
                                class="form-control" value="{{ $cabang->email }}">
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Fax</div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="fax" id="fax"
                                class="form-control" value="{{ $cabang->fax }}"></div>
                    </div>
                    <div class="row mb-2 justify-content-center">
                        <div class="col col-lg-7"><button type="submit" class="btn btn-primary w-75">Simpan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </section>
@section('script')
    <script>
        $(document).ready(function() {
            $('#provinsi').select2({
                theme: 'bootstrap-5',  // Ini opsional, agar sesuai dengan gaya Bootstrap 5
		placeholder: 'Pilih Provinsi',
            });
            $('#kota').select2({
                theme: 'bootstrap-5',  // Ini opsional, agar sesuai dengan gaya Bootstrap 5
		placeholder: 'Pilih Kota',
            });

            tinymce.init({
                selector: '#deskripsi'
            });
        });
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

            })
        });
    </script>
@stop
@endsection
