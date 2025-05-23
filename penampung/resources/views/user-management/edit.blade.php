@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>Edit Admin Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">Edit Admin Management</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->


    <div class=" mb-2">
        <a href="{{ route('user-manager.index') }}" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left-short"></i>
            Kembali</a>
    </div>
    <section class="section profile">
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

            <div class="col tab-pane fade show active profile-overview">
                <h5 class="card-title">Edit Admin</h5>
                <form action="{{ route('user-manager.update', $user->kd_user) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">NPP </div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="npp_user" id="npp_user"
                                value="{{ $user->npp_user }}" class="form-control" readonly></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Nama </div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="nm_user" id="nm_user"
                                value="{{ $user->nm_user }}" class="form-control" readonly></div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Email </div>
                        <div class="col-lg-9 col-md-8"><input type="text" name="email" id="email"
                                class="form-control" value="{{ $user->email }}" readonly>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Status Admin </div>
                        <div class="col-lg-9 col-md-8"><select name="employee_status" id="employee_status"
                                class="form-control" required>
                                <option value="" disabled>Pilih Status</option>
                                <option @if ($user->employee_status == 'Active') selected @endif value="Active">Active</option>
                                <option @if ($user->employee_status == 'Inactive') selected @endif value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Alamat </div>
                        <div class="col-lg-9 col-md-8">
                            <textarea name="primary_address" id="primary_address" cols="" rows="3" class="form-control" readonly>{{ $user->primary_address }}</textarea>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">No .Telpon </div>
                        <div class="col-lg-9 col-md-8"><input type="number" name="primary_phone" id="primary_phone"
                                class="form-control" value="{{ $user->primary_phone }}" readonly></div>
                    </div>
                   
                    @if (auth()->user()->id_role == 1)
                        <div class="row mb-2">
                            <div class="col-lg-3 col-md-4 label">Role <span class="text-danger"> * </span></div>
                            <div class="col-lg-9 col-md-8"><select name="id_role" id="id_role" class="form-control" required>
                                    <option value="" >Pilih Role</option>
                                    <option value="" @if ($user->id_role != 1) selected
                                        @endif>Admin</option>
                                    <option value="1" @if ($user->id_role == 1) selected
                                    @endif >Super Admin</option>
                                </select>
                            </div>
                        </div>
                    @endif
                    <!-- <div class="row mb-2">
                        <div class="col-lg-3 col-md-4 label">Tanggal Lahir <span class="text-danger"> * </span></div>
                        <div class="col-lg-9 col-md-8"><input type="text" readonly name="birthday" id="birthday"
                                class="form-control" value="{{ $user->birthday }}" ></div>
                    </div> -->
                   

            

                    <div class="row mb-2 justify-content-center">
                        <div class="col col-lg-7"><button type="submit" class="btn btn-primary w-75">Update</button>
                        </div>
                    </div>

                </form>
            </div>
            {{-- <div class="col-2">
                <div class=" mb-2 ">
                    <a href="{{ route('user-manager.index') }}" class="btn btn-warning btn-sm"><i
                            class="bi bi-arrow-left-short"></i>
                        Edit</a>
                </div>
            </div> --}}
        </div>
    </section>


@endsection
