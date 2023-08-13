<x-layoutAdmin>
    <x-title>
        Laporan Penjualan
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">

        {{-- form untuk tanggal input pilih bulan --}}
        <div class="bg-slate-200 p-5 my-2 w-1/2">
            <form action="{{ route('laporanPenjualanPerbulan') }}" method="GET" class="flex flex-col gap-y-1">
                <label for="bulan" class="font-bold">Pilih Bulan</label>
                <input type="month" id="bulan" name="bulan">
                <button class="bg-primary text-white p-1 rounded-lg">Laporan Bulan yang dipilih</button>
            </form>
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
        <div class="my-5">
            {{ $penjualan->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</x-layoutAdmin>
