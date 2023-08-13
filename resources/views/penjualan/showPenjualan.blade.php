<x-layoutAdmin>
    <x-title>
        Transaksi Penjualan {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">

        <div class="flex flex-row w-full">
            {{-- informasi pembeli --}}
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-5">Informasi Pelanggan</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/3" />
                <div class="grid grid-cols-1">
                    <p>
                        <span class="font-bold">Nama Pelanggan: </span>
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

            {{-- informasi transaksi penjualan --}}
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-5">Informasi Penjualan</h3>
                <hr class="border border-t-4 -mt-5 mb-5 w-1/3" />
                <p>
                    <span class="font-bold">Tanggal Penjualan: </span>
                    {{ tanggal_indonesia($penjualan->created_at->format('Y m d')) }}
                </p>
                <p>
                    <span class="font-bold">Kode Penjualan: </span>
                    {{ $penjualan->kode_penjualan }}
                </p>
                <p>
                    <span class="font-bold">Kasir: </span>
                    {{ $penjualan->user->nama }}
                </p>
                <p>
                    <span class="font-bold">Status Transaksi: </span>
                    {{ $penjualan->status_transaksi }}
                </p>
                <p>
                    <span class="font-bold">Pembayaran: </span>
                    @switch($penjualan->metode_pembayaran)
                        @case(0)
                            Cash
                        @break

                        @case(1)
                            EDC
                        @break

                        @case(2)
                            Transfer
                        @break

                        @default
                    @endswitch
                </p>
                <p>
                    <span class="font-bold">Pengiriman: </span>
                    @switch($penjualan->metode_pengiriman)
                        @case(1)
                            Ambil Sendiri
                        @break

                        @case(2)
                            Dikirim Toko
                        @break

                        @default
                    @endswitch
                </p>
                @if ($penjualan->metode_pengiriman == 2)
                    <p>
                        <span class="font-bold">Supir: </span>
                        {{ $penjualan->supir }}
                    </p>
                @endif

                {{-- Menu untuk pembelian online --}}
                @if ($penjualan->supir == false && $penjualan->metode_pengiriman == 2)
                    <div class="w-full flex justify-end">
                        <button class="bg-green-400 p-1 rounded-lg font-semibold" id="btnOpenModalInputSupirPengirim">
                            Tambah Supir
                        </button>
                    </div>
                @endif
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
                        @foreach ($detailPenjualan as $b)
                            <tr>
                                <td class="border border-slate-600 p-1">{{ $b->varianBarang->nama_varian_barang }}</td>
                                <td class="border border-slate-600 p-1">Rp
                                    {{ format_uang($b->varianBarang->harga_jual) }}
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
                                {{ format_uang($penjualan->total_harga) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex flex-row justify-end">
            @if ($penjualan->supir == true && $penjualan->metode_pengiriman == 2 && $penjualan->status_transaksi == 'Diproses')
                <a href="{{ route('kirimPenjualan', ['penjualan' => $penjualan->id]) }}"
                    class="bg-green-400 font-semibold py-1 px-5 rounded-lg">Kirim</a>
            @endif

            @if (count($detailPenjualan) == 0 && $penjualan->status_transaksi == 'Diproses' && $penjualan->user->level != 0)
                <a href="{{ route('keranjangPenjualan', ['penjualan' => $penjualan->id]) }}"
                    class="bg-green-400 font-semibold py-1 px-5 rounded-lg">Keranjang</a>
            @endif

            @if ($penjualan->status_transaksi == 'Diproses' || $penjualan->status_transaksi == 'Dikirim')
                <a href="{{ route('penjualanSelesai', ['penjualan' => $penjualan->id]) }}"
                    class="bg-primary rounded-md py-1 px-5 text-lg font-semibold text-white mx-2">Selesai</a>
            @endif

            @if ($penjualan->status_transaksi == 'Menunggu Konfirmasi Toko')
                <a href="{{ route('prosesPenjualanPembeli', ['penjualan' => $penjualan->id]) }}"
                    class="bg-green-400 rounded-md py-1 px-5 text-lg font-semibold">Proses</a>
                <a href="{{ route('tolakPenjualanPembeli', ['penjualan' => $penjualan->id]) }}"
                    class="bg-red-600 rounded-md py-1 px-5 text-lg font-semibold text-white mx-2">Tolak</a>
                <button class="bg-primary rounded-md py-1 px-5 text-lg font-semibold text-white"
                    id="btnOpenModalBuktiPembayaran">Bukti
                    Pembayaran</button>
            @endif

            <a target="_blank" href="{{ route('cetakNotaPenjualan', ['penjualan' => $penjualan->id]) }}"
                class="bg-primary rounded-md py-1 px-5 text-lg font-semibold text-white mx-2">
                Cetak Nota
            </a>
        </div>
    </div>

    {{-- Modal bukti pembayaran --}}
    <div class="bg-black bg-opacity-50 fixed hidden inset-0 z-10 flex justify-center items-center"
        id="modalBuktiPembayaran">
        <div class="bg-gray-200 h-fit w-1/3 text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalBuktiPembayaran">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Bukti Pembayaran</h3>
            <div class="flex justify-center">
                <img class="h-[500px]" src="{{ asset('storage/' . $penjualan->bukti_pembayaran) }}"
                    alt="pukti pembayaran">
            </div>
        </div>
    </div>

    {{-- Modal Input Supir --}}
    <div class="bg-black bg-opacity-50 fixed hidden inset-0 z-10 flex justify-center items-center"
        id="modalInputSupirPengirim">
        <div class="bg-gray-200 h-fit w-3/4 text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalInputSupirPengirim">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Isi Data Supir Untuk Pengiriman</h3>
            <form action="{{ route('inputSupirPengirim', ['penjualan' => $penjualan->id]) }}" method="POST"
                class="flex flex-col gap-y-1 text-left">
                @csrf
                @method('PUT')
                <label for="supir" class="font-bold">Nama Supir</label>
                <input type="text" name="supir" class="p-1 border border-slate-600">
                <button class="bg-red-500 font-bold text-white rounded-full px-66 py-1 my-2 hover:bg-red-800">
                    Input Nama Supir
                </button>
            </form>
        </div>
    </div>

    <script>
        $(function() {

            $("#btnOpenModalBuktiPembayaran").click(function() {
                $("#modalBuktiPembayaran").removeClass("hidden")
            })
            $("#btnCloseModalBuktiPembayaran").click(function() {
                $("#modalBuktiPembayaran").addClass("hidden")
            })

            $("#btnOpenModalInputSupirPengirim").click(function() {
                $("#modalInputSupirPengirim").removeClass("hidden")
            })
            $("#btnCloseModalInputSupirPengirim").click(function() {
                $("#modalInputSupirPengirim").addClass("hidden")
            })
        })
    </script>

</x-layoutAdmin>
