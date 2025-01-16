@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Users</li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">
                        @if ($customer->foto_customer)
                            <img src="{{ asset('assets/img/customer/' . $customer->foto_customer) }}" salt="Profile"
                                class="rounded-circle">
                        @else
                            <img src="{{ asset('assets/img/person.png') }}" alt="Profile" class="rounded-circle">
                        @endif
                        <h2>{{ Auth::user()->nama_customer }}</h2>
                        <h3>{{ $customer->branch->nm_cabang }}</h3>

                    </div>
                </div>

            </div>

            <div class="col-xl-8">

                <div class="card">

                    <div class="card-body pt-3">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center    show "
                                role="alert" id="success-notification" >
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif
                        <!-- Bordered Tabs -->
                        <ul class="nav nav-tabs nav-tabs-bordered">

                            <li class="nav-item">
                                <button class="nav-link active" data-bs-toggle="tab"
                                    data-bs-target="#profile-overview">Overview</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#profile-edit">Edit
                                    Profile</button>
                            </li>

                            <li class="nav-item">
                                <button class="nav-link" data-bs-toggle="tab"
                                    data-bs-target="#profile-change-password">Change
                                    Password</button>
                            </li>

                        </ul>
                        <div class="tab-content pt-2">

                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Profil Detail</h5>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Nama Cabang</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->nama_customer }}</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->hp_customer }}</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">User ID</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->userid_customer }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->email_customer }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Cabang</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->branch->nm_cabang }}</div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Status</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if ($customer->status_customer == 'Active')
                                            <span class="text-bg-success badge">{{ $customer->status_customer }}</span>
                                        @else
                                            <span class="badge text-bg-danger ">{{ $customer->status_customer }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Kode Referral</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->kd_referral_customer }}</div>
                                </div>
                                <hr>
                                <h5 class="card-title">Perusahaan</h5>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->company_name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Provinsi</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->Province->nm_provinsi }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Kota</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->City->nm_kota }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Terms</div>
                                    <div class="col-lg-9 col-md-8">{{ $customer->terms }}</div>
                                </div>

                            </div>

                            <div class="tab-pane fade profile-edit pt-3" id="profile-edit">
                                @if (Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible fade text-center  show "
                                        role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
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
                                <form method="POST"
                                    action="{{ route('profile-update-customer', $customer->kd_customer) }}"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Nama<span class="text-danger me-3">*</span>
                                        </div>
                                        <div class="col-lg-9 col-md-8"><input type="text"
                                                value="{{ $customer->nama_customer }}" name="nama_customer"
                                                class="form-control" id="nama_customer" required>
                                        </div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">No. Telpon</div>
                                        <div class="col-lg-9 col-md-8"><input type="number"
                                                value="{{ $customer->hp_customer }}" name="hp_customer" id="hp_customer"
                                                required class="form-control"></div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">User ID <span
                                                class="text-danger me-3">*</span>
                                        </div>
                                        <div class="col-lg-9 col-md-8"><input type="text"
                                                value="{{ $customer->userid_customer }}" name="userid_customer"
                                                id="userid_customer" required class="form-control"></div>
                                    </div>

                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Email <span class="text-danger me-3">*</span>
                                        </div>
                                        <div class="col-lg-9 col-md-8"><input type="email"
                                                value="{{ $customer->email_customer }}" name="email_customer"
                                                id="email_customer" required class="form-control"></div>
                                    </div>

                                    @if ($customer->foto_customer)
                                        <div class="row mb-2">
                                            <div class="col-lg-3 col-md-4 label">Foto</div>
                                            <div class="col-lg-9 col-md-8">
                                                <img src="{{ asset('assets/img/customer/' . $customer->foto_customer) }}"
                                                    width="250px" alt="">
                                            </div>
                                        </div>
                                    @endif
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Update Foto </div>
                                        <div class="col-lg-9 col-md-8"><input type="file" class="form-control"
                                                name="foto_customer" id="foto_customer">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Kode Referrel </div>
                                        <div class="col-lg-9 col-md-8"><input type="text" class="form-control"
                                                name="kd_referral_customer" placeholder="Opsional"
                                                value="{{ $customer->kd_referral_customer }}" id="kd_referral_customer">
                                        </div>
                                    </div>
                                    {{-- <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Provinsi</div>
                                                <div class="col-lg-9 col-md-8"><select name="provinsi" id="provinsi" class="form-control">
                                                        <option value="" disabled selected>Pilih Provinsi</option>
                                                        @foreach ($provinsi as $item)
                                                            <option value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}</option>
                                                        @endforeach
                                                    </select></div>
                                            </div>
                                            <div class="row mb-2">
                                                <div class="col-lg-3 col-md-4 label">Kota</div>
                                                <div class="col-lg-9 col-md-8"><select name="kota" id="kota" class="form-control">
                                                        <option value=""></option>
                                                    </select></div>
                                            </div> --}}
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Wilayah</div>
                                        <div class="col-lg-9 col-md-8"><select name="wilayah" id="wilayah"
                                                class="form-control">
                                                <option value="" disabled selected> Piih Wilayah</option>
                                                @foreach ($wilayah as $item)
                                                    <option value="{{ $item->id_kanwil }}">{{ $item->nm_wilayah }}
                                                    </option>
                                                @endforeach
                                            </select></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Pilih Cabang </div>
                                        <div class="col-lg-9 col-md-8"><select name="cabang" id="cabang"
                                                class="form-control">
                                                <option value="{{ $customer->branch->id_cabang }}">
                                                    {{ $customer->branch->nm_cabang }}</option>
                                            </select></div>
                                    </div>



                                    <hr>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Nama Perusahaan</div>
                                        <div class="col-lg-9 col-md-8"><input type="text"
                                                value="{{ $customer->company_name }}" name="company_name"
                                                class="form-control" id="company_name">
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Provinsi </div>
                                        <div class="col-lg-9 col-md-8">
                                            <select name="company_province" id="company_province" class="form-control">
                                                <option value="" disabled selected> Pilih Provinsi</option>
                                                @foreach ($provinsi as $item)
                                                    <option @if ($item->kd_provinsi == $customer->company_province) selected @endif
                                                        value="{{ $item->kd_provinsi }}">{{ $item->nm_provinsi }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Kota </div>
                                        <div class="col-lg-9 col-md-8">
                                            <select name="company_city" id="company_city" class="form-control">
                                                @if ($customer->company_city)
                                                    <option value="{{ $customer->city->kd_kota }}">
                                                        {{ $customer->city->nm_kota }}
                                                    </option>
                                                @else
                                                    <option value=""></option>
                                                @endif

                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-3 col-md-4 label">Terms</div>
                                        <div class="col-lg-9 col-md-8"><input value="{{ $customer->terms }}"
                                                type="text" class="form-control" name="terms" id="terms">
                                        </div>
                                    </div>
                                    <div class="row mb-2 justify-content-center">
                                        <div class="col col-lg-7"><button type="submit"
                                                class="btn btn-primary w-75">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>



                            <div class="tab-pane fade pt-3" id="profile-change-password">
                                <!-- Change Password Form -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                @if (Session::has('error'))
                                    <div class="alert alert-danger alert-dismissible fade text-center  show "
                                        role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                @endif

                                <form method="POST"
                                    action="{{ route('change-password-customer', $customer->kd_customer) }}">
                                    @csrf
                                    <div class="row mb-3">
                                        <label for="oldPassword" class="col-md-4 col-lg-3 col-form-label">Current
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="oldPassword" type="password" class="form-control"
                                                id="oldPassword">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-lg-3 col-form-label">New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password" type="password" class="form-control" id="Password">
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="password" class="col-md-4 col-lg-3 col-form-label">Re-enter New
                                            Password</label>
                                        <div class="col-md-8 col-lg-9">
                                            <input name="password_confirmation" type="password" class="form-control"
                                                id="password">
                                        </div>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-primary">Change Password</button>
                                    </div>
                                </form><!-- End Change Password Form -->

                            </div>

                        </div><!-- End Bordered Tabs -->

                    </div>
                </div>

            </div>
        </div>
    </section>
@section('script')
    <script>
        const password = document.getElementById('password');
        const password_confirm = document.getElementById('password_confirmation');
        const invalidPassword = document.getElementsByClassName('invalid-password')[0];
        const invalidPassword1 = document.getElementsByClassName('invalid-password')[1];
        const show = document.getElementById('show');
        const show1 = document.getElementById('show1');
        password.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value.length <= 8) {
                invalidPassword.style.display = 'block';
            } else {
                invalidPassword.style.display = 'none';

            }
        });
        password_confirm.addEventListener('keyup', (e) => {
            const value = e.target.value;
            if (value.length <= 8) {
                invalidPassword1.style.display = 'block';
            } else {
                invalidPassword1.style.display = 'none';

            }
        });

        show.addEventListener('click', (e) => {
            // console.log(password.getAttribute('type'))
            if (password.getAttribute('type') == 'password') {
                password.setAttribute('type', 'text');
                show.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password.setAttribute('type', 'password');
            }
        })
        show1.addEventListener('click', (e) => {
            // console.log(password1.getAttribute('type'))
            if (password_confirm.getAttribute('type') == 'password') {
                password_confirm.setAttribute('type', 'text');
                show1.classList.replace('bi-eye-fill', 'bi-eye-slash-fill');
            } else {
                show1.classList.replace('bi-eye-slash-fill', 'bi-eye-fill');
                password_confirm.setAttribute('type', 'password');
            }
        })
    </script>
    <script>
        $(document).ready(function() {

            var $notification = $('#success-notification');
            if ($notification.length > 0) {
                // Tampilkan notifikasi
                $notification.fadeIn('slow');
                // Menghilangkan notifikasi dengan delay
                setTimeout(function() {
                    $notification.fadeOut('slow');
                }, 3000); // Delay sebelum notifikasi menghilang (dalam milidetik)
            }
        });
        $('#company_province').on('change', function() {
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataKota', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#company_city').empty();
                    res.forEach(function(city) {

                        $('#company_city').append(
                            `<option value="${city.kd_kota}">${city.tipe} | ${city.nm_kota}</option>`
                        );
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil kota");
                }

            })
        })


        $('#wilayah').on('click', function() {
            // console.log('berubah')
            // console.log($(this).val());
            $.ajax({
                url: "{{ route('getDataCabang', '') }}/" + $(this).val(),
                type: "GET",
                success: function(res) {
                    $('#cabang').empty();
                    // console.log(res)
                    if (res.length == 0) {

                        $('#cabang').append(
                            `<option value="">Belum tersedia</option>`
                        );
                    }
                    res.forEach(function(cabang) {
                        $('#cabang').append(
                            `<option value="${cabang.id_cabang}" data-kode="${cabang.kd_cabang}">${cabang.nm_cabang}</option>`
                        );
                    })
                },
                error: function(err) {
                    alert("Gagal mengambil cabang");
                }

            })
        })
    </script>
@stop
@endsection
