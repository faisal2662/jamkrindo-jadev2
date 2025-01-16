<?php 
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_pelanggan.xls");
 ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laporan keuangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
            padding: 5px;
        }
    </style>

</head>

<body>
    <div class="container">
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
        <div class="row">
            <div class="col-md-8">
                <p>Keterangan : <b>Laporan Pengaduan</b></p>
                <p>
                    Tanggal Periode : <b><?= date('j F Y', strtotime($start)) ?> s/d
                        <?= date('j F Y', strtotime($end)) ?></b>
                </p>
                <p>&nbsp;</p>
            </div>
            <!-- <div class="col-md-4 text-end">
                <button type="button" id="btnPdf" class="btn btn-danger btn-sm"><i class="bi bi-filetype-pdf"></i> PDF</button>
                <button type="button" id="btnExcel" class="btn btn-success btn-sm"><i class="bi bi-file-earmark-excel"></i> Excel</button>
            </div> -->
        </div>
        {{-- <h4 class="mt-4">Laporan Pelanggan</h4> 
        <p> Dari Tanggal : <strong>{{ $start }}</strong></p>
        <p>Sampai Tanggal : <strong>{{ $end }}</strong></p> --}}
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama User Jade</th>
                    <th>Unit Kerja</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>No. Telpon</th>
                    <th>Kode Referral </th>
                    <th>Nama Perusahaan</th>
                    <th>Provinsi Perusahaan</th>
                    <th>Kota Perusahaan</th>
                    <th>Start Chat</th>
                    <th>End Chat</th>
                    <th>Duration chat</th>
                    <th>Created Date</th>
                </tr>
            </thead>
            <tbody>
    
                @foreach ($customer as $item)
                @php
                    $getConversation = DB::table('t_percakapan')->where('kd_customer', $item->kd_customer)->first();
                    $conversation = DB::table('t_percakapan')->where('kd_customer', $item->kd_customer)->get();
                    $hours = '';
                    $minutes = '';
                    if($getConversation){
                        $firstMessage = DB::table('t_pesan')->where('conversation_id', $getConversation->id)->where('status', '0')->orderBy('created_date', 'ASC')->first();
                        $secondMessage = DB::table('t_pesan')->where('conversation_id', $getConversation->id)->where('status', '1')->orderBy('created_date', 'ASC')->first();
                        $lastMessage = DB::table('t_pesan')->where('conversation_id', $getConversation->id)->orderBy('created_date', 'DESC')->first();
                        $startTime = new DateTime($firstMessage->created_date);
                        $endTime = new DateTime($lastMessage->created_date);
                        $diffInSeconds = strtotime($lastMessage->created_date) - strtotime($firstMessage->created_date);
                        $hours = floor($diffInSeconds / 3600);
                        $minutes = floor(($diffInSeconds % 3600) / 60);
                    }
                    $no = 1;
                @endphp
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_customer }}</td>
                        @if ($item->branch)
                            <td>{{ $item->branch->nm_cabang }}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{ $item->userid_customer }}</td>                    
                <td>{{ $item->email_customer }}</td>
                        <td>{{ $item->hp_customer }}</td>
                        <td>{{ $item->kd_referral_customer }}</td>
                        <td>{{ $item->company_name }}</td>
                        @if ($item->province)
                            <td>{{ $item->province->nm_provinsi }}</td>
                        @else
                            <td></td>
                        @endif
                        @if ($item->city)
                            <td>{{ $item->city->nm_kota }}</td>
                        @else
                            <td></td> 
                        @endif  
                        @if ($getConversation)
                        <td>{{ $firstMessage->created_date }}</td>
                        <td>{{ $lastMessage->created_date }}</td>
                        <td>{{ $hours . ' Jam ' . $minutes . ' Menit' }}</td>
                        
                        @else
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                            
                        @endif
                        <td>{{ date('d-m-Y', strtotime($item->created_date)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
