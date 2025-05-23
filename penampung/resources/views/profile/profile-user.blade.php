@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Profile</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">User </li>
                <li class="breadcrumb-item active">Profile</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section profile">
        <div class="row">
            <div class="col-xl-4">

                <div class="card">
                    <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

                        <img src="{{ asset('assets/img/person.png') }}" alt="Profile" class="rounded-circle">
                        <h2>{{ auth()->user()->nm_user }}</h2>
                        <h3>{{ $user->branch_name }}</h3>
                    </div>
                </div>

            </div>
            <div class="col-xl-8">
                <div class="card">
                    <div class="card-body pt-3">
                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible fade text-center    show " role="alert"
                                id="success-notification">
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
                        </ul>
                        <div class="tab-content pt-2">
                            <div class="tab-pane fade show active profile-overview" id="profile-overview">

                                <h5 class="card-title">Profile Details</h5>

                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">NPP</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->npp_user }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Nama</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->nm_user }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Tanggal Lahir</div>
                                    <div class="col-lg-9 col-md-8">{{ date('d-m-Y', strtotime($user->date)) }}</div>
                                </div>
                              
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Email</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->email }}</div>
                                </div>
                                
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Status User</div>
                                    <div class="col-lg-9 col-md-8">
                                        @if ($user->status_user == 'Active')
                                            <span class="badge bg-success">{{ $user->status_user }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $user->status_user }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Role User </div> 
                                    <div class="col-lg-9 col-md-8">
                                        @if ($user->id_role != '1')
                                            <span class="badge bg-secondary">Admin</span>
                                        @else
                                            <span class="badge bg-secondary">Super Admin</span>
                                        @endif 
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Alamat</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->primary_address }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">No .Telpon</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->primary_phone  }}</div>
                                </div>
                                <!-- <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Kota</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->nm_kota}}</div>
                                </div> -->
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Kode Cabang </div>
                                    <div class="col-lg-9 col-md-8">{{ $user->branch_code }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Nama Cabang </div>
                                    <div class="col-lg-9 col-md-8">{{ $user->branch_name }}</div>
                                </div>

                                <!-- <div class="row mb-2">
                                    <div class="col-lg-3 col-md-4 label">Wilayah Perusahaan</div>
                                    <div class="col-lg-9 col-md-8">{{ $user->nm_wilayah }}</div>
                                </div> -->
                                <hr>
                                <label for="" class="label">Log</label>
                                <table class="table" id="table-log">
                                    <thead>
                                        <tr>
                                            <th>No.</th>
                                            <th>Nama </th>
                                            <th>Tanggal</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


@section('script')

    <script>
        $('#table-log').DataTable({
            ajax: {
                url: "{{ route('user-manager.getLog') }}",
                method: "GET"
            },
            columns: [
            {
                data: 'no'
            },
            {
                data: 'nama_user'
            },
            {
                data: 'tanggal'
            }
        ]
        });
        $(document).ready(function() {

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
    </script>
@stop
@endsection