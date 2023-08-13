<x-layoutAdmin>
    <x-title>
        Laporan Barang {{ $barang->nama_varian_barang }} Terjual
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 md:mx-10">

        {{-- form untuk tanggal input pilih bulan --}}
        <div class="bg-slate-200 p-5 my-2 w-1/2">
            <form action="{{ route('LaporanPenjualanBarangPerbulan', ['barang' => $barang->id]) }}" method="GET"
                class="flex flex-col gap-y-1">
                <label for="bulan" class="font-bold">Pilih Bulan</label>
                <input type="month" id="bulan" name="bulan">
                <button class="bg-primary text-white p-1 rounded-lg">Laporan Bulan yang dipilih</button>
            </form>
        </div>

        <table class="table table-auto border-collapse border border-slate-500 w-full">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Tanggal</th>
                    <th class="border border-slate-600">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataLaporan as $dl)
                    <tr>
                        <td class="border border-slate-600">{{ tanggal_indonesia($dl->created_at) }}</td>
                        <td class="border border-slate-600 text-center">{{ $dl->jumlah }}</td>
                    </tr>
                @endforeach
                <tr class="bg-slate-200">
                    <th class="border border-slate-600">total barang terjual</th>
                    <th class="border border-slate-600">{{ $jumlahTerjual }}</th>
                </tr>
            </tbody>
        </table>
        <div class="my-5">
            {{ $dataLaporan->links('vendor.pagination.tailwind') }}
        </div>
    </div>

</x-layoutAdmin>
