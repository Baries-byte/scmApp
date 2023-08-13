<x-layoutAdmin>
    <x-title>
        Laporan Penjualan Bulan {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div class="my-5">
            <a target="_blank" href="{{ route('cetakLaporanPenjualanPerbulan', ['bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="bg-green-400 p-1 rounded-lg">Cetak Laporan</a>
        </div>
        <table class="table table-auto border-collapse border border-slate-500 w-full">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Tanggal Penjualan</th>
                    <th class="border border-slate-600">Jumlah Item Terjual</th>
                    <th class="border border-slate-600">Pemasukan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan as $p)
                    <tr>
                        <td class="border border-slate-600">
                            {{ tanggal_indonesia($p->created_at->format('Y m d')) }}</td>
                        <td class="border border-slate-600 text-center">{{ $p->total_item }}</td>
                        <td class="border border-slate-600 text-center">Rp {{ format_uang($p->total_harga) }}</td>
                    </tr>
                @endforeach
                <tr class="bg-slate-300">
                    <th class="border border-slate-600">Total item Terjual</th>
                    <th class="border border-slate-600" colspan="2">{{ $totalItemTerjual }}</th>
                </tr>
                <tr class="bg-slate-300">
                    <th class="border border-slate-600">Total pemasukan</th>
                    <th class="border border-slate-600" colspan="2">Rp {{ format_uang($totalPemasukan) }}</th>
                </tr>
            </tbody>
        </table>
    </div>
</x-layoutAdmin>
