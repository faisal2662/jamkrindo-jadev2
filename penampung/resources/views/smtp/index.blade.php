@extends('layouts.main')
@section('main')
    <div class="pagetitle">
        <h1>SMTP Management</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
                <li class="breadcrumb-item active">SMTP</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <div class="card-title">SMTP</div>
                        <div class="row bg-white p-4">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <div class="col-8 tab-pane fade show active profile-overview">
                                <form action="{{ route('smtp.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_smtp" value="{{$smtp->id_smtp}}">
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">Email SMTP <span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="email_smtp"
                                                id="" value="{{ $smtp->email_smtp }}" required
                                                class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">HOST SMTP <span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="host_smtp" id=""
                                                value="{{ $smtp->host_smtp }}" required class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">PORT SMTP <span class="text-danger">*</span>
                                        </div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="port_smtp" id=""
                                                value="{{ $smtp->port_smtp }}" required class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">USERNAME SMTP <span
                                                class="text-danger">*</span></div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="username_smtp"
                                                id="" value="{{ $smtp->username_smtp }}" required
                                                class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">PASSWORD SMTP <span
                                                class="text-danger">*</span></div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="password_smtp"
                                                id="" value="{{ $smtp->password_smtp }}" required
                                                class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">ENKRIPSI SMTP <span
                                                class="text-danger">*</span></div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="enkripsi_smtp"
                                                id="" value="{{ $smtp->enkripsi_smtp }}" required
                                                class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">ALAMAT EMAIL SMTP <span
                                                class="text-danger">*</span></div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="alamat_email_smtp"
                                                id="" value="{{ $smtp->alamat_email_smtp }}" required
                                                class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg-4 col-md-5 label">NAMA EMAIL SMTP <span
                                                class="text-danger">*</span></div>
                                        <div class="col-lg-8 col-md-7"><input type="text" name="nama_email_smtp"
                                                id="" value="{{ $smtp->nama_email_smtp }}"
                                                class="form-control"></div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-lg col-md label"><button
                                                class="btn btn-primary w-100">Update</button></div>

                                    </div>
                                </form>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
