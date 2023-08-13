<x-layoutAdmin>
    <x-title>
        Buat Pengembalian
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">

        <div class=" flex flex-row w-full ">
            {{-- Data supplier --}}
            <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-y-0">
                <!-- data supplier -->
                <div>
                    <h3 class="text-xl font-bold mb-5">Informasi Purchase</h3>
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
                        <p>
                            <span class="font-bold">Kode Purchase Order: </span>
                            {{ $purchaseOrder->kode_purchase_order }}
                        </p>
                        @if ($pengembalian->catatan == true)
                            <p>
                                <span class="font-bold">Catatan pengembalian: </span>
                                {{ $pengembalian->catatan }}
                            </p>
                        @else
                            <form
                                action="{{ route('updateCatatanPengembalian', ['pengembalian' => $pengembalian->id]) }}"
                                method="POST">
                                @csrf
                                <label for="catatan" class="font-bold">Catatan Pengembalian</label>
                                <input type="text" class="border border-black" name="catatan">
                                <button class="bg-green-400 p-1 rounded-lg">Simpan</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- daftar barang yang disupply -->
            <div class="w-1/2">
                <h3 class="text-xl font-bold mb-3">Pilih Barang dari Supplier</h3>
                <div class="w-full overflow-x-auto">
                    <table class="table-auto border-collapse border border-slate-500 w-full">
                        <thead class="bg-gray-300">
                            <tr>
                                <th class="border border-slate-600">Nama Barang</th>
                                <th class="border border-slate-600">Merek</th>
                                <th class="border border-slate-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($barangSupplier as $b)
                                <tr>
                                    <td class="border border-slate-600 p-1">{{ $b->nama_barang }}</td>
                                    <td class="border border-slate-600 p-1">{{ $b->merek }}</td>
                                    <td class="border border-slate-600 p-1 text-center">
                                        <form action="{{ route('storePengembalianDetail') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="pengembalian_id"
                                                value="{{ $pengembalian->id }}">
                                            <input type="hidden" name="barang_supplier_id"
                                                value="{{ $b->id }}">
                                            <input type="number" name="jumlah_barang" class="w-[50px] text-center"
                                                value="1">
                                            <button type="submit">
                                                <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="my-5">
                        {{ $barangSupplier->links('vendor.pagination.tailwind') }}
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5 border-t-2 border-t-slate-500" />

        <!-- daftar barang yang dipesan -->
        <div>
            <h3 class="text-xl font-bold mb-5">Barang yang dikembalikan</h3>
            <div class="w-full overflow-x-auto">
                <table class="table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-gray-300">
                        <tr>
                            <th class="border border-slate-600">Nama Barang</th>
                            <th class="border border-slate-600">Jumlah Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalianDetail as $po)
                            <tr>
                                <td class="border border-slate-600 p-1">
                                    {{ $po->barangSupplier->nama_barang }}
                                </td>
                                <td class="border border-slate-600 p-1 w-1/4">
                                    <div class="flex">
                                        <form
                                            action="{{ route('updatePengembalianDetail', ['pengembalianDetail' => $po->id]) }}"
                                            method="POST">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="jumlah_barang" class="text-center"
                                                value="{{ $po->jumlah_item }}">
                                            <button type="submit">
                                                <i class="fa fa-solid fa-plus bg-green-400 p-1 rounded-md"></i>
                                            </button>
                                        </form>
                                        <form method="POST"
                                            action="{{ route('destroyPengembalianDetail', ['pengembalianDetail' => $po->id]) }}"
                                            class="mx-1">
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
                        {{-- <tr class="bg-slate-200">
                            <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="1">Total jumlah
                                barang</th>
                            <th class="border border-slate-600 text-xl py-2" colspan="3">{{ $totalItem }}</th>
                        </tr>
                        <tr class="bg-slate-200">
                            <th class="border border-slate-600 text-left text-xl px-1 py-2" colspan="1">Total harga
                            </th>
                            <th class="border border-slate-600 text-xl py-2" colspan="3">Rp
                                {{ format_uang($totalHarga) }}</th>
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>

        <div class="w-full flex justify-end my-2">
            <a href="{{ route('simpanPengembalian', ['pengembalian' => $pengembalian->id]) }}"
                class="bg-primary rounded-lg p-1 text-white w-[150px] text-center">Simpan</a>
        </div>
    </div>
</x-layoutAdmin>
