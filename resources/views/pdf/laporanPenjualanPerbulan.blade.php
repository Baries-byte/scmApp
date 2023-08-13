<!DOCTYPE html>
<html>

<head>
    <title>Laporan Penjualan</title>
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
    <h2 style="text-align: center;">Laporan Penjualan Bulan {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}</h2>

    <div style="position: absolute; left: 0; right: 0">
        <table style="margin: auto ">
            <thead>
                <tr>
                    <th>Tanggal Penjualan</th>
                    <th>Jumlah Item Terjual</th>
                    <th>Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $p)
                    <tr>
                        <td>
                            {{ tanggal_indonesia($p->created_at->format('Y m d')) }}</td>
                        <td style="text-align: center">{{ $p->total_item }}</td>
                        <td>Rp {{ format_uang($p->total_harga) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th>Total item Terjual</th>
                    <th colspan="2">{{ $totalItemTerjual }}</th>
                </tr>
                <tr>
                    <th>Total pemasukan</th>
                    <th colspan="2">Rp {{ format_uang($totalPemasukan) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
