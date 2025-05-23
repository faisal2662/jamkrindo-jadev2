<?php 
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=laporan_dwh_sp.xls");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan DWH</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h3 {
            text-align: center;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 4px;
            text-align: left;
            vertical-align: top;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

    <div style="text-align: center;">
        <h3>Laporan DWH</h3>
        <p>Keterangan: <strong>DATA DWH SP</strong></p>
        <p>Periode: <strong><?= date('j F Y', strtotime($start)) ?> s/d <?= date('j F Y', strtotime($end)) ?></strong></p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No.</th>
                <th>No Surat</th>
                <th>No SP</th>
                <th>Tanggal SP</th>
                <th>Nasabah</th>
                <th>Kantor Wilayah</th>
                <th>Wilayah Kerja</th>
                <th>Penerima Jaminan</th>
                <th>LOB</th>
                <th>Produk</th>
                <th>NPWP</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dwh as $item)
            <tr>
                <td style="text-align: center;">{{ $loop->iteration }}</td>
                <td>{{ $item->no_surat }}</td>
                <td>{{ $item->nomor_sp }}</td>
                <td>{{ $item->date }}</td>
                <td>{{ $item->nasabah }}</td>
                <td>{{ $item->kantor_wilayah }}</td>
                <td>{{ $item->wilayah_kerja }}</td>
                <td>{{ $item->penerima_jaminan }}</td>
                <td>{{ $item->lob }}</td>
                <td>{{ $item->produk }}</td>
                <td style="mso-number-format:'\@';">'{{ $item->npwp }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
