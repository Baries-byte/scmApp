<!DOCTYPE html>
<html>

<head>
    <title>Laporan Barang</title>
    <style>
        table {
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 5px;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">
        Laporan Barang {{ $barang->nama_varian_barang }} Terjual Bulan
        {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}
    </h2>

    <div style="position: absolute; left: 0; right: 0">
        <table style="margin: auto ">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataLaporanBarangPerbulan as $dl)
                    <tr>
                        <td>{{ tanggal_indonesia($dl->created_at) }}</td>
                        <td style="text-align: center">{{ $dl->jumlah }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total barang terjual</th>
                    <th>{{ $totalTerjual }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
