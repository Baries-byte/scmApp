<x-layoutAdmin>
    <x-title>
        Detail Purchase Order {{ tanggal_indonesia($purchaseOrder->created_at) }}
    </x-title>
    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">

        <div class=" flex flex-row w-full ">
            {{-- Data supplier --}}
            <!-- data supplier -->
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-5">Informasi Supplier</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-1/2" />
                <div class="">
                    <p>
                        <span class="font-bold">Nama Perusahaan: </span>
                        {{ $purchaseOrder->supplier->nama_perusahaan }}
                    </p>
                    <p>
                        <span class="font-bold">Alamat Perusahaan: </span>
                        {{ $purchaseOrder->supplier->alamat }}
                    </p>
                    <p>
                        <span class="font-bold">Telepon Perusahaan: </span>
                        {{ $purchaseOrder->supplier->telepon }}
                    </p>
                    <p>
                        <span class="font-bold">Email: </span>
                        {{ $purchaseOrder->supplier->email }}
                    </p>
                    <p>
                        <span class="font-bold">Tanggal Purchase Order: </span>
                        {{ tanggal_indonesia($purchaseOrder->created_at->format('Y m d')) }}
                    </p>
                </div>
            </div>
            {{-- informasi purchase order --}}
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-5">Informasi Purchase Order</h3>
                <hr class="border border-t-4 -mt-5 mb-3 w-1/2" />
                <p>
                    <span class="font-bold">Status: </span>
                    {{ $purchaseOrder->status }}
                </p>
                @if ($purchaseOrder->kode_purchase_order_supplier == true)
                    <p>
                        <span class="font-bold">Nomor Surat Jalan / Invoice: </span>
                        {{ $purchaseOrder->kode_purchase_order_supplier }}
                    </p>
                @else
                    <form
                        action="{{ route('updateKodePOSupplierNomorSuratInvoice', ['purchaseOrder' => $purchaseOrder]) }}"
                        method="POST">
                        @csrf
                        <label for="nomor_surat" class="font-bold">Nomor Surat Jalan / Invoice:</label>
                        <input type="text" class="border border-black" name="kode_surat">
                        <button class="bg-green-400 p-1 rounded-lg">Simpan</button>
                    </form>
                @endif

                <p>
                    <span class="font-bold">Surat Jalan: </span>
                    @if ($purchaseOrder->foto_surat_jalan != true)
                        Surat Jalan belum tersedia
                        @if ($purchaseOrder->status == 'Diproses')
                            <form action="{{ route('uploadSuratJalan', ['purchaseOrder' => $purchaseOrder->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="surat_jalan">
                                @error('surat_jalan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <button class="bg-green-400 p-1 rounded-lg">Simpan</button>
                            </form>
                        @endif
                    @else
                        <button id="btnOpenModalSuratJalan" class="block">
                            <img src="{{ asset('storage/' . $purchaseOrder->foto_surat_jalan) }}" alt="surat jalan"
                                width="200px" height="200px">
                        </button>
                    @endif
                </p>
                @if ($purchaseOrder->foto_bukti_penerimaan == true)
                    <p>
                        <span class="font-bold">Bukti Peneriamaan: </span>
                        <button id="btnOpenModalBuktiPenerimaan" class="block">
                            <img src="{{ asset('storage/' . $purchaseOrder->foto_bukti_penerimaan) }}"
                                alt="Bukti Penerimaan" width="200px" height="200px">
                        </button>
                    </p>

                    <p>
                        <span class="font-bold">Invoice Pembelian: </span>
                        @if ($purchaseOrder->foto_invoice_pembelian != true)
                            Invoice Pembelian belum tersedia
                            <form action="{{ route('uploadInvoice', ['purchaseOrder' => $purchaseOrder->id]) }}"
                                method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="invoice_pembelian">
                                @error('invoice_pembelian')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <button class="bg-green-400 p-1 rounded-lg">Simpan</button>
                            </form>
                        @else
                            <button id="btnOpenModalInvoicePembelian" class="block">
                                <img src="{{ asset('storage/' . $purchaseOrder->foto_invoice_pembelian) }}"
                                    alt="invoice pembelian" width="200px" height="200px">
                            </button>
                        @endif
                    </p>
                @endif
            </div>
        </div>

        <hr class="my-5 border-t-2 border-t-slate-500" />

        <!-- daftar barang yang dipesan -->
        <div>
            <h3 class="text-xl font-bold mb-5">Barang yang dipesan</h3>
            <div class="w-full overflow-x-auto">
                <table class="table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Jumlah Barang</th>
                            <th class="border border-slate-600">Harga</th>
                            <th class="border border-slate-600">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder->detailPurchaseOrder as $po)
                            <tr>
                                <td class="border border-slate-600 p-1">{{ $po->barangSupplier->nama_barang }}</td>
                                <td class="border border-slate-600 p-1 w-1/4 text-center">
                                    {{ $po->jumlah_item }}
                                </td>
                                <td class="border border-slate-600 p-1 w-1/4 text-center">
                                    Rp {{ format_uang($po->barangSupplier->harga_jual) }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    Rp {{ format_uang($po->sub_total) }}
                                </td>
                            </tr>
                        @endforeach
                        <tr class="bg-slate-200">
                            <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="1">Total jumlah
                                barang</th>
                            <th class="border border-slate-600 text-xl py-2" colspan="3">
                                {{ $purchaseOrder->total_item }}</th>
                        </tr>
                        <tr class="bg-slate-200">
                            <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="a">Total harga
                            </th>
                            <th class="border border-slate-600 text-xl py-2" colspan="3">Rp
                                {{ format_uang($purchaseOrder->total_harga) }}</th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        @if ($purchaseOrder->status == 'Menunggu konfirmasi supplier')
            <div class="w-full flex justify-end my-2">
                <a href="{{ route('prosesPurchaseOrderSupplier', ['purchaseOrder' => $purchaseOrder->id]) }}"
                    class="bg-primary rounded-lg py-1 px-2 text-white w-fit text-center mr-2">
                    Proses
                </a>
                <a href="{{ route('tolakPurchaseOrderSupplier', ['purchaseOrder' => $purchaseOrder->id]) }}"
                    class="bg-red-600 rounded-lg py-1 px-2 text-white w-fit text-center">
                    Tolak
                </a>
            </div>
        @endif
    </div>

    {{-- Modal surat jalan --}}
    <div class="bg-black bg-opacity-50 fixed hidden inset-0 z-10 flex justify-center items-center" id="modalSuratJalan">
        <div class="bg-gray-200 h-fit w-3/4 text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalSuratJalan">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Surat Jalan</h3>
            <img src="{{ asset('storage/' . $purchaseOrder->foto_surat_jalan) }}" alt="surat jalan">
        </div>
    </div>

    {{-- Modal bukti penerimaan --}}
    <div class="bg-black bg-opacity-50 fixed hidden inset-0 z-10 flex justify-center items-center"
        id="modalBuktiPenerimaan">
        <div class="bg-gray-200 h-fit w-3/4 text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalBuktiPenerimaan">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Bukti Penerimaan</h3>
            <img src="{{ asset('storage/' . $purchaseOrder->foto_bukti_penerimaan) }}" alt="Bukti Penerimaan">
        </div>
    </div>


    {{-- Modal invoice pembelian --}}
    <div class="bg-black bg-opacity-50 fixed hidden inset-0 z-10 flex justify-center items-center"
        id="modalInvoicePembelian">
        <div class="bg-gray-200 h-fit w-3/4 text-center py-2 px-5 rounded-lg overflow-auto">
            <div class="w-full px-3 text-right">
                <button id="btnCloseModalInvoicePembelian">
                    <i class="fa fa-close text-black"></i>
                </button>
            </div>
            <h3 class="font-bold text-2xl my-3">Invoice Pembelian</h3>
            <img src="{{ asset('storage/' . $purchaseOrder->foto_invoice_pembelian) }}" alt="Invoice Pembelian">
        </div>
    </div>
    <script>
        $(function() {
            $("#btnOpenModalSuratJalan").click(function() {
                $("#modalSuratJalan").removeClass("hidden")
            })
            $("#btnCloseModalSuratJalan").click(function() {
                $("#modalSuratJalan").addClass("hidden")
            })

            $("#btnOpenModalBuktiPenerimaan").click(function() {
                $("#modalBuktiPenerimaan").removeClass("hidden")
            })
            $("#btnCloseModalBuktiPenerimaan").click(function() {
                $("#modalBuktiPenerimaan").addClass("hidden")
            })

            $("#btnOpenModalInvoicePembelian").click(function() {
                $("#modalInvoicePembelian").removeClass("hidden")
            })
            $("#btnCloseModalInvoicePembelian").click(function() {
                $("#modalInvoicePembelian").addClass("hidden")
            })
        })
    </script>
</x-layoutAdmin>
