<x-layoutAdmin>
    <x-title>
        Pembelian (PO {{ tanggal_indonesia($purchaseOrder->created_at->format('Y m d')) }})
    </x-title>
    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">
        <div class="flex w-full justify-between">
            {{-- Data Purchase Order --}}
            <div class="">
                <!-- data purchase order -->
                <div>
                    <h3 class="text-xl font-bold mb-5">Informasi Purchase Order</h3>
                    <hr class="border border-t-4 -mt-5 mb-3 w-full" />
                    <div class="grid grid-cols-1">
                        <p>
                            <span class="font-bold">Tanggal Transaksi: </span>
                            {{ tanggal_indonesia($purchaseOrder->created_at->format('Y m d')) }}
                        </p>
                        <p>
                            <span class="font-bold">Supplier: </span>
                            {{ $purchaseOrder->supplier->nama_perusahaan }}
                        </p>
                        <p>
                            <span class="font-bold">Total Item: </span>
                            {{ $purchaseOrder->total_item }}
                        </p>
                        <p>
                            <span class="font-bold">Total harga: </span>
                            Rp {{ format_uang($purchaseOrder->total_harga) }}
                        </p>
                        <p>
                            <span class="font-bold">Status Purchase Order: </span>
                            {{ $purchaseOrder->status }}
                        </p>
                    </div>
                    <button class="bg-primary text-white rounded-lg p-1" id="btnOpenModalBarangPO">Barang Purchase
                        Order</button>
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
                                <th class="border border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barang as $b)
                                <tr>
                                    <td class="border border-slate-600 p-1">{{ $b->nama_varian_barang }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->barangMaster->merek }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->persediaan->jumlah }}</td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        {{-- tambah barang --}}
                                        <form action="{{ route('storeDetailPembelian') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pembelian_id" value="{{ $pembelian->id }}">
                                            <input type="hidden" name="varian_barang_id" value="{{ $b->id }}">
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
                        {{-- {{ $barang->links('vendor.pagination.tailwind') }} --}}
                    </div>
                </div>
            </div>
        </div>

        <div class="my-5">
            <div class="w-full overflow-x-auto">
                @if (count($detailPembelian) != 0)
                    <table class="table-auto border-collapse border border-slate-500 w-full">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border border-slate-600">Nama Barang</th>
                                <th class="border border-slate-600">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($detailPembelian as $b)
                                <tr>
                                    <td class="border border-slate-600 p-1">{{ $b->varianBarang->nama_varian_barang }}
                                    </td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        <div class="flex justify-center">
                                            {{-- update jumlah barang --}}
                                            <form
                                                action="{{ route('updateDetailPembelian', ['detailPembelian' => $b->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="pembelian_id" value="{{ $pembelian->id }}">
                                                <input type="hidden" name="id" value="{{ $b->id }}">
                                                <input type="hidden" name="barang_id" value="{{ $b->varianBarang->id }}">
                                                <input type="number" name="jumlah" class="w-[50px] text-center"
                                                    value="{{ $b->jumlah_item }}">
                                                <button type="submit">
                                                    <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>
                                                </button>
                                            </form>
                                            <form
                                                action="{{ route('destroyDetailPembelian', ['detailPembelian' => $b->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button>
                                                    <i class="fa fa-solid fa-trash bg-red-500 p-1 rounded-md"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            <tr>
                                <th class="border border-slate-600 p-1">Total Barang</th>
                                <th>{{ $jumlahItem }}</th>
                            </tr>
                        </tbody>
                    </table>

                    <div class="w-full flex justify-end my-2">
                        <a href="{{ route('simpanPembelian', ['pembelian' => $pembelian->id]) }}"
                            class="bg-green-400 p-1 rounded-lg w-[200px] font-bold text-center">Simpan</a>
                    </div>
                @else
                    <p class="text-center bg-red-300 ">Data barang pada pembelian ini tidak tersedia.</p>
                @endif
            </div>
        </div>
    </div>

    <!-- daftar barang yang dijual -->


    {{-- modal barang po --}}

    <div class="bg-black bg-opacity-50 fixed hidden inset-0 z-10 flex justify-center items-center" id="modalBarangPO">
        <div class="bg-gray-200 h-fit w-fit text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalBarangPO">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Daftar Barang</h3>
            <p>Purchase Order {{ tanggal_indonesia($purchaseOrder->created_at->format('Y m d')) }}</p>
            <div class="flex justify-center mb-5">
                <table>
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border border-slate-600 p-1">Nama Barang</th>
                            <th class="border border-slate-600 p-1">Jumlah Barang</th>
                            <th class="border border-slate-600 p-1">Sub total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder->detailPurchaseOrder as $po)
                            <tr>
                                <td class="border border-slate-600 p-1">{{ $po->barangSupplier->nama_barang }}</td>
                                <td class="border border-slate-600 p-1">{{ $po->jumlah_item }}</td>
                                <td class="border border-slate-600 p-1">Rp {{ format_uang($po->sub_total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        $(function() {

            $("#btnOpenModalBarangPO").click(function() {
                $("#modalBarangPO").removeClass("hidden")
            })
            $("#btnCloseModalBarangPO").click(function() {
                $("#modalBarangPO").addClass("hidden")
            })

        })
    </script>

</x-layoutAdmin>
