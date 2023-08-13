<x-layoutPembeli>
    <x-title>
        Transaksi Pembelian {{ tanggal_indonesia($pembelian->created_at->format('Y m d')) }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="flex flex-row w-full">
            {{-- informasi pelanggan --}}
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-5">Informasi Pelanggan</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/3" />
                <div class="grid grid-cols-1">
                    <p>
                        <span class="font-bold">Nama Pelanggan: </span>
                        {{ $pembelian->nama_pelanggan }}
                    </p>
                    <p>
                        <span class="font-bold">Alamat: </span>
                        {{ $pembelian->alamat_pelanggan }}
                    </p>
                    <p>
                        <span class="font-bold">Telepon: </span>
                        {{ $pembelian->telepon_pelanggan }}
                    </p>
                </div>
            </div>

            {{-- informasi transaksi pembelian --}}
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-5">Informasi Pembelian</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/3" />
                <p>
                    <span class="font-bold">Tanggal Pembelian: </span>
                    {{ tanggal_indonesia($pembelian->created_at->format('Y m d')) }}
                </p>
                <p>
                    <span class="font-bold">Pembayaran: </span>
                    @if ($pembelian->metode_pembayaran == 0)
                        Cash
                    @else
                        Transfer
                    @endif
                </p>
                <p>
                    <span class="font-bold">Status Transaksi: </span>
                    {{ $pembelian->status_transaksi }}
                </p>
                <p>
                    <span class="font-bold">Jenis Pengiriman: </span>
                    @switch($pembelian->metode_pengiriman)
                        @case(1)
                            Ambil Sendiri
                        @break

                        @case(2)
                            Dikirim oleh toko
                        @break

                        @default
                    @endswitch
                </p>
                <p>
                    <span class="font-bold">Supir: </span>
                    {{ $pembelian->supir }}
                </p>
            </div>
        </div>

        <!-- daftar barang yang dipesan -->
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
                        @foreach ($detailPembelian as $b)
                            <tr>
                                <td class="border border-slate-600 p-1">{{ $b->varianBarang->nama_varian_barang }}</td>
                                <td class="border border-slate-600 p-1">Rp {{ format_uang($b->varianBarang->harga_jual) }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">{{ $b->jumlah_item }}</td>
                                <td class="border border-slate-600 p-1 text-center">Rp {{ format_uang($b->sub_total) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-slate-200">
                            <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="3">Total harga
                            </th>
                            <th class="border border-slate-600 text-xl py-2">Rp
                                {{ format_uang($pembelian->total_harga) }}</th>
                        </tr>
                    </tbody>
                </table>

                @switch($pembelian->status_transaksi)
                    @case('Dikirim')
                        <div class="w-full flex justify-end my-2">
                            <a href="{{ route('selesaiTransaksiPelanggan', ['penjualan' => $pembelian->id]) }}"
                                class="bg-primary rounded-lg p-1 text-white font-semibold">Selesai</a>
                        </div>
                    @break

                    @case('Menunggu Pembayaran')
                        <div class="w-full flex justify-end my-2">
                            <a href="{{ route('pembayaranPelanggan', ['penjualan' => $pembelian->id]) }}"
                                class="bg-primary rounded-lg p-1 text-white font-semibold">Bayar</a>
                        </div>
                    @break

                    @case('Check Out')
                        <div class="w-full flex justify-end my-2">
                            <a href="{{ route('checkOutPelanggan', ['penjualan' => $pembelian->id]) }}"
                                class="bg-primary rounded-lg p-1 text-white font-semibold">Check Out</a>
                        </div>
                    @break

                    @default
                @endswitch

            </div>
        </div>
        @if (
            $pembelian->status_transaksi == 'Diproses' or
                $pembelian->status_transaksi == 'Dikirim' or
                $pembelian->status_transaksi == 'Selesai')
            <div class="flex flex-row justify-end">
                <a href="{{ route('cetakNotaPenjualanPelanggan', ['penjualan' => $pembelian->id]) }}"
                    class="bg-primary rounded-md py-1 px-5 text-lg font-semibold text-white mx-2">
                    Cetak Nota
                </a>
            </div>
        @endif
    </div>
</x-layoutPembeli>
