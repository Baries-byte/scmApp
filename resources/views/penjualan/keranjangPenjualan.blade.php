<x-layoutAdmin>
    <x-title>
        Keranjang Transaksi Penjualan {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}
    </x-title>
    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="flex flex-row w-full ">
            {{-- Data Penjualan --}}
            <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-y-0">
                <!-- data pembeli -->
                <div>
                    <h3 class="text-xl font-bold mb-5">Informasi Pelanggan</h3>
                    <hr class="border border-t-4 -mt-5 mb-3 w-1/2" />
                    <div class="grid grid-cols-1">
                        <p>
                            <span class="font-bold">Tanggal Transaksi: </span>
                            {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}
                        </p>
                        <p>
                            <span class="font-bold">Kode Transaksi Penjualan: </span>
                            {{ $penjualan->kode_penjualan }}
                        </p>
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
                        <p>
                            <span class="font-bold">Kasir: </span>
                            {{ $penjualan->user->nama }}
                        </p>
                        <p>
                            <span class="font-bold">Status Transaksi: </span>
                            {{ $penjualan->status_transaksi }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- daftar barang  -->
            <div class="w-1/2">
                <div class="flex justify-between mb-3">
                    <h3 class="text-xl font-bold">Pilih Barang</h3>
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
                                <th class="border border-slate-600">Satuan</th>
                                <th class="border border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $b)
                                <tr>
                                    <td class="border border-slate-600 p-1">{{ $b->nama_varian_barang }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->barangMaster->merek }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->persediaan->jumlah }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->satuan->satuan }}</td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        {{-- tambah barang --}}
                                        <form action="{{ route('addBarangPenjualan') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
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
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-5">
                        {{ $barang->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>

        <!-- daftar barang yang dijual -->
        <div class="my-5">
            <div class="w-full overflow-x-auto">
                @if (count($detailPenjualan) != 0)
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
                                    <td class="border border-slate-600 p-1">{{ $b->varianBarang->nama_varian_barang }}
                                    </td>
                                    <td class="border border-slate-600 p-1">Rp
                                        {{ format_uang($b->varianBarang->harga_jual) }}</td>
                                    <td class="border border-slate-600 p-1">
                                        <div class="flex">
                                            {{-- update jumlah barang --}}
                                            <form action="{{ route('updateJumlahBarangPenjualan') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="penjualan_id" value="{{ $penjualan->id }}">
                                                <input type="hidden" name="id" value="{{ $b->id }}">
                                                <input type="hidden" name="barang_id"
                                                    value="{{ $b->varianBarang->id }}">
                                                <input type="hidden" name="harga_jual"
                                                    value="{{ $b->varianBarang->harga_jual }}">
                                                <input type="number" name="jumlah" class="w-[50px] text-center"
                                                    value="{{ $b->jumlah_item }}">
                                                <button type="submit">
                                                    <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('deleteBarangPenjualan', ['detailPenjualan' => $b->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button>
                                                    <i class="fa fa-solid fa-trash bg-red-500 p-1 rounded-md"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="border border-slate-600 p-1">Rp {{ format_uang($b->sub_total) }}</td>
                                </tr>
                            @endforeach
                            <tr class="bg-slate-200">
                                <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="3">Total
                                    harga
                                </th>
                                <th class="border border-slate-600 text-xl py-2">Rp {{ format_uang($hargaTotal) }}
                                </th>
                            </tr>
                        </tbody>
                    </table>

                    {{-- <div class="w-full flex justify-end mt-2">
                        <button class="bg-green-400 p-1 rounded-lg font-semibold">Cetak Nota</button>
                    </div> --}}
                    <div class="w-full flex justify-end mt-2">
                        <button class="bg-green-400 p-1 rounded-lg font-semibold"
                            id="btnModalPembayaran">Pembayaran</button>
                    </div>
                @else
                    <p class="text-center bg-red-300 ">Data barang pada penjualan ini tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    {{-- Modal metode pembayaran dan metode pengiriman --}}
    <div class="bg-black bg-opacity-50 fixed inset-0 z-10 hidden flex justify-center items-center"
        id="modalPembayaran">
        <div class="bg-gray-200 h-fit w-fit text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalPembayaran">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Metode pembayaran dan pengiriman</h3>
            <form action="{{ route('updateMetodePembayaranPengiriman', ['penjualan' => $penjualan->id]) }}"
                method="POST" class="flex flex-col gap-y-1 text-left">
                @csrf
                @method('PUT')
                <label class="font-bold">Metode Pembayaran: </label>
                <div>
                    <input type="radio" name="metode_pembayaran" id="cash" value="0">
                    <label for="cash">Cash</label>
                    <input type="radio" name="metode_pembayaran" id="edc" value="1">
                    <label for="edc">EDC</label>
                    <input type="radio" name="metode_pembayaran" id="transfer" value="2">
                    <label for="transfer">Transfer</label>
                </div>

                <label class="font-bold">Metode Pengiriman: </label>
                <div>
                    <input type="radio" name="metode_pengiriman" id="ambilSendiri" value="1">
                    <label for="ambilSendiri">Ambil sendiri</label>
                    <input type="radio" name="metode_pengiriman" id="dikirimToko" value="2">
                    <label for="dikirimToko">Dikirim oleh toko</label>
                </div>

                <label class="font-bold" for="supir">Nama Supir: </label>
                <input type="text" class="p-1 border border-black" name="supir" value=""
                    placeholder="Kosongkan bila pengiriman ambil sendiri">

                <input type="hidden" name="status_transaksi" value="Diproses">
                <button type="submit" class="bg-green-400 p-1 font-semibold rounded-lg">Simpan</button>
            </form>
        </div>
    </div>
    <script>
        $(function() {
            $('#btnModalPembayaran').click(function() {
                $('#modalPembayaran').removeClass('hidden')
            })
            $('#btnCloseModalPembayaran').click(function() {
                $('#modalPembayaran').addClass('hidden')
            })
        })
    </script>
</x-layoutAdmin>
