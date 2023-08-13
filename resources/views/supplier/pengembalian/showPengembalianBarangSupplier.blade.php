<x-layoutAdmin>
    <x-title>
        Detail Pengembalian Barang PO {{ tanggal_indonesia($purchaseOrder->created_at->format('Y m d')) }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-10 md:mx-10">

        <div class=" flex flex-row w-full ">
            {{-- Data supplier --}}
            <div class="grid grid-cols-1 gap-y-5 md:grid-cols-2 md:gap-y-0">
                <!-- data supplier -->
                <div>
                    <h3 class="text-xl font-bold mb-5">Informasi Purchase Order</h3>
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
                        <p>
                            <span class="font-bold">Kode Surat Jalan / Invoice: </span>
                            {{ $purchaseOrder->kode_purchase_order_supplier }}
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
                                <td class="border border-slate-600 p-1 text-center">
                                    {{ $po->jumlah_item }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-layoutAdmin>
