<!DOCTYPE html>
<html>

<head>
    <title>Laporan Purchase Order</title>
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
    <h2 style="text-align: center;">Laporan Purchase Order Bulan {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}
    </h2>

    <div style="position: absolute; left: 0; right: 0">
        <table style="margin: auto ">
            <thead>
                <tr>
                    <th>Tanggal Purchase Order</th>
                    <th>Kode Purchase Order</th>
                    <th>Total Item</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($purchaseOrder as $p)
                    <tr>
                        <td>
                            {{ tanggal_indonesia($p->created_at->format('Y m d')) }}</td>
                        <td>{{ $p->kode_purchase_order }}</td>
                        <td style="text-align: center">{{ $p->total_item }}</td>
                        <td>Rp {{ format_uang($p->total_harga) }}</td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="2">Total item Terjual</th>
                    <th colspan="2">{{ $totalItem }}</th>
                </tr>
                <tr>
                    <th colspan="2">Total pemasukan</th>
                    <th colspan="2">Rp {{ format_uang($totalHarga) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
