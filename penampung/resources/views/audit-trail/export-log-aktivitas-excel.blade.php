<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan Audit Trail Aktivitas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <p>&nbsp;</p>
        <div class="row">
            <div class="col-md-12" style="border-bottom: 1px solid #000;">
                <center>
                    <img src="{{ asset('assets/img/kop-surat.png') }}" style="width: 60%;border-radius: 5px;">
                </center>
                <p>&nbsp;</p>
            </div>
            <div class="col-md-12" style="border-top: 3px solid #000;margin-top: 5px;">
                <p>&nbsp;</p>
            </div>
        </div>

        <div class="row mt-6">
            <div class="col-12">
                <h4 class="text-center">Laporan Login Audit Trail Aktivitas </h4>
                <h5 class="text-center">Tanggal {{ $start . ' s/d ' . $end }} </h5>
            </div>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <td>Nama Aplikas</td>
                    <td>Tanggal / Waktu</td>
                    <td>Before</td>
                    <td>After</td>
                    <td>User</td>
                    <td>Role</td>
                    <td>Cabang</td>
                    <td>Browser</td>
                    <td>Device</td>
                </tr>
            </thead>
            <tbody>
                @foreach ($audit as $item)
                <tr>
                    <td>Aplikasi JADE</td>
                    <td> {{$item->created_date}} </td>
                    <td> {{$item->before}} </td>
                    <td> {{$item->after}} </td>
                    <td> {{$item->user->nm_user}} </td>
                    <td> {{$item->user->id_role == 1 ? 'Super Admin' : ''}} </td>
                    <td> {{$item->user->branch_name}} </td>
                    <td> {{$item->browser}} </td>
                    <td> {{$item->device}} </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script>
</body>

</html>