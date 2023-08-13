<x-layoutPembeli>
    <x-title>
        Check Out Transaksi Pemesanan
    </x-title>
    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="flex flex-row w-full">
            {{-- Data Transaksi Pemesanan --}}
            <div class="w-1/2">
                <!-- data pelanggan -->
                <h3 class="text-xl font-bold mb-5">Alamat Pengiriman</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-3/4" />
                <div class="grid grid-cols-1">
                    <p>
                        <span class="font-bold">Nama: </span>
                        {{ $penjualan->nama_pelanggan }}
                    </p>
                    <p>
                        <span class="font-bold">Alamat: </span>
                        {{ $penjualan->alamat_pelanggan }}
                    </p>
                    <p>
                        <span class="font-bold">Telepon: </span>
                        {{ $penjualan->telepon_pelanggan }}
                    </p>
                </div>
            </div>
            <div class="w-1/2" id="informasiPemesanan">
                <!-- informasi pemesanan -->
                <h3 class="text-xl font-bold mb-5">Informasi Pemesanan</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-3/4" />
                <div class="grid grid-cols-1">
                    <p>
                        <span class="font-bold">Tanggal Transaksi: </span>
                        {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}
                    </p>
                    <p>
                        <span class="font-bold">Kode Transaksi: </span>
                        {{ $penjualan->kode_penjualan }}
                    </p>
                    <p>
                        <span class="font-bold">Metode Pembayaran: </span>
                        @if ($penjualan->metode_pembayaran == 2)
                            Transfer
                        @endif
                    </p>
                    <p>
                        <span class="font-bold">Metode Pengiriman: </span>
                        @switch($penjualan->metode_pengiriman)
                            @case(1)
                                Ambil Sendiri
                            @break

                            @case(2)
                                Dikirim Toko
                            @break

                            @default
                        @endswitch
                    <form action="{{ route('updateMetodePengirimanPelanggan', ['penjualan' => $penjualan->id]) }}"
                        method="POST">
                        @csrf
                        @method('PUT')
                        <input type="radio" name="metode_pengiriman" id="ambilSendiri" value="1">
                        <label for="ambilSendiri">Ambil sendiri</label>
                        <input type="radio" name="metode_pengiriman" id="dikirimToko" value="2">
                        <label for="dikirimToko">Dikirim oleh toko</label>
                        <div class="flex justify-end">
                            <button class="bg-green-400 rounded-lg p-1 w-fit">Simpan</button>
                        </div>
                    </form>
                    </p>
                </div>
            </div>
        </div>

        <div class="my-5">
            <div class="w-full overflow-x-auto">
                <table class="table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Harga Satuan</th>
                            <th class="border border-slate-600">Jumlah</th>
                            <th class="border border-slate-600">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($detailPenjualan as $b)
                            <tr>
                                <td class="border border-slate-600 p-1">{{ $b->varianBarang->nama_varian_barang }}</td>
                                <td class="border border-slate-600 p-1 text-center">Rp
                                    {{ format_uang($b->varianBarang->harga_jual) }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">{{ $b->jumlah_item }}</td>
                                <td class="border border-slate-600 p-1 text-center">Rp {{ format_uang($b->sub_total) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-slate-200">
                            <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="3">Total
                                harga
                            </th>
                            <th class="border border-slate-600 text-xl py-2">Rp
                                {{ format_uang($penjualan->total_harga) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end">
            <a href="{{ route('pembayaranPelanggan', ['penjualan' => $penjualan->id]) }}"
                class="bg-green-400 rounded-md p-1 w-[200px] text-lg font-semibold text-center">Bayar</a>
        </div>
    </div>
</x-layoutPembeli>
