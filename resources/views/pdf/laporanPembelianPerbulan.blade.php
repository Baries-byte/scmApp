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
    <h2 style="text-align: center;">Laporan Pembelian Bulan {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}</h2>

    <div style="position: absolute; left: 0; right: 0">
        <table style="margin: auto ">
            <thead>
                <tr>
                    <th>Purchase Order</th>
                    <th>Tanggal Purchase Order</th>
                    <th>Total Item</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pembelian as $p)
                    <tr>
                        <td>{{ $p->purchaseOrder->kode_purchase_order }}
                        </td>
                        <td>
                            {{ tanggal_indonesia($p->purchaseOrder->created_at->format('Y m d')) }}
                        </td>
                        <td style="text-align: center">
                            {{ $p->total_item }}
                        </td>
                @endforeach
                <tr>
                    <th colspan="2">Jumlah total item</th>
                    <th>{{ $totalItem }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
