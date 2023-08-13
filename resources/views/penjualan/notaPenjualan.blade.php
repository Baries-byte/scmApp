<!DOCTYPE html>
<html>

<head>
    <title>Nota Penjualan</title>
</head>

<body>
    <div style="margin: 20px">
        <div style="display: flex; justify-content:space-between;">
            <div>
                <!-- Informasi toko -->
                <h2>Toko Besi Guna Bangunan</h2>
                <p style="font-weight: bold;">Gongseng Raya Cijantung</p>
            </div>
            <div>
                <!-- Informasi pelanggan -->
                <h4>Informasi Pelanggan:</h4>
                <p>{{ $penjualan->nama_pelanggan }}</p>
                <p>{{ $penjualan->alamat_pelanggan }}</p>
                <p>{{ $penjualan->telepon_pelanggan }}</p>
            </div>
        </div>

        <!-- Tampilkan informasi penjualan -->
        <h3>Nota Penjualan</h3>
        <p>Kode Penjualan: {{ $penjualan->kode_penjualan }}</p>
        <p>Tanggal: {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}</p>

        <!-- Daftar barang yang dibeli -->
        <table>
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Harga Satuan</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                {{-- @foreach ($penjualan->detailPenjualan as $detail)
            <tr>
              <td>{{ $detail->barang->nama }}</td>
              <td>{{ $detail->jumlah }}</td>
              <td>{{ $detail->harga_satuan }}</td>
              <td>{{ $detail->jumlah * $detail->harga_satuan }}</td>
            </tr>
          @endforeach --}}
            </tbody>
        </table>

        <div>
            <!-- Tampilkan pesan penutup -->
            <p>Hormat kami,</p>
            <p>Toko ABC</p>
        </div>
    </div>
</body>

</html>
