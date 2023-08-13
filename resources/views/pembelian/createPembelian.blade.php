<x-layoutAdmin>
    <x-title>
        Membuat Pembelian
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <h3 class="font-bold">Pilih Purchase Order</h3>

        <form action="" class="flex justify-end">
            <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari purchase order..." />
            <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20 my-2">Cari</button>
        </form>
        <div>
            <table class="table table-auto border-collapse border border-slate-500 w-full">
                <thead class="bg-slate-400">
                    <tr>
                        <th class="border border-slate-600">Tanggal</th>
                        <th class="border border-slate-600">Kode Order</th>
                        <th class="border border-slate-600">Supplier</th>
                        <th class="border border-slate-600">Total Item</th>
                        <th class="border border-slate-600">Total Harga</th>
                        <th class="border border-slate-600">Status</th>
                        <th class="border border-slate-600">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($purchaseOrder as $po)
                        <tr class="relative">
                            <td class="border border-slate-600 p-1">
                                {{ tanggal_indonesia($po->created_at->format('Y m d')) }}</td>
                            <td class="border border-slate-600 p-1">{{ $po->kode_purchase_order }}</td>
                            <td class="border border-slate-600 p-1">{{ $po->supplier->nama_perusahaan }}</td>
                            <td class="border border-slate-600 p-1">{{ $po->total_item }}</td>
                            <td class="border border-slate-600 p-1">Rp {{ format_uang($po->total_harga) }}</td>
                            <td class="border border-slate-600 p-1">{{ $po->status }}</td>
                            <td class="border border-slate-600 p-1 text-center">
                                <form action="{{ route('storePembelian') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="purchase_order_id" value="{{ $po->id }}">
                                    <button type="submit" class="hover:font-bold">Pilih</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Pagination -->
            <div class="my-5">
                {{ $purchaseOrder->links('vendor.pagination.tailwind') }}
            </div>
        </div>
    </div>
</x-layoutAdmin>
