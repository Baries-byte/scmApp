<x-layoutAdmin>
    <x-title>
        Daftar Purchase Order ke Supplier
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div class="w-full flex justify-between bg-red-">
            <a href="{{ route('createPurchaseOrder') }}" class="border rounded-lg p-1 my-2 bg-green-500">Buat Purchase
                Order</a>
            <div>
                <form action="">
                    <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari purchase order..." />
                    <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                </form>
            </div>
        </div>

        <div>
            @if (count($purchaseOrder) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Nama Perusahaan</th>
                            <th class="border border-slate-600">Tanggal Pemesanan</th>
                            <th class="border border-slate-600">Total Item</th>
                            <th class="border border-slate-600">Total Harga</th>
                            <th class="border border-slate-600">Status</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($purchaseOrder as $p)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">{{ $p->supplier->nama_perusahaan }}</td>
                                <td class="border border-slate-600 p-1">
                                    {{ tanggal_indonesia($p->created_at->format('Y m d')) }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    {{ $p->total_item }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    Rp {{ format_uang($p->total_harga) }}
                                </td>
                                <td class="border border-slate-600 p-1">
                                    <span
                                        class="{{ ($p->status == 'Dibatalkan' or $p->status == 'Ditolak') ? 'bg-red-600' : 'bg-green-400' }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('showPurchaseOrder', ['purchaseOrder' => $p->id]) }}">Detail
                                    </a>
                                </td>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="my-5">
                    {{ $purchaseOrder->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <p class="text-center bg-red-300 ">Data Purchase Order ke supplier belum tersedia</p>
            @endif
        </div>
    </div>
</x-layoutAdmin>
