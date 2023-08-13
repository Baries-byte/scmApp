<x-layoutPembeli>
    <x-title>
        Keranjang Belanja
    </x-title>
    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="flex flex-row w-full">
            {{-- Data Transaksi Pembelian --}}
            <div class="w-1/2 grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-y-0">
                @if ($adaTransaksiAktif == true)
                    <!-- data pelanggan -->
                    <div>
                        <h3 class="text-xl font-bold mb-5">Informasi Pelanggan</h3>
                        <hr class="border border-t-4 -mt-5 mb-3 w-1/2" />
                        <div class="grid grid-cols-1">
                            <p>
                                <span class="font-bold">Tanggal Transaksi: </span>
                                {{ tanggal_indonesia($transaksiPembelianAktif->created_at->format('Y m d')) }}
                            </p>
                            <p>
                                <span class="font-bold">Kode Transaksi: </span>
                                {{ $transaksiPembelianAktif->kode_penjualan }}
                            </p>
                            <p>
                                <span class="font-bold">Nama: </span>
                                {{ $transaksiPembelianAktif->nama_pelanggan }}
                            </p>
                            <p>
                                <span class="font-bold">Alamat: </span>
                                {{ $transaksiPembelianAktif->alamat_pelanggan }}
                            </p>
                            <p>
                                <span class="font-bold">Telepon: </span>
                                {{ $transaksiPembelianAktif->telepon_pelanggan }}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- daftar barang  -->
            <div class="w-1/2">
                <div class="flex justify-between mb-3">
                    <h3 class="text-xl font-bold">Barang yang mungkin anda suka</h3>
                    <form action="">
                        <input type="text" class="border rounded-lg p-1 my-2" name="search"
                            placeholder="Cari barang..." />
                        <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                    </form>
                </div>
                <div class="w-full overflow-x-auto">
                    <table class="table-auto border-collapse border border-slate-500 w-full">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border border-slate-600">Nama Barang</th>
                                <th class="border border-slate-600">Merek</th>
                                <th class="border border-slate-600">Persediaan</th>
                                <th class="border border-slate-600">Harga</th>
                                <th class="border border-slate-600" colspan="2">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $b)
                                <tr>
                                    <td class="border border-slate-600 p-1">{{ $b->nama_varian_barang }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->barangMaster->merek }}</td>
                                    <td class="border border-slate-600 p-1 text-center">{{ $b->persediaan->jumlah }}
                                        {{ $b->satuan->satuan }}
                                    </td>
                                    <td class="border border-slate-600 p-1">Rp {{ format_uang($b->harga_jual) }}</td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        {{-- tambah barang --}}
                                        <form action="{{ route('addBarangKeranjangBelanja') }}" method="POST">
                                            @csrf
                                            @if ($adaTransaksiAktif == true)
                                                <input type="hidden" name="penjualan_id"
                                                    value="{{ $transaksiPembelianAktif->id }}">
                                            @endif
                                            <input type="hidden" name="barang_id" value="{{ $b->id }}">
                                            <input type="hidden" name="harga_jual" value="{{ $b->harga_jual }}">
                                            <div class="flex">
                                                <input type="number" name="jumlah" class="w-[50px] text-center"
                                                    value="1">
                                                <button type="submit">
                                                    <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>
                                                </button>
                                            </div>
                                        </form>
                                    </td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        <a href="{{ route('detailBarangHome', ['barang' => $b->id]) }}">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- pagination --}}
                    <div class="my-5">
                        {{ $barang->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>


        @if ($adaTransaksiAktif == true)
            <!-- daftar barang yang dibeli -->
            <div class="my-5">
                <div class="w-full overflow-x-auto">

                    @if (count($detailPembelian) != 0)
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
                                        <td class="border border-slate-600 p-1">
                                            {{ $b->varianBarang->nama_varian_barang }}</td>
                                        <td class="border border-slate-600 p-1">Rp
                                            {{ format_uang($b->varianBarang->harga_jual) }}</td>
                                        <td class="border border-slate-600 p-1">
                                            <div class="flex">
                                                {{-- update jumlah barang --}}
                                                <form action="{{ route('updateJumlahBarangKeranjangBelanja') }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="penjualan_id"
                                                        value="{{ $transaksiPembelianAktif->id }}">
                                                    <input type="hidden" name="id" value="{{ $b->id }}">
                                                    <input type="hidden" name="barang_id"
                                                        value="{{ $b->varianBarang->id }}">
                                                    <input type="hidden" name="harga_jual"
                                                        value="{{ $b->varianBarang->harga_jual }}">
                                                    <input type="number" name="jumlah" class="w-[50px] text-center"
                                                        value="{{ $b->jumlah_item }}">
                                                    {{ $b->varianBarang->satuan->satuan }}
                                                    <button type="submit">
                                                        <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>
                                                    </button>
                                                </form>
                                                <form
                                                    action="{{ route('deleteBarangKeranjangBelanja', ['detailPenjualan' => $b->id]) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button>
                                                        <i class="fa fa-solid fa-trash bg-red-500 p-1 rounded-md"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                        <td class="border border-slate-600 p-1">Rp {{ format_uang($b->sub_total) }}
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="bg-slate-200">
                                    <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="3">Total
                                        harga
                                    </th>
                                    <th class="border border-slate-600 text-xl py-2">Rp
                                        {{ format_uang($transaksiPembelianAktif->total_harga) }}</th>
                                </tr>
                            </tbody>
                        </table>
                    @else
                        <p class="text-center bg-red-300 ">Data barang pada penjualan ini tidak tersedia.</p>
                    @endif
                </div>
            </div>

            <div class="flex justify-end">
                <button class="bg-green-400 rounded-md p-1 w-[200px] text-lg font-semibold text-center"
                    id="btnSnK">Beli</button>
            </div>
        @else
            <p class="text-center bg-red-300 my-5">Belum ada barang di keranjang belanja</p>
        @endif
    </div>

    {{-- modal peraturan kirim barang --}}
    <div class="bg-black bg-opacity-50 fixed inset-0 z-10 flex hidden justify-center items-center" id="modalSnK">
        <div class="bg-gray-200 h-fit w-1/3 text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalSnK">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl mt-3 bg-red-300 rounded-md">Syarat dan Ketentuan Transaksi</h3>

            <div class="text-left mx-5">
                <ol class="list-decimal">
                    <li>Toko <b>berhak Menolak</b> transaksi pemesanan pelanggan</li>
                    <li>Pemesanan diteruskan ke toko setelah pelanggan mengunggah bukti pembayaran</li>
                </ol>
            </div>

            <h3 class="font-bold text-2xl mt-3 bg-red-300 rounded-md">Syarat dan Ketentuan Pengiriman</h3>

            <div class="text-left mx-5">
                <ol class="list-decimal">
                    <li>Pengiriman oleh toko dilakukan hanya untuk barang yang perlu dikirim seperti, pasir, kayu, besi,
                        dan barang besar lainnya</li>
                    <li>Jarak maksimal pengiriman <b>5km</b></li>
                    <li>Pengiriman barang dilakukan bersamaan dengan pemesanan lain yang searah</li>
                    <li>Jika jarak <b>lebih dari 5km</b> minimal pembelian seharga <b>Rp 2.500.000</b> dengan jarak
                        maksimal <b>20km</b></li>
                    <li>Jika jarak pengiriman lebih dari <b>20km</b> diwajibkan konsultasi ke toko terlebih dahulu</li>
                </ol>
            </div>

            <h3 class="font-bold mt-3 bg-red-300 rounded-md">Melanjutkan pesanan berarti menyetujui syarat dan
                ketentuan yang berlaku</h3>

            @isset($transaksiPembelianAktif)
                <div class="mt-7 mb-3 w-full">
                    <a href="{{ route('checkOutPelanggan', ['penjualan' => $transaksiPembelianAktif]) }}"
                        class="bg-green-400 rounded-md p-1 w-full text-lg font-semibold text-center">Lanjutkan
                        Pembelian</a>
                </div>
            @endisset
        </div>
    </div>

    <script>
        $(function() {
            $('#btnSnK').click(function() {
                $('#modalSnK').removeClass("hidden");
            })
            $('#btnCloseModalSnK').click(function() {
                $('#modalSnK').addClass("hidden");
            })
        })
    </script>
</x-layoutPembeli>
