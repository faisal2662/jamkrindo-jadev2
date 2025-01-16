@extends('layouts.main')

@section('main')
<div class="pagetitle">
    <h1>Detail User Role</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item">User Role Management</li>
            <li class="breadcrumb-item active">Detail User Role</li>
        </ol>
    </nav>
</div><!-- End Page Title -->

<section class="section">
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col align-self-end">

                            <div class="mb-3 float-end mt-4">
                                {{-- <a href="{{ route('user-manager.create') }}" class="btn btn-primary btn-sm">Tambah
                                    Data</a> --}}
                                {{-- <button type="button" class="btn btn-primary btn-sm float-end" onclick="userAdd()">
                                    Tambah Data
                                </button> --}}
                                {{-- <button type="button" class="btn btn-primary btn-sm float-end" data-bs-toggle="modal"
                                    data-bs-target="#tambah">
                                    Tambah Data
                                </button> --}}
                            </div>
                        </div>
                    </div>
                    {{-- <h5 class="card-title mb-5">Datatables</h5> --}}
                    <!-- Table with stripped rows -->
                    <div id="alert" class="alert alert-success alert-dismissible fade position-absolute "
                        style="margin-left: 400px ; margin-top: -20px;" role="alert">
                        <span class="pesan text-capitalize"></span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>

                    <form action="{{ route('jade.role.save') }}" method="POST" id="formRule">
                        {{ csrf_field() }}
                        <input type="hidden" name="id_account" value="{{ Request()->id }}">
                        <table class="table table-hover table-striped " id="users-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Menu</th>
                                    <th>All</th>
                                    <th>Can Access</th>
                                    <th>Can Create</th>
                                    <th>Can Update</th>
                                    <th>Can Delete</th>
                                    {{-- <th>Can Approve</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($menu as $mn)
                                <input type="hidden" name="menu_id[]" value="{{ $mn['id_menu'] }}">
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $mn['menu'] }}</td>
                                        <td align="center"><input type="checkbox" onclick="checkAll(this, {{ $mn['id_menu'] }})" id="can_all-{{ $mn['id_menu'] }}" value="Y" <?php echo $mn['can_all'] == "Y" ? "checked" : "" ?>></td>
                                        <td align="center"><input type="checkbox" onclick="checkedItem(this)" id="can_access-{{ $mn['id_menu'] }}" name="can_access[{{ $mn['id_menu'] }}]" value="Y" <?php echo $mn['can_access'] == "Y" ? "checked" : "" ?>></td>
                                        <td align="center"><input type="checkbox" onclick="checkedItem(this)" id="can_create-{{ $mn['id_menu'] }}" name="can_create[{{ $mn['id_menu'] }}]" value="Y" <?php echo $mn['can_create'] == "Y" ? "checked" : "" ?>></td>
                                        <td align="center"><input type="checkbox" onclick="checkedItem(this)" id="can_update-{{ $mn['id_menu'] }}" name="can_update[{{ $mn['id_menu'] }}]" value="Y" <?php echo $mn['can_update'] == "Y" ? "checked" : "" ?>></td>
                                        <td align="center"><input type="checkbox" onclick="checkedItem(this)" id="can_delete-{{ $mn['id_menu'] }}" name="can_delete[{{ $mn['id_menu'] }}]" value="Y" <?php echo $mn['can_delete'] == "Y" ? "checked" : "" ?>></td>
                                        {{-- <td align="center"><input type="checkbox" onclick="checkedItem(this)" id="can_approve-{{ $mn['id_menu'] }}" name="can_approve[{{ $mn['id_menu'] }}]" value="Y" <?php echo $mn['can_approve'] == "Y" ? "checked" : "" ?>></td> --}}
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col">
                                <button type="submit" class="btn btn-warning btn-sm">Update Access Role</button>
                            </div>
                        </div>
                    </form>

                    <!-- End Table with stripped rows -->

                </div>
            </div>

        </div>
    </div>
</section>

@section('script')

@if(session('alert'))
<script>
    alert('{{ session('alert') }}');
</script>
@endif

<script>
    function checkAll(obj, id){
        if($(obj).is(':checked')){
            $('#can_access-'+id).prop("checked", true);
            $('#can_create-'+id).prop("checked", true);
            $('#can_update-'+id).prop("checked", true);
            $('#can_delete-'+id).prop("checked", true);
            // $('#can_approve-'+id).prop("checked", true);
        }else{
            $('#can_access-'+id).prop("checked", false);
            $('#can_create-'+id).prop("checked", false);
            $('#can_update-'+id).prop("checked", false);
            $('#can_delete-'+id).prop("checked", false);
            // $('#can_approve-'+id).prop("checked", false);
        }
    }

    function checkedItem(obj){
        if($(obj).is(':checked')){
            $(obj).prop("checked", true);
        }else{
            $(obj).prop("checked", false);
        }
    }
</script>
    
@endsection
    
@endsection