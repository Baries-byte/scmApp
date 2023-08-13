<x-layoutAdmin>
    <x-title>
        Perhitungan SMA
    </x-title>

    <div class="mx-5 mt-5 border-4 p-4 mb-5 md:mx-10">
        <h1 class="font-bold ">Data Penjualan Barang</h1>
        <h2>Barang: {{ $barang->nama_barang }}</h2>
        <table class="table table-auto border-collapse border border-slate-500 w-1/2">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Bulan</th>
                    <th class="border border-slate-600">Tahun</th>
                    <th class="border border-slate-600">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPenjualanBarang as $item)
                    <tr>
                        <td class="border border-slate-600 text-center">{{ $item->bulan }}</td>
                        <td class="border border-slate-600 text-center">{{ $item->tahun }}</td>
                        <td class="border border-slate-600 text-center">{{ $item->jumlah }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr class="my-5 border-t-2 border-t-slate-500" />

        <h1 class="font-bold">Data Prediksi Barang Selama Setahun</h1>

        {{-- {{ $dataPrediksiSMASetahun }} --}}
        <table class="table table-auto border-collapse border border-slate-500 w-[200px]">
            <thead class="bg-slate-400">
                <tr>
                    <th class="border border-slate-600">Prediksi Penjualan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataPrediksiSMASetahun as $prediksi)
                    <tr>
                        <td class="border border-slate-600 text-center">{{ $prediksi }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="font-bold text-center">{{ $totalPrediksiSetahun }}</td>
                </tr>
            </tbody>
        </table>
    </div>

</x-layoutAdmin>
