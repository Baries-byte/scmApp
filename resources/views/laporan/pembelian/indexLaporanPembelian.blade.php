<x-layoutAdmin>
    <x-title>
        Laporan Pembelian
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">

        {{-- form untuk tanggal input pilih bulan --}}
        <div class="bg-slate-200 p-5 my-2 w-1/2">
            <form action="{{ route('indexLaporanPembelianPerbulan') }}" method="GET" class="flex flex-col gap-y-1">
                <label for="bulan" class="font-bold">Pilih Bulan</label>
                <input type="month" id="bulan" name="bulan">
                <button class="bg-primary text-white p-1 rounded-lg">Laporan Bulan yang dipilih</button>
            </form>
        </div>

        @if (count($pembelian) != 0)
            <table class="table table-auto border-collapse border border-slate-500 w-full">
                <thead class="bg-slate-400">
                    <tr>
                        <th class="border border-slate-600">Purchase Order</th>
                        <th class="border border-slate-600">Tanggal Purchase Order</th>
                        <th class="border border-slate-600">Total Item</th>
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
                    @endforeach
                    <tr class="bg-slate-400">
                        <th class="border border-slate-600" colspan="2">Jumlah total item</th>
                        <th class="border border-slate-600">{{ $totalItem }}</th>
                    </tr>
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
</x-layoutAdmin>
