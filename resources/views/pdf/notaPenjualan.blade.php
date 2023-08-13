<!DOCTYPE html>
<html>

<head>
    <title>Nota Penjualan</title>
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
    <h2 style="text-align: center;">Nota Penjualan</h2>
    <div>
        <div style="float:left; display: inline">
            <h3 style="margin-bottom: -10px">TB Guna Bangunan</h3>
            <p>
                Jalan Gongseng Raya No 9 <br> Cijantung Jakarta Timur
                <br>
                Telepon: 87706013 <br>
                Hp: 08129349191
            </p>
        </div>
        <div style="float: right; right: 0% text-align: left">
            <h3 style="margin-bottom: -10px">Informasi Pembeli</h3>
            <p>
                Nama: {{ $penjualan->nama_pelanggan }}
                <br>
                Alamat: {{ $penjualan->alamat_pelanggan }}
                <br>
                Telepon: {{ $penjualan->telepon_pelanggan }}
                <br>
                Kode Penjualan: {{ $penjualan->kode_penjualan }}
            </p>
            <!-- Informasi pembeli lainnya -->
        </div>
    </div>

    <div style="position: absolute; top:25%; left: 0; right: 0">
        <table style="margin: auto ">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga Satuan</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop untuk menampilkan barang yang dibeli -->
                @foreach ($detailPenjualan as $b)
                    <tr>
                        <td>{{ $b->varianBarang->nama_varian_barang }}</td>
                        <td>Rp
                            {{ format_uang($b->varianBarang->harga_jual) }}
                        </td>
                        <td style="text-align
						: center">{{ $b->jumlah_item }}</td>
                        <td>Rp {{ format_uang($b->sub_total) }}
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <th colspan="3">Total Harga</th>
                    <th>Rp {{ format_uang($penjualan->total_harga) }}</th>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="position: fixed; bottom: 10px; right: 10px; text-align: right">
        <p>Hormat Kami,</p>
        <br>
        <br>
        <p><b>Toko Besi Guna Bangunan</b></p>
    </div>
</body>

</html>
