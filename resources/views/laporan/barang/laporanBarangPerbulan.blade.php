<x-layoutAdmin>
    <x-title>
        Laporan Barang {{ $barang->nama_varian_barang }} Terjual Bulan
        {{ bulan_indonesia(ltrim($bulan, '0')) . ' ' . $tahun }}
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">
        <div class="my-5">
            <a target="_blank"
                href="{{ route('cetakLaporanBarangPerbulan', ['barang' => $barang, 'bulan' => $bulan, 'tahun' => $tahun]) }}"
                class="bg-green-400 p-1 rounded-lg">Cetak Laporan</a>
        </div>
        <table class="table table-auto border-collapse border border-slate-500 w-full">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Tanggal</th>
                    <th class="border border-slate-600">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataLaporanBarangPerbulan as $dl)
                    <tr>
                        <td class="border border-slate-600">{{ tanggal_indonesia($dl->created_at) }}</td>
                        <td class="border border-slate-600 text-center">{{ $dl->jumlah }}</td>
                    </tr>
                @endforeach
                <tr class="bg-slate-200">
                    <th class="border border-slate-600">Total barang terjual</th>
                    <th class="border border-slate-600">{{ $totalTerjual }}</th>
                </tr>
            </tbody>
        </table>
    </div>

</x-layoutAdmin>
