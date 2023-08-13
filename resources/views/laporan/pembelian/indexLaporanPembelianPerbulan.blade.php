<x-layoutAdmin>
    <x-title>
        Laporan Pembelian Bulan {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div class="my-5">
            <a target="_blank" href="{{ route('cetakLaporanPembelianPerbulan', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="bg-green-400 p-1 rounded-lg">Cetak Laporan</a>
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
            <!-- Pagination -->
            <div class="mt-5">
                {{ $pembelian->links('vendor.pagination.tailwind') }}
            </div>
        @else
            <p class="text-center bg-red-300 ">Data Pembelian belum tersedia</p>
        @endif
    </div>
</x-layoutAdmin>
