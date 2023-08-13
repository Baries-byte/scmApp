<x-layoutAdmin>
    <x-title>
        Daftar Pengembalian Barang
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <!-- search -->
        {{-- <div class="w-full flex justify-end bg-red-">
            <div>
                <form action="">
                    <input type="text" class="border rounded-lg p-1 my-2" name="search" placeholder="Cari barang..." />
                    <button type="submit" class="bg-primary p-1 text-white rounded-lg w-20">Cari</button>
                </form>
            </div>
        </div> --}}

        <table class="table table-auto border-collapse border border-slate-500 w-full">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Kode Purchase Order</th>
                    <th class="border border-slate-600">Kode Surat Jalan / Invoice</th>
                    <th class="border border-slate-600">Tanggal Purchase Order</th>
                    <th class="border border-slate-600">Tanggal Pengembalian</th>
                    <th class="border border-slate-600">Catatan</th>
                    <th class="border border-slate-600">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pengembalian as $b)
                    <tr class="relative">
                        <td class="border border-slate-600 p-1">{{ $b->purchaseOrder->kode_purchase_order }}</td>
                        <td class="border border-slate-600 p-1">{{ $b->purchaseOrder->kode_purchase_order_supplier }}
                        </td>
                        <td class="border border-slate-600 p-1">
                            {{ tanggal_indonesia($b->purchaseOrder->created_at->format('Y m d')) }}</td>
                        <td class="border border-slate-600 p-1">{{ tanggal_indonesia($b->created_at->format('Y m d')) }}
                        </td>
                        <td class="border border-slate-600 p-1">{{ $b->catatan }}
                        </td>
                        <td class="border border-slate-600 p-1 text-center">
                            <a href="{{ route('showPengembalian', ['pengembalian' => $b->id]) }}">Detail</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layoutAdmin>
