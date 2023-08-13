<x-layoutAdmin>
    <x-title>
        Daftar Pembelian
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div class="w-full flex justify-between bg-red-">
            <a href="{{ route('createPembelian') }}" class="border rounded-lg p-1 my-2 bg-green-500">
                Tambah Pembelian
            </a>
        </div>

        <div>
            @if (count($pembelian) != 0)
                <table class="table table-auto border-collapse border border-slate-500 w-full">
                    <thead class="bg-slate-400">
                        <tr>
                            <th class="border border-slate-600">Purchase Order</th>
                            <th class="border border-slate-600">Tanggal Purchase Order</th>
                            <th class="border border-slate-600">Total Item</th>
                            <th class="border border-slate-600">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembelian as $p)
                            <tr class="relative">
                                <td class="border border-slate-600 p-1">{{ $p->purchaseOrder->kode_purchase_order }}
                                </td>
                                <td class="border border-slate-600 p-1">
                                    {{ tanggal_indonesia($p->purchaseOrder->created_at->format('Y m d')) }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    {{ $p->total_item }}
                                </td>
                                <td class="border border-slate-600 p-1 text-center">
                                    <a href="{{ route('showPembelian', ['pembelian' => $p->id]) }}">Detail
                                    </a>
                                </td>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="my-5">
                    {{ $pembelian->links('vendor.pagination.tailwind') }}
                </div>
            @else
                <p class="text-center bg-red-300 ">Data Pembelian belum tersedia</p>
            @endif
        </div>
    </div>
</x-layoutAdmin>
